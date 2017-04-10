<?php

namespace App\Http\Controllers\Home;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Theme;
use App\Http\Controllers\Controller;

class RegisterController extends Controller{

    public function register(){
        $theme = Theme::uses('default')->layout('default');
        return $theme->of('home.register')->render();
    }
    public function registerAccount(Request $request){
        $rules = [
            'email' => 'required | email | unique:users,email',
            'name' => 'required',
            'password' => 'required',
            'confirm_password' => 'required | same:password'
        ];
        $messages = [
            'required' => 'Field is required',
            'same' => 'Password and confirmation password did not match',
            'unique' => 'Email has already taken',
        ];

        $validator = Validator::make($request->all(), $rules , $messages);

        if($validator->fails()){
            return array(
                'status' => 'error',
                'messages' => $validator->errors
            );
        }else{
            $users = new User();
            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = Hash::make($request->password);
            if($users->save()){
                return array(
                    'status' => 'success'
                );
            }
        }
    }
}