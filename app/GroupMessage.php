<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    protected $table = 'tbl_group_message';
    public function getMessage($id){
        return GroupMessage::where('group_id',$id)->join('users','tbl_group_message.sender','users.id')->get();
    }
}
