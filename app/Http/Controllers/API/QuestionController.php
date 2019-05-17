<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Requests;


class QuestionController extends Controller
{
    public function add(Request $request){

        $validator = Validator::make($request->all(),$this->rulesForAdd());
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $user = new User; 
        $question = new Question();

        $question->content = $request->input('content');
        $question->save();
        $question->users()->attach($user, [
            'user_id'=> 1,
            'question_id' => $question->id
        ]);

        return response()->json(['data'=>$question,'success'=>'true'],200);
    }
    public function rulesForAdd(){
        return [
            'content'=>'required'
        ];
    }
    /*End of Register Admin functions */

}
