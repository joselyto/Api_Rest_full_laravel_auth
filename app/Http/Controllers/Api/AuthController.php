<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    
    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function login(Request $request){
       
    }
   
 
    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function register(Request $request){
        try {
                
                $validate = $request->validate([
                    'name'=>"required",
                    'password'=>"required",
                    "email"=>"required|email"
                ]);

                $user = User::create([
                    "name"=>$request->name,
                    "email"=>$request->email,
                    "password"=>$request->password
                ]);
                return response()->json([
                     'status'=>true,
                    'user'=>$user,
                    'token'=>$user->createToken('secret')->plainTextToken
                ], 201);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage(),
            ], 500);
        }
    }
}
