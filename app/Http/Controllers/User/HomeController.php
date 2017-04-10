<?php

namespace App\Http\Controllers\User;

use App\GroupMessage;
use App\GroupChat;
use App\Friends;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Theme;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeController extends Controller{
    public function home(){
        $theme = Theme::uses('default')->layout('default');
        return $theme->of('home.home')->render();
    }
    public function get_home_post(){
        $homePost = new Post();
        $friends = Friends::where('users_id',Auth::user()->id)->where('status',1)->select('friend_user_id')->get();
        $post_list = [];
        foreach($friends as $key => $val){
            $post_list[$key] = $val->friend_user_id;
        }
        $post_list[count($post_list)] = Auth::user()->id;
        return array(
            'status' => 'success',
            'messages' => $homePost->homePost($post_list)
        );
    }

    public function get_friend_list(){
        $friends = new Friends();
        return array(
            'my_user' => Auth::user()->id,
            'status' => 'success',
            'messages' => $friends->friend_list(Auth::user()->id)
        );
    }
    public function get_friend_request(){
        $friend_request = new Friends();
        return array(
            'status' => 'success',
            'messages' => $friend_request->get_friend_request(Auth::user()->id)
        );
    }
    public function get_find_friends(){
        $find_friends = new Friends();
        $friends = $find_friends->find_friends(Auth::user()->id);
        $people = User::all();
        $all = [];
        foreach($people as $key => $val){
            if($val->id != Auth::user()->id){
                $all[$key] = $val->id;
            }
        }

        $friends = array_diff($all,$friends);
        $friends = User::whereIn('id',$friends)->get();
        return array(
            'status' => 'success',
            'messages' => $friends
        );
    }
    public function accept_friend_request(Request $request){
        $accept = Friends::where('friends_id',$request->id)->first();
        $updatePA = DB::table('tbl_friends')
            ->where('friends_id',$request->id)
            ->update(['status' => 1]);
        $new_friend = new Friends();
        $new_friend->users_id = $accept->friend_user_id;
        $new_friend->friend_user_id = $accept->users_id;
        $new_friend->status = 1;
        if($new_friend->save()){
            return array(
              'user' => $accept->friend_user_id,
              'user_2' => $accept->users_id,
              'status' => 'success',
            );
        }

    }
    public function addFriend(Request $request){
        $add_friend = new Friends();
        $add_friend->users_id = Auth::user()->id;
        $add_friend->friend_user_id = $request->id;
        $add_friend->status = 0;
        if($add_friend->save()){
            return array(
                'user' => Auth::user()->id,
                'user_2' => $request->id,
                'status' => 'success'
            );
        }
    }
    public function home_post(Request $request){
        $rules = [
            'post' => 'required'
        ];
        $messages = [
            'required' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        $friends = Friends::where('users_id',Auth::user()->id)->where('status',1)->select('friend_user_id')->get();
        if($validator->fails()){
            return array(
                'status' => 'error'
            );
        }else{
            $post = new Post();
            $post->user_id = $request->user;
            $post->user_post = $request->post;
            if($post->save()){
                return array(
                    'status' => 'success',
                    'friends' => $friends
                );
            }
        }
    }



    public function sendMessage(Request $request){
        $chat = new Message();
        $chat->user_id = Auth::user()->id;
        $chat->friend_user_id = $request->id;
        $chat->message = $request->message;
        if($chat->save()){
            return array(
                'status' => 'success',
                'user1' => Auth::user()->id,
                'user2' => $request->id
            );
        }
    }
    public function getChatMessage(Request $request){
        $data1 = Message::where('user_id',Auth::user()->id)->where('friend_user_id',$request->id)->orWhere('friend_user_id',Auth::user()->id)->where('user_id',$request->id)->get();
        return array(
            'status' => 'success',
            'messages' => $data1,
            'current_user' => Auth::user()->id
        );
    }
    public function addGroup(Request $request){
        $rules = [
            'group_name' => 'required',
            'choices' => 'required'
        ];
        $messages = [
            'required' => 'This fields required'
        ];

        $data = $request->choices;
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return array(
                'status' => 'error',
                'messages' => $validator->errors(),
            );
        }

        $new = new GroupChat();
        $new->group_name = $request->group_name;
        $choices = $request->choices;
        $choices[count($choices)] = Auth::user()->id;
        $new->members = json_encode($choices);

        if($new->save()){
            return array(
                'thisme' => Auth::user()->id,
                'status' => 'success',
                'data_user' => $data
            );
        }
    }
    public function get_group_list(){
        $find_group = new GroupChat();
        return array(
            'status' => 'success',
            'messages' => $find_group->findThis(Auth::user()->id)
        );
    }
    public function get_group_message(Request $request){
        $data = new GroupMessage();
        return array(
            'group_id' => $request->id,
            'status' => 'success',
            'messages' => $data->getMessage($request->id)
        );
    }
    public function send_group_message(Request $request){
        $message = new GroupMessage();
        $message->sender = Auth::user()->id;
        $message->group_id = $request->id;
        $message->messages = $request->group;
        $members = GroupChat::where('id',$request->id)->first();

        if($message->save()){
            return array(
                'status' => 'success',
                'members' => json_decode($members->members),
                'group' => $request->id
            );
        }
    }
    public function view_group_members(Request $request){
        $members = new GroupChat();
        $members_name = new User();
        $id = $members->findGroupMembers($request->id);
        return array(
            'group_id' => $request->id,
            'status' => 'success',
            'members' => $members_name->getName($id)
        );
    }

    public function view_not_group_member_list(Request $request){

        $friends = new Friends();
        $my_friends = $friends->my_friend_list(Auth::user()->id);
        $not_in_group = new GroupChat();
        $not_in_group = $not_in_group->findNotInGroup($my_friends,Auth::user()->id,$request->id);
        $user = new User();
        return array(
            'group_id' => $request->id,
            'status' => 'success',
            'not_members' => $user->getName($not_in_group)
        );
    }
}