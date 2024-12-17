<?php

namespace App\Http\Controllers;

use App\Models\Certificates;
use App\Models\Documents;
use App\Models\orders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CertificatesController extends Controller
{
    //

    // public function index() {
    //     //dd('holi');
    //     $certificates = Certificates::all()->where('certificate_status', 1);
    //         // ->paginate($perPage = 4, $columns = ['*'], $pageName = 'certificates');
    //         // ->paginate(10);

    //     return view('certificates.indexcertificates', compact('certificates'));

    // }

    public function index() : View {

        //$certificates = Certificates::where('certificate_status', 1)->paginate(10);
        $certificates = DB::table('certificates')
            ->join('orders', 'certificates.order_id', 'orders.order_id')
            ->select('certificate_id', 'certificate_document', 'certificate_date', 'certificate_administration', 'certificates.order_id', 'order_subject')
            ->where('certificate_status', 1)
            ->where('order_status', 3)
            ->paginate(10);

        //dd($certificates);
        return view('certificates.indexCertificates', compact('certificates') );
    }

    public function newCertificates() {
        //dd('holi');
        $certificates = Certificates::where('certificate_status', 1)->pluck('order_id');
        
        $orders = orders::select('order_id', 'order_subject', 'order_date')
            ->whereNotIn('order_id', $certificates)
            ->where('order_status', 3)->get();
            
        return view('certificates.newCertificate', compact('orders'));
    }

    public function saveCertificates(Request $request) {
        //dd($request);
        $request->validate([
            'administration' => 'required|max:255',
            'order' => 'required|max:255',
            'date' => 'required',
            'file' => 'required|file|mimes:pdf'
        ]);

        $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('certificates', $fileName, 'public');

        $destinationPath = public_path('/storage/certificates');
        $document = $request->file('file');
        $document->move($destinationPath,$fileName);

        $certificate = new Certificates();
        $certificate->certificate_document = $fileName;
        $certificate->certificate_documentPath = '/storage/'.$filePath;
        $certificate->certificate_date = $request->date;
        $certificate->certificate_administration = $request->administration;
        $certificate->order_id = $request->order;
        //dd($certificate);
        $certificate->save();

        return redirect()->route('certificates.index')->with('success', 'El acta se cargó correctamente.');
    }

    public function disableCertificates($id) {
        //dd($id);
        $certificate = Certificates::find($id);
        $certificate->certificate_status = 2;
        $certificate->save();

        return redirect()->route('certificates.index')->with('success', 'Registro dado de baja correctamente.');
    }

    public function enableCertificates($id) {
        //dd($id);
        $certificate = Certificates::find($id);
        $certificate->certificate_status = 1;
        $certificate->save();

        return redirect()->route('certificates.index')->with('success', 'Registro dado de alta correctamente.');
    }

    public function disabledCertificatesList() {
        //dd('$request');
        $certificates = Certificates::all()->where('certificate_status', 2);

        return view('certificates.disabledCertificates', compact('certificates'));
    }

    public function AJAXOrdersList(Request $request) {
        // aquí cambiar, me debe de dar todas las órdenes que no tengan asignada una acta 
        // $certificates = Certificates::where('certificate_status', 1)->pluck('order_id');
        
        // $orders = orders::select('order_id', 'order_subject', 'order_date')
        //     ->whereNotIn('order_id', $certificates)
        //     ->where('order_status', 3)->get();

        $certificate = Certificates::find($request->id);
        $orders = orders::select('order_id', 'order_subject', 'order_date')
            ->whereNotIn('order_id', $certificate->order_id)
            ->where('order_status', 3)->get();
        //dd($orders);
        return response()->json(($orders), 200);
        
    }

    public function editCertificate(Request $request) {
        //dd($request);
        $certificate = Certificates::find($request->certificate);
        $certificate->certificate_administration = $request->administration;
        $certificate->certificate_date = $request->date;
        if ($request->order) {
            $certificate->order_id = $request->order;
        }
        
        if ($request->file) {
            $oldFilePath = $certificate->certificate_documentPath;
            try {
                if ($oldFilePath) {
                    $currentTime = Carbon::now()->subHour()->format('H_i_m');
                    $storage = $certificate->certificate_document;
                    Storage::move('/public/certificates/'.$storage, '/public/certificates/DOWN-'.$currentTime.'-'.$storage);
                    //dd(Storage::move('/public/subcontent/'.$storage, '/public/subcontent/DOWN-'.$currentTime.'-'.$storage));
                }
                // Storage::delete($content->content_documentPath);
                
                // $certificate->certificate_document = null;
                // $certificate->certificate_documentPath = null;
                // dd(Storage::allDirectories(), Storage::allFiles('/public/content/'));
                // dd('/storage/content/DOWN-'.$storage, $change, public_path().'/storage/content/'.$storage , Storage::delete('/storage/content/'.$storage));
                // $certificate->save();
                $fileName =  date("d-m-Y").'_'.$request->file('file')->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('certificates', $fileName, 'public');

                $destinationPath = public_path('/storage/certificates');
                $document = $request->file('file');
                $document->move($destinationPath,$fileName);
                
                $certificate->certificate_document = $fileName;
                $certificate->certificate_documentPath = $filePath;
            } 
            catch (\Throwable $th) {
                return redirect()->route('certificates.index')->with('error', 'Error en el documento.');
            }
        }
        //dd($certificate);
        $certificate->save();

        return redirect()->route('certificates.index')->with('success', 'Acta modificada correctamente');
    }

    public function indexSearch($text)  {
        //dd($text);
        if ($text == 0) {
            //dd('ta vacío');
            return redirect()->route('certificates.index');
        }
        // $certificates = Certificates::where(function($query) use ($text) {
        //     $query->where('certificate_date', 'LIKE', '%$text%')
        //     ->orWhere('certificate_administration', 'LIKE', '%$text%')
        //     ->orWhere('certificate_date', 'LIKE', '%$text%');
            
        // })->paginate(10);

        // $certificates = DB::table('certificates')
        //     ->where(function($query) use ($text) {
        //     $query->where('certificate_date', 'LIKE', '%{$text}%')
        //     ->orWhere('certificate_administration', 'LIKE', '%{$text}%')
        //     ->orWhere('certificate_date', 'LIKE', '%{$text}%');
        // })  ->paginate(10);

        // $certificates = DB::table('certificates')
        //     ->where('certificate_date', 'LIKE', '%'.$text.'%')
        //     ->orWhere('certificate_administration', 'LIKE', '%'.$text.'%')
        //     ->orWhere('certificate_date', 'LIKE', '%'.$text.'%')
        //     ->paginate(10);

        // $certificates2 = Certificates::whereLike('certificate_date', $text)
        //     ->whereLike('certificate_administration', $text)
        //     ->whereLike('certificate_date', $text)
        //     ->paginate(10);

        // $certificates = Certificates::where('certificate_date', 'LIKE', "%{$text}%")
        //     ->orWhere('certificate_administration', 'LIKE', "%{$text}%")
        //     ->orWhere('certificate_date', 'LIKE', "%{$text}%")
        //     ->orWhere('order_subject', 'LIKE', '%{$text}%')
        //     ->paginate(10);

        $certificates = DB::table('certificates')
            ->join('orders', 'certificates.order_id', 'orders.order_id')
            ->select('certificate_id', 'certificate_document', 'certificate_date', 'certificate_administration', 'certificates.order_id', 'order_subject')
            ->where('certificate_status', 1)
            ->where('order_status', 3)
            ->where('certificate_date', 'LIKE', "%{$text}%")
            ->orWhere('certificate_administration', 'LIKE', "%{$text}%")
            ->where('certificate_status', 1)
            ->where('order_status', 3)
            ->orWhere('certificate_date', 'LIKE', "%{$text}%")
            ->where('certificate_status', 1)
            ->where('order_status', 3)
            ->orWhere('order_subject', 'LIKE', "%{$text}%")
            ->where('certificate_status', 1)
            ->where('order_status', 3)
            ->paginate(10);
        //dd($text, $certificates);
        // return response()->json(($text), 200);
        return view('certificates.indexCertificates', compact('certificates') );
    }

    public function GPindex(){
        $certificates = DB::table('certificates')
            ->join('orders', 'certificates.order_id', 'orders.order_id')
            ->select('certificate_id', 'certificate_document', 'certificate_date', 'certificate_administration', 'certificates.order_id', 'order_subject')
            ->where('certificate_status', 1)
            ->where('order_status', 3)
            ->paginate(10);

        //dd($certificates);
        return view('certificates.GPindexCertificates', compact('certificates') );
    }
}
