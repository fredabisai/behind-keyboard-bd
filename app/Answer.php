<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['content'];
    public function users()
    {
        return $this->belongsToMany('App\User','user_answer')
                    ->withPivot('user_id','answer_id');
    }
    public function questions()
    {
        return $this->belongsToMany('App\Question','question_answer')
                    ->withPivot('question_id','answer_id');
    }
    public function experts()
    {
        return $this->belongsToMany('App\Expert','expert_answer')
                    ->withPivot('expert_id','answer_id');
    }
}
