<?php

namespace App\Http\Controllers;

use App\Models\parties;
use App\Models\positions;
use App\Models\rols;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user()->rol_id;
        $users = User::all()->where('user_status', 1)->where('rol_id', '<>', 6);
        $parties = parties::all()->where('party_status', 1);
        $presidente = User::where('rol_id', 1)->where('user_status', 1)->first();
        $secretario = User::where('rol_id', 4)->where('user_status', 1)->first();

        
        if ($user == 6 && $presidente == null && $secretario == null) {
            $rols = rols::all()->where('rol_status', 1)->where('rol_id', '!=', 6);
            
        } elseif ($user == 6 && $presidente == null) {
            $rols = rols::all()->where('rol_status', 1)
                ->where('rol_id', '!=', 6)
                ->where('rol_id', '!=', 5)
                ->where('rol_id', '!=', 4);
        } elseif ($user == 6 && $secretario == null) {
            $rols = rols::all()->where('rol_status', 1)
                ->where('rol_id', '!=', 6)
                ->where('rol_id', '!=', 5)
                ->where('rol_id', '!=', 1);
        } else {
            $rols = rols::all()->where('rol_status', 1)
                ->where('rol_id', '!=', 6)
                ->where('rol_id', '!=', 5)
                ->where('rol_id', '!=', 4)
                ->where('rol_id', '!=', 1);
        }
        //dd(($users));
        return view('users.indexUsers', compact('users', 'rols', 'parties'));
    }

    public function newUser(Request $request)
    {
        //dd($request);
        $user = Auth::user()->rol_id;   // usa el del facade 
        // $user = auth()->user()->rol_id;  uas el auth del modelo 
        $presidente = User::where('rol_id', 1)->where('user_status', 1)->first();
        $secretario = User::where('rol_id', 4)->where('user_status', 1)->first();
        // dd($presidente, $secretario);
        if ($user == 6 && $presidente == null && $secretario == null) {
            $rols = rols::all()->where('rol_status', 1)->where('rol_id', '!=', 6);
            
        } elseif ($user == 6 && $presidente == null) {
            $rols = rols::all()->where('rol_status', 1)
                ->where('rol_id', '!=', 6)
                ->where('rol_id', '!=', 5)
                ->where('rol_id', '!=', 4);
        } elseif ($user == 6 && $secretario == null) {
            $rols = rols::all()->where('rol_status', 1)
                ->where('rol_id', '!=', 6)
                ->where('rol_id', '!=', 5)
                ->where('rol_id', '!=', 1);
        } else {
            $rols = rols::all()->where('rol_status', 1)
                ->where('rol_id', '!=', 6)
                ->where('rol_id', '!=', 5)
                ->where('rol_id', '!=', 4)
                ->where('rol_id', '!=', 1);
        }
        
        $parties = parties::all()->where('party_status', 1);
        //return redirect('/home')->with('message', 'Usuario agregado de manera correcta.');
        return view('users.newUser', compact('rols', 'parties'));
    }

    public function saveUser(Request $request)
    {
        //dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        //dd($request);
        
        if ($request->password == $request->confirm_password) {
            $user = new User();

            $user->name = strtolower($request->name);
            $user->email = strtolower($request->email);
            $user->rol_id = $request->rol;   
            $user->party_id = $request->party;

            $pass = Hash::make($request->password);
            $user->password = $pass;
            try {
                //dd($user);
                $user->save();

                $users = User::all()->where('user_status', 1);
                return redirect()->route('users.index', compact('users'))->with('success', 'Usuario agregado correctamente.');
            } catch (\Throwable $th) {
                throw $th;
                $users = User::all()->where('user_status', 1);
                return redirect()->back()->with('error', 'Usuario no agregado, error en los datos.', compact('users', 'th'));
            }
        }
        else
        {
            $users = User::all()->where('user_status', 1);
            return redirect()->back()->with('error', 'Usuario no agregado, favor de verificar contraseñas.', compact('users'));
        }
    }

    public function changePass(){

        if (Auth::user()->id == 1) {
            $users = User::all();
        } elseif (Auth::user()->rol_id == 6) {
            $users = User::select('id','name', 'email', 'user_status')
                ->where('rol_id', '!=', '6')
                ->get();
        } else {
            $users = User::select('id','name', 'email', 'user_status')
                ->where('rol_id', '!=', '6')
                ->where('rol_id', '!=', 5)
                ->where('rol_id', '!=', 4)
                ->where('rol_id', '!=', 1)
                ->get();
        }
        
        return view('users.changePassword', compact('users'));
    }

    public function saveNewPass(Request $request){
        //dd($request);
        $request->validate([
            'lastPass' => ['required'],
            'newPass' => ['required', 'string', 'min:6'],
        ]);

        $user = User::find($request->id);

        $hasher = app('hash');
        if ($hasher->check($request->lastPass, $user->password)) {
            if ($request->newPass == $request->newPass_verified) {
                $user->password = Hash::make($request->newPass);
                $user->save();

                return redirect()->route('users.changePass')->with('success', 'Contraseña actualizada correctamente.');
            }
            else{
                return redirect()->route('users.changePass')->with('error', 'Las contraseñas no coinciden.');
            }
        }
        else
        {
            return redirect()->route('users.changePass')->with('error', 'Contraseña original incorrecta.');
        }
    }

    public function disableUser($id)
    {
        //dd($id);
        $user = User::find($id);
        $user->user_status = 2;
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'Usuario dado de baja correctamente.');
    }

    public function enableUser($id)
    {
        //dd($id);
        $user = User::find($id);
        $user->user_status = 1;
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'Usuario dado de alta correctamente.');
    }

    public function disabledUsers(){
        $users = User::all()->where('user_status', 2);
        $rols = rols::all()->where('rol_status', 1);
        $parties = parties::all()->where('party_status', 1);
        //dd(($users));
        return view('users.disabledUsers', compact('users', 'rols', 'parties'));
    }

    public function changeUserPass(Request $request) {
        //dd($request);
        $request->validate([
            'password' => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ]);
        
        if ($request->password == $request->password_confirmation) {
            // $hasher = app('hash'); esta es para confirmar que la contraseña es igual a la que tiene hasheada
                // en este caso no estoy pidiendo la anterior contraseña para este proceso
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);

            return redirect()->route('users.changePass')->with('success', 'Contraseña actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error en las contraseñas.');
        }
        
    }

    public function updateUser(Request $request) {
        //dd($request);
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->party) {
            $user->party_id = $request->party;
        }if ($request->rol) {
            $user->rol_id = $request->rol;
        }
        //dd($user);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario modificado correctamente.');
    }

    public function predialSendData() {
        return view('users.sendData');
    }

}
