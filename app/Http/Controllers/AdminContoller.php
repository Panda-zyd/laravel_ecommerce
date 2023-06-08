<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminContoller extends Controller
{
    public function AddAdmin(Request $request){
        $user=User::where('email',$request->email)->first();
        if($user){
            if($user->admin){
                return response()->json(['status'=>" this  $user->email is already admin !!! "]);
            }
            $user->admin=1;
            $user->save();
            return response()->json(['status'=>" admin ajouter $user->email "]);
        }
            return response()->json(['error'=>'email not found'],404);
    }

    public function deleteAdmin(Request $request){
        $user=User::where('email',$request->email)->first();
        $user->admin=0;
        $user->save();
        return response()->json(['status'=>" admin suprimmer $user->email "]);
    }

}
