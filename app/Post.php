<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model{
    protected $table = 'tbl_post';
    protected $primaryKey = 'post_id';

    public function homePost($post_list){
        return Post::whereIn('user_id',$post_list)->join('users','tbl_post.user_id','users.id')->orderBy('post_id','desc')->get();

    }
}