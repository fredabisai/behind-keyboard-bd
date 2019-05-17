<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Expert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Requests;

class ExpertController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),$this->rulesLogin());

        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        if (Auth::attempt(['email'=>request('email'),'password'=>request('password')])){
            $expert = Auth::Expert();
            $token = $expert->createToken('BehindTheKeyBoard')->accessToken;

               return response()->json(['token'=>$token,'success'=>'true','data'=>$expert],200);

        }else{
            return response()->json(['success'=>'false'],401);
        }
    }
    public function rulesLogin(){
        return [
            'email'=> 'required|email',
            'password'=>'required'
        ];
    }
    /*End ofLogin functions */



    /*Register Expert functions */
    public function register(Request $request){

                $validator = Validator::make($request->all(),$this->rulesForRegister());
                if ($validator->fails()){
                    return response()->json(['error'=>$validator->errors()],401);
                }
                $expert = new Expert;

                $expert->first_name = $request->input('first_name');
                $expert->last_name = $request->input('last_name');
                $expert->email = $request->input('email');
                // $expert->phone_number = $request->input('phone_number');
                $expert->gender = $request->input('gender');

                $expert->password = bcrypt($request->input('password'));

                $expert->save();

                $data['token'] = $expert->createToken('BehindTheKeyBoard')->accessToken;
                $data['Expert'] = $expert;

                return response()->json(['data'=>$data,'success'=>'true'],200);

            }
            public function rulesForRegister(){
                return [
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'email'=>'required|email|unique:Experts',
                 
                    'gender'=>'required',
                ];

            }
            /*End of Register Admin functions */


    public function update(Request $request, $id){
        $expert = Expert::findOrFail($id);
        $validator = Validator::make($request->all(), $this->rulesForUpdate($expert->id));
        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 401);
        }

        $expert = Expert::findOrFail($id);
        $expert->update($request->all());
        return response()->json(['success'=>'true','data'=>$expert], 200);
    }

    public function rulesForUpdate(){
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:Experts',
            'phone_number'=>'required|size:13|unique:Experts',
            'gender'=>'required'
        ];
    }
    /*End of Register Employee functions */


   /* Delete Expert function */

   public function delete($id){
      $expert = Expert::findOrFail($id);
      $expert->delete();
      return response()->json(["success"=>"true"],204);
   }
   public function getById($id){
        $expert = Expert::findOrFail($id);
        return response()->json(["data"=>$expert, "success"=>"true"], 200);
   }

   public function index(){
       $expert = Expert::all();

       return response()->json(['data'=>$expert, 'success'=>'true'],200 );
   }

   public function checkEmailExists(Request $request){
       $email = $request->input('email');
       $expert = Expert::where('email','=',$email)->first();
       $email_exists = null;
       if ($expert === null){
           $email_exists = false;
       }else {
           $email_exists = true;
       }
       return response()->json(['email_exists'=>$email_exists,'data'=>$expert,"success"=>"true"],200);
   }
    public function checkPhoneExists(Request $request){
        $expert = Expert::where('phone_number','=',$request->input('phone_number'))->first();
        $phone_exists = true;
        if ($expert === null){
            $phone_exists = false;
        }
        return response()->json(['phone_exists'=>$phone_exists,'data'=>$expert,"success"=>"true"],200);
    }

}
