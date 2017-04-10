<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Theme;

class ProfileController extends Controller{

    public function profile(){
        $theme = Theme::uses('default')->layout('default');
        return $theme->of('home.profile')->render();
    }
    public function profile_post(Request $request){
        $data = Post::where('user_id',$request->id)->join('users','tbl_post.user_id','users.id')->take(3)->orderBy('post_id','desc')->get();
        return array(
            'status' => 'success',
            'messages' => $data
        );
    }

//    public function post(Request $request){
//        $rules = [
//            'post' => 'required'
//        ];
//        $messages = [
//            'required' => 'required'
//        ];
//
//        $validator = Validator::make($request->all(),$rules,$messages);
//
//        if($validator->fails()){
//            return array(
//                'status' => 'error',
//                'message' => $messages
//            );
//        }else{
//            $post = new Post();
//            $post->user_id = $request->user;
//            $post->user_post = $request->post;
//            if($post->save()){
//                return Redirect::to('/home');
//            }
//        }
//    }

}