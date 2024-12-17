<?php

namespace App\Http\Controllers;

use App\Models\comisions;
use App\Models\orders;
use App\Models\records;
use App\Models\types;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    //
    public function index()
    {
        $user_id = Auth::user()->id;
        // $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'order_belongsTo', 'orders.comision_id', 'order_createdBy', 'comision_name', 'order_status', 'users.name')
        //     ->where('order_createdBy', $user)->orWhere('order_status', 2)->orWhere('order_status', 3)
        //     ->leftJoin('comisions', 'comisions.comision_id', 'orders.comision_id')
        //     ->leftJoin('Users', 'users.id', 'orders.order_createdBy')
        //     ->get();
        $user_rol = Auth::user()->rol_id;
        

        if ($user_rol == 6) {
            $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'type_id', 'order_belongsTo', 'comision_id', 'order_createdBy', 'order_status')
                ->orderBy('order_date', 'desc')
                ->get();
        } elseif ($user_rol == 5) {
            $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'type_id', 'order_belongsTo', 'comision_id', 'order_createdBy', 'order_status')
                ->where('order_createdBy', $user_id)->orWhere('order_status', 2)->orWhere('order_status', 3)
                ->orderBy('order_date', 'desc')
                ->get();
        } 
        
        
        //dd($orders);
        
        $admins = User::select('id', 'name')->where('user_status', 1)->where('rol_id', 5)->get();
        
        // $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'comision_id')
        //     ->where('order_createdBy', $user)->orWhere('order_status', 2)->orWhere('order_status', 3)
        //     ->with(['RComOrders' => function($query) {
        //         $query->orderBy('comision_id','desc');
        //     }])->get();
        // dd($admins);
        return view('orders.indexOrders', compact('orders', 'admins'));
    }

    public function newOrder()
    {
        $comisions = comisions::where('comision_status', 1)->where('comision_id', '!=', 1)->orderBy('comision_name')->get();
        $types = types::where('type_status', 1)->get();
        // foreach ($comisions as $comision) {
        //     $comision->comision_name = strtoupper($comision->comision_name);
        // }
        return view('orders.newOrder', compact('comisions', 'types'));
    }

    public function saveOrder(Request $request)
    {
        //dd($request);
        // $request->validate([
        //     'file' => 'required|file|mimes:pdf'
        // ]);

        $order = new orders();
        
        if ($request->orderFile) {
            $request->validate([
                'orderFile' => 'required|file|mimes:pdf'
            ]);
            $fileName =  date("d-m-Y").'_'.$request->file('orderFile')->getClientOriginalName();
            $filePath = $request->file('orderFile')->storeAs('orders', $fileName, 'public');
            $order->order_document = $fileName;
            $order->order_documentPath = '/storage/'.$filePath;

            $destinationPath = public_path('/storage/orders');
            $document = $request->file('orderFile');
            // $document = $request->orderFile;
            $document->move($destinationPath,$fileName);
        }
        
        $order->order_subject = strtolower($request->subject);
        $order->order_date = $request->date;
        
        $order->order_belongsTo = $request->belongsTo;
        if ($request->belongsTo == 2) {
            $order->comision_id = 1;
            $order->type_id = $request->types;
        } else {
            $order->comision_id = $request->comision;
            $order->type_id = 1;
        }
        if ($order->type_id == 4) {
            $order->order_status = 5;
        }
        $order->order_createdBy = Auth::user()->id;
        //dd($order);
        $order->save();
        return redirect()->route('content.index', $order->order_id)->with('success', 'Orden correctamente creada.');
        
    }

    public function updateStatusOrder(Request $request)
    {
        // dd($request);
        $order = orders::find($request->order_id);

        $order->order_status = $request->status;
        $order->save();

        return redirect()->route('order.index')->with('success', 'Órden actualizada correctamente.');
    }

    public function disableOrder($id)
    {
        // dd($id);
        $order = orders::find($id);
        $order->order_status = 4;
        $order->save();

        return redirect()->route('order.index')->with('success', 'Órden actualizada correctamente.');
    }

    public function enableOrder($id)
    {
        // dd($request);
        $order = orders::find($id);
        $order->order_status = 1;
        $order->save();

        return redirect()->route('order.index')->with('success', 'Órden actualizada correctamente.');
    }

    public function disabledOrders()
    {
        // dd($request);
        $orders = orders::all()->where('order_status', 4);

        return view('orders.disabledOrders', compact('orders'))->with('success', 'Órden actualizada correctamente.');
    }

    public function GPHCOOrdersView() {
        $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'order_belongsTo', 'comision_id', 'order_createdBy')
            ->where('order_status', 3)
            ->where('type_id', 1)
            ->where('comision_id', '1')
            ->get();
        $title = 'Lista de órdenes ordinarias';
        return view('orders.GPindexOrders', compact('orders', 'title'));
    }

    public function GPHCEOOrdersView() {
        $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'order_belongsTo', 'comision_id', 'order_createdBy')
            ->where('order_status', 3)
            ->where('type_id', 2)
            ->where('comision_id', '1')
            ->get();
        $title = 'Lista de órdenes extraordinarias';
        return view('orders.GPindexOrders', compact('orders', 'title'));
    }

    public function GPHCSOrdersView() {
        $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'order_belongsTo', 'comision_id', 'order_createdBy')
            ->where('order_status', 3)
            ->where('type_id', 3)
            ->where('comision_id', '1')
            ->get();
        $title = 'Lista de órdenes solemnes';
        return view('orders.GPindexOrders', compact('orders', 'title'));
    }

    public function GPCOrdersView() {
        $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'order_belongsTo', 'comision_id', 'order_createdBy')
            ->where('order_status', 3)
            ->where('comision_id', '>', '1')
            ->get();
        $title = 'Lista de órdenes de las comisiones';
        return view('orders.GPindexOrders', compact('orders', 'title'));
    }

    public function changeOrderOwner(Request $request) {
        //dd($request);

        $order = orders::find($request->order);
        $order->order_createdBy = $request->belongsTo;
        $order->save();

        return redirect()->route('order.index')->with('success', 'Se cambió el encargado correctamente.');
    }

    public function updateOrder(Request $request){
        //dd($request);
        $order = orders::find($request->order);
        $order->order_subject = $request->name;
        $order->order_date = $request->date;
        if ($request->comision) {
            $order->comision_id = $request->comision;
        }
        //dd($order);
        $order->save();

        return redirect()->route('order.index')->with('success', 'Se cambió la fecha y hora correctamente.');
    }

    public function loadDocumentOrder(Request $request) {
        //dd($request);
        $request->validate([
            'contentFile' => 'required|file|mimes:pdf'
        ]);
        $order = orders::find($request->id);

        $fileName =  date("d-m-Y").'_'.$request->file('contentFile')->getClientOriginalName();
        $filePath = $request->file('contentFile')->storeAs('orders', $fileName, 'public');
        $order->order_document = $fileName;
        $order->order_documentPath = '/storage/'.$filePath;

        $destinationPath = public_path('/storage/orders');
        $document = $request->file('contentFile');
        $document->move($destinationPath,$fileName);

        $order->save();

        return redirect()->route('content.index', $order->order_id)->with('success', 'Comisión agregada correctamente');
    }

    public function deleteDocumentOrder($id) {
        //dd($subcontent_id);
        $order = orders::find($id);
        $oldFilePath = $order->order_documentPath;
        try {
            if ($oldFilePath) {
                $currentTime = Carbon::now()->subHour()->format('H_i_m');
                $storage = $order->order_document;
                Storage::move('/public/orders/'.$storage, '/public/orders/DOWN-'.$currentTime.'-'.$storage);
                //dd(Storage::move('/public/subcontent/'.$storage, '/public/subcontent/DOWN-'.$currentTime.'-'.$storage));
            }
            // Storage::delete($content->content_documentPath);
            
            $order->order_document = null;
            $order->order_documentPath = null;
            // dd(Storage::allDirectories(), Storage::allFiles('/public/content/'));
            // dd('/storage/content/DOWN-'.$storage, $change, public_path().'/storage/content/'.$storage , Storage::delete('/storage/content/'.$storage));
            $order->save();
    
            return redirect()->route('content.index', $order->order_id)->with('success', 'Documento del subcontenido eliminado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('content.index', $order->order_id)->with('error', 'Error en el documento.');
        }
        
    }

    public function iRIndex() {
        // dd($id);
        $user = User::find(Auth::user()->id);

        // dd($user);
        // $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'order_belongsTo', 'comision_id', 'order_createdBy', 'order_status')
        //     ->where('comision_id', 2)->orWhere('order_status', 3)
        //     ->orderBy('order_date', 'desc')
        //     ->get();
        //     dd($orders);
        $user_isIn = records::where('record_status', 1)->where('user_id', $user->id)->pluck('comision_id');
        //dd($user_isIn);
        if ($user->rol_id == 1 || $user->rol_id == 4) {
            $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'type_id', 'order_belongsTo', 'comision_id', 'order_createdBy', 'order_status')
                
                ->where('order_status', 5)
                ->whereIn('comision_id', $user_isIn)
                ->orWhere('order_status', 2)
                ->whereIn('comision_id', $user_isIn)
                ->orWhere('order_status', 3)
                ->orderBy('order_date', 'desc')
                ->get();
        } else {
            $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'type_id', 'order_belongsTo', 'comision_id', 'order_createdBy', 'order_status')
                ->where('order_status', 2)
                ->whereIn('comision_id', $user_isIn)
                ->orWhere('order_status', 3)
                ->orderBy('order_date', 'desc')
                ->get();
        }
        
        
        //dd($orders);
        return view('orders.iRIndexOrders', compact('orders'));
    }


}
