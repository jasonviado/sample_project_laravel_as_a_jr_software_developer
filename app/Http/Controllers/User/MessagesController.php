<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Theme;

class MessagesController extends Controller{

    public function messages(){
        $theme = Theme::uses('default')->layout('default');
        return $theme->of('home.messages')->render();
    }

}
