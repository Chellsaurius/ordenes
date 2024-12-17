<?php

namespace App\Http\Controllers;

use App\Models\contents;
use App\Models\orders;
use App\Models\Pending;
use App\Models\Standing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendingController extends Controller
{
    //
    public function index() {
        //dd('holiwis');
        $pendings = Pending::select('pending_id', 'pending_description', 'pending_document', 'standing_id')
            ->where('pending_id', '<>', 1)
            ->where('pending_status', 1)
            ->where('standing_id', '<', 3)
            ->get();

        $standings = Standing::all()->where('standing_status', 1)->where('standing_id', '>', 2);
        // dd($pendings, $standings);
        return view('pending.pendingContent', compact('pendings', 'standings'));
    }

    public function newPending() {
        return view('pending.newPending');
    }

    public function saveNewPending(Request $request) {
        //dd($request);

        $pending = new Pending();
        $pending->pending_description = $request->description;

        if ($request->file) {
            $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('pending', $fileName, 'public');
            $pending->pending_document = $fileName;
            $pending->pending_documentPath = '/storage/'.$filePath;

            $destinationPath = public_path('/storage/pending');
        $document = $request->file('file');
        $document->move($destinationPath,$fileName);
        }
        $pending->standing_id = 1;
        $pending->save();

        return redirect()->route('pending.index')->with('success', 'Punto creado correctamente.');
    }

    public function disablePending($id) {
        $pending = Pending::find($id);
        $pending->pending_status = 2;
        $pending->save();

        return redirect()->route('pending.index')->with('success', 'Punto inhabilitado correctamente.');
    }

    public function enablePending($id) {
        $pending = Pending::find($id);
        $pending->pending_status = 1;
        $pending->save();

        return redirect()->route('pending.index')->with('success', 'Punto habilitado correctamente.');
    }

    public function disabledPendingsList() {
        $pendings = Pending::select('pending_id', 'pending_description', 'pending_document', 'standing_id')
            ->where('pending_status', 2)
            ->get();

        return view('pending.disabledPendings', compact('pendings')); 
    }

    public function updatePending(Request $request) {
        // dd($request);
        $pending = Pending::find($request->id);
        $pending->pending_description = $request->description;
        
        if ($request->file) {
            $oldFilePath = $pending->pending_document; // Replace with the actual path to the file
            $newFilename = pathinfo($oldFilePath, PATHINFO_FILENAME) . '.pdf-DOWN';
            $newFilePath = '/storage/pending/' . $newFilename;

            try {
                if ($oldFilePath) {
                    Storage::move($pending->pending_document, $newFilePath);
                    $storage = $pending->pending_document;
                    $currentTime = Carbon::now()->subHour()->format('H_i_m');
                    
                    Storage::move('/public/pending/'.$storage, '/public/pending/DOWN-'.$currentTime.'-'.$storage);
                }

                $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('pending', $fileName, 'public');
                $pending->pending_document = $fileName;
                $pending->pending_documentPath = '/storage/'.$filePath;

                $destinationPath = public_path('/storage/pending');
                $document = $request->file('file');
                $document->move($destinationPath,$fileName);
            }
            catch (\Throwable $th) {
                return redirect()->route('pending.index', compact($th))->with('error', 'Error en el documento.');
            }
        }
        if ($request->status) {
            $pending->standing_id = $request->status;
            $pending->pending_standing = $request->standing;
            
        }
        // dd($pending);
        $pending->save();
        return redirect()->route('pending.index')->with('success', 'Punto editado correctamente.');
    }

    public function pendingGetOrders() {
        $orders = orders::select('order_id', 'order_subject')
            ->where('order_status', 1)
            ->orWhere('order_status', 5)
            ->get();

        return response()->json(($orders), 200);
    }

    public function pendingGetContent($id) {
        $contents = contents::select('content_id', 'content_number', 'content_description')
            ->where('content_status', 1)
            ->where('order_id', $id)
            ->orderBy('content_number', 'asc')
            ->get();

        return response()->json(($contents), 200);
    }

    public function loadPending(Request $request) {
        // dd($request);
        $pending = Pending::find($request->id);
        // $order = orders::find($request->order);
        $contents = contents::where([
                ['order_id', '=', $request->order],
            ])
            ->orderBy('content_number', 'asc')
            ->get();
        $pivot = contents::find($request->contents);
        //dd($pending, $contents, $pivot);
        $flag = 0;
        $point = $pivot->content_number + 1;
        foreach ($contents as $content) {
            if ($content->content_number == $point) {
                $newContent = new contents();
                $newContent->content_number = $content->content_number;
                $newContent->content_description = $pending->pending_description;

                if ($pending->pending_document) {
                    $newContent->content_document = $pending->pending_document;
                    $newContent->content_documentPath = $pending->pending_documentPath;
                }
                $newContent->order_id = $content->order_id;
                $flag = 1;
                // dd($newContent);
                $newContent->save();
            } 
            if($flag == 1) {
                $content->content_number = $content->content_number + 1;
                $content->save();
                // dd($content);
            }
            
        }
        // dd($contents->last()->content_number);
        if ($flag == 0) {
            $newContent = new contents();
                $newContent->content_number = $contents->last()->content_number + 1;
                $newContent->content_description = $pending->pending_description;
                if ($pending->pending_document) {
                    $newContent->content_document = $pending->pending_document;
                    $newContent->content_documentPath = $pending->pending_documentPath;
                }
                $newContent->order_id = $content->order_id;
                //dd($newContent);
                $newContent->save();
        }
        // dd('¿terminó?');
        $pending->standing_id = 2;
        $pending->order_id = $request->order;
        $pending->content_id = $request->contents;
        $pending->save();

        return redirect()->route('pending.index')->with('success', 'Punto cargado correctamente, pasa a revisión.');
    }

    public function aceptedPendingsList() {
        $pendings = Pending::select('pending_id', 'pending_description', 'pending_document', 'standing_id', 'pending_standing', 'order_id')
            ->where('standing_id', 3)
            ->where('pending_status', 1)
            ->get();

        return view('pending.aceptedPendings', compact('pendings')); 
    }

    public function rejectedPendingsList() {
        $pendings = Pending::select('pending_id', 'pending_description', 'pending_document', 'standing_id', 'pending_standing', 'order_id')
            ->where('standing_id', 4)
            ->where('pending_status', 1)
            ->get();
        
        return view('pending.rejectedPendings', compact('pendings')); 
    }


}
