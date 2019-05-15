<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Requests;

class AdminController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),$this->rulesLogin());

        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        if (Auth::attempt(['email'=>request('email'),'password'=>request('password')])){
            $admin = Auth::Admin();
            $token = $admin->createToken('BehindTheKeyBoard')->accessToken;

               return response()->json(['token'=>$token,'success'=>'true','data'=>$admin],200);

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



    /*Register Admin functions */
    public function register(Request $request){

                $validator = Validator::make($request->all(),$this->rulesForRegister());
                if ($validator->fails()){
                    return response()->json(['error'=>$validator->errors()],401);
                }
                $admin = new Admin;

                $admin->first_name = $request->input('first_name');
                $admin->last_name = $request->input('last_name');
                $admin->email = $request->input('email');
                $admin->phone_number = $request->input('phone_number');

                $admin->password = bcrypt($request->input('password'));

                $admin->save();

                $data['token'] = $admin->createToken('BehindTheKeyBoard')->accessToken;
                $data['Admin'] = $admin;

                return response()->json(['data'=>$data,'success'=>'true'],200);

            }
            public function rulesForRegister(){
                return [
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'email'=>'required|email|unique:Admins',
                    'phone_number'=>'required|size:13|unique:Admins'
                ];

            }
            /*End of Register Admin functions */


    public function update(Request $request, $id){
        $admin = Admin::findOrFail($id);
        $validator = Validator::make($request->all(), $this->rulesForUpdate($admin->id));
        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 401);
        }

        $admin = Admin::findOrFail($id);
        $admin->update($request->all());
        return response()->json(['success'=>'true','data'=>$admin], 200);
    }

    public function rulesForUpdate(){
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:Admins',
            'phone_number'=>'required|size:13|unique:Admins'
        ];
    }
    /*End of Register Employee functions */


   /* Delete Admin function */

   public function delete($id){
      $admin = Admin::findOrFail($id);
      $admin->delete();
      return response()->json(["success"=>"true"],204);
   }
   public function getById($id){
        $admin = Admin::findOrFail($id);
        return response()->json(["data"=>$admin, "success"=>"true"], 200);
   }

   public function index(){
       $admin = Admin::all();

       return response()->json(['data'=>$admin, 'success'=>'true'],200 );
   }

   public function checkEmailExists(Request $request){
       $email = $request->input('email');
       $admin = Admin::where('email','=',$email)->first();
       $email_exists = null;
       if ($admin === null){
           $email_exists = false;
       }else {
           $email_exists = true;
       }
       return response()->json(['email_exists'=>$email_exists,'data'=>$admin,"success"=>"true"],200);
   }
    public function checkPhoneExists(Request $request){
        $admin = Admin::where('phone_number','=',$request->input('phone_number'))->first();
        $phone_exists = true;
        if ($admin === null){
            $phone_exists = false;
        }
        return response()->json(['phone_exists'=>$phone_exists,'data'=>$admin,"success"=>"true"],200);
    }
}
