<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User','user_question')
                    ->withPivot('user_id','question_id');
    }
}
