<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Authentificatio extends Controller
{
    public function login (Request $request){
        try {
            Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            $user = User::where('email',$request->email)->first();
            $token=$user->createToken('Auth')->plainTextToken;
            return response()->json(['token'=>$token,'user'=>$user->id,'admin'=>$user->Admin]);        }
            catch (\Throwable $th) {
                return response()->json(['status'=>$th->getMessage()],404);
        }

    }

    public function register(Request  $request){
        try {
            $data=$request->validate(['email'=>'required','password'=>'min:8','name'=>'required','city'=>'required','zip'=>'required','adress'=>'required','country'=>"required"]);
            $data['password']=Hash::make($data['password']);
            User::create($data);
            return response()->json(['status'=>'Acount created succesfully ']);
        }
            catch (\Throwable $th) {
                return response()->json(['status'=>$th->getMessage()]);
        }
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
    }
}
