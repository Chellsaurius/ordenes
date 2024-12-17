<?php

namespace App\Http\Controllers;

use App\Models\records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordsController extends Controller
{
    //
    public function showRecords($id) {
        //dd($id);
        $records = records::all()->where('comision_id', $id)->where('record_status', 1);

        $OComisions = DB::table('comision_observeds')
            ->join('comisions', 'comision_id', 'observed_comisionId')
            ->select('observed_comisionId', 'observed_original', 'observed_movement', 'comision_name', 'comision_observeds.updated_at')
            ->where('observed_comisionId', $id)
            ->get();

        $ORecords = DB::table('records_observeds')
            ->join('users', 'user_id', 'id')
            ->select('comision_id', 'user_id', 'position_id', 'recordO_original', 'recordO_disenable', 'recordO_movement', 'users.name')
            ->where('comision_id', $id)
            ->get();
        //dd($records, $ORecords);
        return view('records.showRecords', compact('records', 'OComisions', 'ORecords'));
    }
}
