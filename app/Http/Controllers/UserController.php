<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        //dd($request->email);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
        return response($response, 201);
    }

    public function UpdateProfile(Request $req)
    {
       
        $validate = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:20', 'min:4', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],
            //'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ]);

        if ($validate->fails()) 
        {
          $response['response'] = $validate->messages();
        }
        else 
        {
            
            $tokenarray = explode('|', $req->bearerToken());
            $tokenid = $tokenarray[0];
            $gettokendetail  = DB::table('personal_access_tokens')
                                        ->where('id', '=', $tokenid)->get();
            
            $user_id = 0;
            foreach($gettokendetail as $info)
            {
               $user_id = $info->tokenable_id;
            }

            $user = User::findorFail($user_id);
           
            $user->name = $req->name;
            $user->user_name = $req->user_name;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->save();
            $response['success'] = 'Data Update Successfully';
        }


        return response($response, 201);

       
    }
}
