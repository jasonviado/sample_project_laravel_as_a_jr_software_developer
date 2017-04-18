<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    protected $table = 'tbl_friends';

    protected $primaryKey = 'friends_id';

    public function friend_list($id){
        return Friends::where('users_id',$id)->join('users','tbl_friends.friend_user_id','users.id')->select('friend_user_id','name','status')->get();
    }
    public function my_friend_list($id){
        $user = Friends::where('users_id',$id)->where('status',1)->get();
        $id = [];
        foreach($user as $key => $val){
            $id[$key] = $val->friend_user_id;
        }
        return $id;
    }
    public function get_friend_request($id){
        return Friends::where('friend_user_id',$id)->where('status',0)->join('users','tbl_friends.users_id','users.id')->select('friends_id','users_id','name','status')->get();
    }
    public function find_friends($id){
        $data1 = Friends::where('users_id',$id)->join('users','tbl_friends.friend_user_id','users.id')->select('friend_user_id as id')->get();
        $data2 = Friends::where('friend_user_id',$id)->join('users','tbl_friends.users_id','users.id')->select('users_id as id')->get();
        $data = json_decode($data1,true)+json_decode($data2,true);
        $friends = [];
        foreach($data as $key => $val){
            $friends[$key] = $val['id'];

        }
        return $friends;
    }
}
