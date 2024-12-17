<?php

namespace App\Http\Controllers;

use App\Models\comisions;
use App\Models\orders;
use App\Models\parties;
use App\Models\positions;
use App\Models\records;
use App\Models\RecordsObserved;
use App\Models\rols;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComisionsController extends Controller
{
    //
    public function index()
    {
        $comisions = comisions::select('comision_id', 'comision_name')->where('comision_status', 1)->paginate(100);
        return view('comisions.indexComisions', compact('comisions'));
    }

    public function newComision(){
        $users = User::all()->where('user_status', 1)->where('rol_id', '<>', '6');
        $positions = positions::all()->where('position_status', 1);
        $parties = parties::all()->where('party_status', 1);
        return view('comisions.newComision', compact('users', 'parties', 'positions'));
    }

    public function saveComision(Request $request)
    {
        //dd($request);
        
        $comision = new comisions();
        $comision->comision_name = strtolower($request->name);
        $members = $request->members;
        $comision->save();

        //dd($comision);
        for ($i=1; $i <= $members; $i++) { 
            $record = new records();
            $record->user_id = request("users".$i);
            $record->position_id = request("position".$i);
            $record->comision_id = $comision->comision_id;
            
            $record->save();
        }

        //$comisions = comisions::all()->where('comision_status', 1);
        return redirect()->route('comision.index')->with('success', 'Comisión agregada correctamente');
    }

    public function comisionsDetails($id) {
        //dd($id);
        // $comisions = DB::table('comisions')
        //     ->join('records', 'comisions.comision_id', 'records.comision_id')
        //     ->select('comision_id', 'comision_name');
        $comision = comisions::select('comision_id', 'comision_name')->where('comision_status', 1)->where('comision_id', $id)->first();
        //dd(empty($comision));
        if (empty($comision) ) {
            $comisions = comisions::select('comision_id', 'comision_name')->where('comision_status', 2)->get();
            return view('comisions.disabledComisions', compact('comisions'));
        } else {
            
            $users = User::select('id', 'name', 'rol_id', 'party_id')->where('user_status', 1)->where('rol_id', '!=', 6)->get();
            $rols = rols::select('rol_id', 'rol')->where('rol_status', 1)->get();
            $positions = positions::all()->where('position_status', 1);
            return view('comisions.detailsComisions', compact('comision', 'users', 'rols', 'positions'));
        }
        
        
    }

    public function disableComision($id)
    {
        //dd($id);
        $comision = comisions::find($id);
        $comision->comision_status = 2;
        $comision->save();
        
        return redirect()->route('comision.index')->with('success', 'Comisión dada de baja correctamente.');
    }

    public function enableComision($id)
    {
        //dd($id);
        $comision = comisions::find($id);
        $comision->comision_status = 1;
        $comision->save();
        
        return redirect()->route('comision.index')->with('success', 'Comisión dada de alta correctamente.');
    }

    public function disabledComisions(){
        $comisions = comisions::select('comision_id', 'comision_name')->where('comision_status', 2)->get();
        //dd(($users));
        return view('comisions.disabledComisions', compact('comisions'));
    }

    public function updateComision(Request $request){
        //dd($request);
        $comision = comisions::find($request->id);
        $comision->comision_name = strtolower($request->name) ;
        $comision->save();

        return redirect()->route('comision.index')->with('success', 'Comisión modificada correctamente');
    }

    public function addUserToComission(Request $request){
        //dd($request);
        $record = new records();
        $record->user_id = $request->user;
        $record->position_id = $request->position;
        $record->comision_id = $request->comision;
        $record->save();
        
        return redirect()->route('comision.details', $request->comision)->with('success', 'Integrante añadido correctamente.');
    }

    public function changePositionInComision(Request $request) {
        //dd($request);
        try {
            $RC = records::find($request->record);
            //$RC = records::where('record_id', $request->record)->where('record_status', 1)->where('comision_id', $request->comision)->first();
            //$RC->position_id = 5;
            $RC->position_id = $request->position;
            //dd($RC);
            $RC->save();

            //$record = DB::table('records')->where('record_id', $request->record)->update(['position_id' => $request->position, 'updated_at' => Carbon::now()]);
            //dd($request, $record);
            return redirect()->route('comision.details', $request->comision)->with('success', 'Puesto del integrante cambiado correctamente.');
            //return redirect()->back()->with('success', 'Puesto del integrante cambiado correctamente.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'No' . $th);
        }
    }

    public function disableMemberFromComision($id){
        //dd($id);
        $record = records::find($id);
        $record->record_status = 2;
        $record->save();

        return redirect()->back()->with('success', 'Integrante dado de baja correctamente.');
    }

    public function enableMemberFromComision($id){
        //dd($id);
        $record = records::find($id);
        $record->record_status = 1;
        $record->save();

        return redirect()->back()->with('success', 'Integrante dado de alta correctamente.');
    }

    public function comisionsRecordsList() {
        $comisions = comisions::select('comision_id', 'comision_name', 'comision_status')->where('comision_status', 1)->orWhere('comision_status', 2)->orderBy('comision_name', 'asc')->get();
        //dd(($users));
        return view('comisions.comisionsRecords', compact('comisions'));
    }

    public function comisionsRecord($id) {
        $records = RecordsObserved::where('comision_id', $id)->get();
        //dd(($users));
        return view('comisions.comisionsRecords', compact('comisions'));
    }

    public function GPViewComisions(){
        $comisions = comisions::select('comision_id', 'comision_name')->where('comision_status', 1)->orderBy('comision_name', 'asc')->get();
        return view('comisions.GPindexComisions', compact('comisions'));
    }

    public function GPcomisionsDetails($id) {
        $comision = comisions::select('comision_id', 'comision_name')
            ->where([
                ['comision_status', 1],
                ['comision_id', $id],
            ])->first();
        
        return view('comisions.GPdetailsComisions', compact('comision', ));
    }

    public function comisionsListAJAX() {
        $comisions = comisions::select('comision_id', 'comision_name')
            ->where('comision_status', 1)
            ->orderBy('comision_name', 'asc')
            ->get();

        return response()->json(($comisions), 200);
    }

    public function GPComisionRecords($name) {
        // dd($name);
        $comision = comisions::select('comision_id')->where('comision_name', 'LIKE', '%' . $name . '%')->first();

        $observedOrders = DB::table('orders_observeds')->select('order_id')->distinct()
            ->where('comision_id', $comision->comision_id)
            ->pluck('order_id');

        // $array = get_object_vars($orders);
        //dd($comision->comision_id, $observedOrders);
        
        // $records = DB::table('orders')->select('order_id', 'order_date', 'order_document', 'order_subject', 'comision_id', 'order_status')
        //     ->whereIn('order_id', $orders)
        //     ->get();
        // dd($records);

        $orders = orders::select('order_id', 'order_date', 'order_document', 'order_documentPath', 'order_subject', 'order_belongsTo', 'comision_id', 'order_createdBy')
            ->where('order_status', 3)
            ->whereIn('order_id', $observedOrders)
            ->get();
        //dd($orders); 
        $title = "Participaciones historicas: " . $name;
        return view('orders.GPindexOrders', compact('orders', 'title'));
    }
}
