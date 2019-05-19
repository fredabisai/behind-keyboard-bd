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
    public function index()
    {
        $questions = Question::with('users','answers')->orderBy('created_at','desc')
        ->get();
        return response()->json(["data"=>$questions, "success"=>"true"],200);
    }
    public function add(Request $request){

        $validator = Validator::make($request->all(),$this->rulesForAdd());
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $user = new User;
        $question = new Question();

        $question->content = $request->input('content');
        $user_id = $request->input('user_id');
        $question->save();
        $question->users()->attach($user, [
            'user_id'=> $user_id,
            'question_id' => $question->id
        ]);
        $question = Question::with('users')->findOrFail($question->id);

        return response()->json(['data'=>$question,'success'=>'true'],200);
    }
    public function rulesForAdd(){
        return [
            'content'=>'required'
        ];
    }
    /*End of Add question functions */
    public function getById($id){
        $question = Question::with('users','answers')->findOrFail($id);
        return response()->json(["data"=>$question, "success"=>"true"], 200);
   }
   public function update(Request $request, $id){
    $question = Question::findOrFail($id);
    $validator = Validator::make($request->all(), $this->rulesForAdd($question->id));
    if($validator->fails()){
        return response()->json(['error'=> $validator->errors()], 401);
    }

    $question = Question::findOrFail($id);;
    $question->update($request->all());
    return response()->json(['success'=>'true','data'=>$question], 200);
   }
   public function delete($id){
    $question = Question::findOrFail($id);
    $question->delete();
    return response()->json(["success"=>"true"],204);
 }


}
