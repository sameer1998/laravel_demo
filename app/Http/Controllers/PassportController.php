<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('TutsForWeb')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('App')->accessToken;
            $user = Auth::user();
            $user->token = $token;
            $user->update();
            return response()->json(['status'=>200,'message'=>'success','data' => $user]);
        } else {
            return response()->json(['status'=>412,'message'=>'Invalid Email Id or Password']);
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['status'=>200,'message'=>'success','data' => Auth::user()]);
    }
    public static function checkLogin($token){
        $token = str_replace('Bearer ','',$token);
        $user = User::where('token',$token)->first();
        if($user){
            return true;
        }else{
            return false;
        }

    }
}
