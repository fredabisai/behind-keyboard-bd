<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Answer;
use App\User;
use App\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Requests;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::with('users','questions','experts')->orderBy('created_at','desc')
        ->get();
        return response()->json(["data"=>$answers, "success"=>"true"],200);
    }
    public function add(Request $request){

        $validator = Validator::make($request->all(),$this->rulesForAdd());
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $user_id = 0;
        $user = new User;
        $question = new Question;
        $answer = new answer();
        if($request->input('user_id') === 0) {
            $user_id = $request->input('expert_id');
        } else
        {
            $user_id = $request->input('user_id');
        }
        $question_id = $request->input('question_id');
        $answer->content = $request->input('content');
        $answer->save();
        $answer->users()->attach($user, [
            'user_id'=> $user_id,
            'answer_id' => $answer->id
        ]);
        $answer->questions()->attach($question, [
            'question_id'=> $question_id,
            'answer_id' => $answer->id
        ]);
        $answer = Answer::with('questions','users','experts')->findOrFail($answer->id);

        return response()->json(['data'=>$answer,'success'=>'true'],200);
    }
    public function rulesForAdd(){
        return [
            'content'=>'required',
            'user_id'=> 'required',
            'expert_id' => 'required',
            'question_id' => 'required'

        ];
    }
    /*End of Add answer functions */
    public function getById($id){
        $answer = Answer::with('users','questions', 'experts')->findOrFail($id);
        return response()->json(["data"=>$answer, "success"=>"true"], 200);
   }
   public function update(Request $request, $id){
    $answer = Answer::findOrFail($id);
    $validator = Validator::make($request->all(), $this->rulesForAdd($answer->id));
    if($validator->fails()){
        return response()->json(['error'=> $validator->errors()], 401);
    }

    $answer = Answer::findOrFail($id);;
    $answer->update($request->all());
    return response()->json(['success'=>'true','data'=>$answer], 200);
   }
   public function delete($id){
    $answer = Answer::findOrFail($id);
    $answer->delete();
    return response()->json(["success"=>"true"],204);
 }

}
