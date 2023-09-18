<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(){
        $users = User::all();
        dd($users);
    }

    public function store(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('myToken')->plainTextToken;
            $success['name'] = $user->name;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Logged in successfully'
            ];

            return response($response,200);
        }else{
            $response = [
                'success' => false,
                'message' => 'didn\'t match your email or password'
            ];
            return response($response,400);
        }
        
    }
}
