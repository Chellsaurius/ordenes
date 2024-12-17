<?php

namespace App\Http\Controllers;


use App\Models\parties;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartiesController extends Controller
{
    //
    public function index()
    {
        # code...
        $parties = parties::all()->where('party_status', 1);
        return view('parties.indexParties', compact('parties'));
    }
    
    public function newParty(Request $request)
    {
        //dd($request);
        $request->validate([
            'iFile' => 'required|mimes:jpg,jpeg,png|max:2048',
        ]);
        $party = new parties();
        if ($request->iFile) {
            //dd('entró', $request);
            
            $fileName =  date("d-m-Y").'_'.$request->file('iFile')->getClientOriginalName();
            $filePath = $request->file('iFile')->storeAs('icons', $fileName, 'public');
            $party->party_name = strtolower($request->name);
            $party->party_acronym = strtolower($request->acronym);
            $party->party_colour = $request->colour;
            $party->party_icon = $fileName;
            $party->party_iconPath = '/storage/'.$filePath;

            $destinationPath = public_path('/storage/icons');
            $document = $request->file('file');
            $document->move($destinationPath,$fileName);
            
            //dd($party);
            $party->save();

            return redirect()->back()->with('success', 'Partido correctamente agregado.');
        }
        //dd($request);
        //return $request->file('iFile')->store('icons');
        $parties = parties::all()->where('party_status', 1);
        return back()->with('error', 'Error en los datos.', compact('parties') );
    }

    public function addNewParty(){
        return view('parties.addParty');
    }

    public function disableParty($id){
        $party = parties::find($id);
        $party->party_status = 2;
        $party->save();

        return redirect()->route('party.index')->with('succes', 'Partido dado de baja correctamente.');
    }

    public function enableParty($id){
        $party = parties::find($id);
        $party->party_status = 1;
        $party->save();

        return redirect()->route('party.index')->with('succes', 'Partido dado de alta correctamente.');
    }

    public function disabledParties(){
        $parties = parties::all()->where('party_status', 2);
        //dd($parties);
        return view('parties.disabledParties', compact('parties'));
    }

    public function updateParty(Request $request, $party_id){
        //dd($request, $party_id);
        $party = parties::find($party_id);
        $party->party_name = strtolower($request->name);
        $party->party_acronym = strtolower($request->acronym);
        $party->party_colour = $request->colour;
        if ($request->iFile) {
            $oldIconPath = $party->party_iconPath;
            if ($oldIconPath) {
                $currentTime = Carbon::now()->subHour()->format('H_i_m');
                $storage = $party->party_icon;
                Storage::move('/public/icons/'.$storage, '/public/icons/DOWN-'.$currentTime.'-'.$storage);
            }
            $fileName =  date("d-m-Y").'_'.$request->file('iFile')->getClientOriginalName();
            $filePath = $request->file('iFile')->storeAs('icons', $fileName, 'public');
            $party->party_icon = $fileName;
            $party->party_iconPath = '/storage/'.$filePath;

            $destinationPath = public_path('/storage/icons');
            $document = $request->file('file');
            $document->move($destinationPath,$fileName);
        }
        //dd($party);
        $party->save();
        
        return redirect()->back()->with('success', 'Partido modificado correctamente.');
    }
}
