<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use GrahamCampbell\ResultType\Success;

class UserController extends Controller

{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            $user = Auth::User();
        $success['$token'] = $user->createToken('mobilefirst')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'status' => 'success',
            'message' => 'Authorized User',
            'data' => $success
        ];

        return response()->json($response,200);
    }else{
        $response =[
            'status' => 'fail',
            'message' => 'UnAuthorized user'
        ];
        return response()->json($response,400);
    }
      
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            // 'password' => 'required|confirmed|',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->toJson()], 400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['$token'] = $user->createToken('mobilefirst')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'status' => 'success',
            'message' => ' User Registered Successfully',
            'data' => $success
        ];

        return response()->json($response,200);
    }



    // public function getUser(Request $request)
    // {
    //     return response()->json($request->user());
    // }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    public function getUser(Request $request)
    {
        $res = User::get();
        return $res;
    }
}

