<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function login(Request $request){

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $user_exists = \DB::table('users')
            ->where('email', $request->input('email'))
            ->exists();
        
        if(!$user_exists)
            return $this->sendError("Ne postoji korisnik sa tim emailom", 404);
        
        $user = \DB::table('users')
                    ->where('email', $request->input('email'))
                    ->first();
        
        if (Hash::check($request->input('password'), $user->password))
        {
            \DB::table('users')
              ->where('id', $user->id)
              ->update(['logged_in' => true]);
            return $this->sendConfirmation(collect($user)->only(['id','name','email']), "Uspešno logovanje");

        }
        
        return $this->sendError("Pogrešna lozinka");
    }


    public function logOut(Request $request){

        $validated = $request->validate([
            'id' => 'required'
        ]);

        $user_exists = \DB::table('users')
            ->where('id', $request->input('id'))
            ->exists();
    
        if(!$user_exists)
            return $this->sendError("Ne postoji korisnik sa tim id-om", 404);

        $success = \DB::table('users')
            ->where('id', $request->input('id'))
            ->update(['logged_in' => false]);
        
        if($success)
            return $this->sendConfirmation(true, "Uspešno logovanje");

        return $this->sendError("Ne možem vas izlogovati u ovom trenutku", 501);
    }

    public function register(Request $request){

        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required'
        ]);

        $user = new User();

        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));

        if($user->save())
            return $this->sendConfirmation($user, "Uspelo");

        return $this->sendError("Registracija nije uspela", 501);
    }
}
