<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Users;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Statuscodes;
class LoginController extends BaseController
{

    protected $ruleSet;

	/**
	 * AuthController constructor.
	 */
	public function __construct(){

		$this->ruleSet = config('rules');
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

     /* Login with email */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),  $this->ruleSet['login']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $store=Users::where('id',$user->id)->first();
            $store['token'] =  $user->createToken('MyApp')-> accessToken;


            /* update device id or login status */
            if($request->device_id !=''){
                Users::where('id',$user->id)->update(['device_id'=>$request->device_id,'login_status'=>1]);
            }

            return response()->json(['status' => Statuscodes::Okay,
            'message'=>'Login successfully','data'=>$store]);

        }
        else{
            return response()->json(['status' => Statuscodes::Unauthorized,
            'message'=>'Invalid email or password !']);
        }
    }
    
    /* Forgot password */
    public function forgot_password(Request $request){
       
        $validator = Validator::make($request->all(),  $this->ruleSet['forgot-password']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }
        $match='';
         if($request->auth_type==0 || $request->auth_type=='0'){
            $match=Users::where('email',$request->email)->first();
         }
         if($request->auth_type==1 || $request->auth_type=='1'){
            $match=Users::where('mobile',$request->mobile)->first();
         }

         
        if(!empty($match)){
            Users::where('id',$match->id)->update(['password'=>Hash::make($request->password)]);
            return response()->json(['status' => Statuscodes::Okay,
            'message'=>'Password has been updated successfully !']);

        }else{
            return response()->json(['status' => Statuscodes::Unauthorized,
            'message'=>'Invalid auth type !']);
        }

        

    }


}
