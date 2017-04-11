<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Theme;

class LoginController extends Controller{

    public function login(){
        $theme = Theme::uses('default')->layout('default');
        return $theme->of('home.login')->render();
    }

    public function loginAccess(){
        if(Auth::check()){
            return Redirect::to('/home');
        }else{
            $theme = Theme::uses('default')->layout('default');
            return $theme->of('home.login')->render();
        }
    }

    public function loginUser(Request $request){
        $rules = [
            'email' => 'required | email ',
            'password' => 'required'
        ];
        $messages = [
            'required' => 'This is required.'
        ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails()){
            return array(
                'status' => 'error',
                'messages' => $validator->errors()
            );
        }else{
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                return array(
                    'status' => 'success'
                );

            }else{
                return array(
                    'status' => 'invalid-user'
                );
            }
        }

    }
}