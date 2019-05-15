<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Requests;

class UserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),$this->rulesLogin());

        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        if (Auth::attempt(['email'=>request('email'),'password'=>request('password')])){
            $user = Auth::user();
            $token = $user->createToken('BehindTheKeyBoard')->accessToken;

               return response()->json(['token'=>$token,'success'=>'true','data'=>$user],200);

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



    /*Register User functions */
    public function register(Request $request){

                $validator = Validator::make($request->all(),$this->rulesForRegister());
                if ($validator->fails()){
                    return response()->json(['error'=>$validator->errors()],401);
                }
                $user = new User;

                // $user->first_name = $request->input('first_name');
                // $user->last_name = $request->input('last_name');
                $user->email = $request->input('email');
                // $user->phone_number = $request->input('phone_number');
                // $user->gender = $request->input('gender');
                // $user->first_login_flag = 0;
                $user->password = bcrypt($request->input('password'));

                $user->save();

                $data['token'] = $user->createToken('BehindTheKeyBoard')->accessToken;
                $data['user'] = $user;

                return response()->json(['data'=>$data,'success'=>'true'],200);

            }
            public function rulesForRegister(){
                // return [
                //     'first_name'=>'required',
                //     'last_name'=>'required',
                //     'email'=>'required|email|unique:users',
                //     'phone_number'=>'required|size:13|unique:users',
                //     'gender'=>'required'
                // ];
                return [

                    'email'=>'required|email|unique:users',
                    'password'=> 'required'
                ];
            }
            /*End of Register Admin functions */


    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), $this->rulesForUpdate($user->id));
        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 401);
        }

        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(['success'=>'true','data'=>$user], 200);
    }

    public function rulesForUpdate(){
        return [

            'email'=>'required|email|unique:users',
            'password' => 'required'
        ];
    }
    /*End of Register Employee functions */


   /* Delete user function */

   public function delete($id){
      $user = User::findOrFail($id);
      $user->delete();
      return response()->json(["success"=>"true"],204);
   }
   public function getById($id){
        $user = User::findOrFail($id);
        return response()->json(["data"=>$user, "success"=>"true"], 200);
   }

   public function index(){
       $user = User::all();

       return response()->json(['data'=>$user, 'success'=>'true'],200 );
   }

   public function checkEmailExists(Request $request){
       $email = $request->input('email');
       $user = User::where('email','=',$email)->first();
       $email_exists = null;
       if ($user === null){
           $email_exists = false;
       }else {
           $email_exists = true;
       }
       return response()->json(['email_exists'=>$email_exists,'data'=>$user,"success"=>"true"],200);
   }
    public function checkPhoneExists(Request $request){
        $user = User::where('phone_number','=',$request->input('phone_number'))->first();
        $phone_exists = true;
        if ($user === null){
            $phone_exists = false;
        }
        return response()->json(['phone_exists'=>$phone_exists,'data'=>$user,"success"=>"true"],200);
    }

}
