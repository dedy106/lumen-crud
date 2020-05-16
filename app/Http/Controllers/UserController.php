<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request) {
        $this->validate($request,[
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $hashPassword = Hash::make($password);
       
        
        $user = User::create([
            'email' => $email,
            'password' => $hashPassword
        ]);
        
        return response()->json(['message'=> 'Success'],201);    
    }

    public function login(Request $request) {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email',$email)->first();
        if (!$user) {
            return response()->json(['message'=>'Email Tidak ada'],401);
        }
        $isValidPass = Hash::check($password,$user->password);
        if (!$isValidPass) {
            return response()->json(['message'=>'Login Gagal'],401);
        }
        $token = bin2hex(random_bytes(40));
        $user->update([
            'token' => $token
        ]);
        return response()->json($user);
    }

}
