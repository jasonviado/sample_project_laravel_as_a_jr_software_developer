<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    protected $table = 'tbl_group_chat';

    public function findThis($id){
        $data = GroupChat::where('status',1)->get();
        $group = [];
        foreach($data as $key => $val){
            $this_val = json_decode($val->members);
            if(in_array($id,$this_val)){
                $group[$key] = $data[$key];
            }
        }
        return $group;
    }
    public function findGroupMembers($id){
        $members = GroupChat::where('id',$id)->first();
        $members_id = json_decode($members->members);
        return $members_id;
    }
    public function findNotInGroup($id,$my_id,$group_id){
        $id[count($id)] = $my_id;
        $members = GroupChat::where('id',$group_id)->first();
        $group_members = json_decode($members->members);
        return array_diff($id,$group_members);
    }
}
