<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['content'];
    public function users()
    {
        return $this->belongsToMany('App\User','user_question')
                    ->withPivot('user_id','question_id');
    }
    public function answers()
    {
        return $this->belongsToMany('App\Answer','question_answer')
                    ->withPivot('question_id','answer_id');
    }
}
