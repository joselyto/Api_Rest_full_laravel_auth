<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        try {
                
            $validate = $request->validate([
              
                'password'=>"required",
                "email"=>"required|email"
            ]);

            if(!Auth::attempt($validate)){
                return response()->json([
                    'message'=>"Mot de passe ou email incorrect"
                ], 422);
            }
            return response()->json([
                 'status'=>true,
                'user'=>auth()->user(),
                'token'=>auth()->user()->createToken('secret')->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
        //throw $th;
            return response()->json([
                'status'=>false,
                'message'=>$th->getMessage(),
            ], 500);
        }
    }
   
 
    /**
     * @param Request $request
     * 
     * @return User
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
                    "password"=>Hash::make($request->password)
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
    /**
     * @return [type]
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "message"=>"Deconnexion effectuer"
        ], 200);
    }
    public function user(){
        return response()->json([
            'user'=>auth()->user()
        ], 200);
    }
}
