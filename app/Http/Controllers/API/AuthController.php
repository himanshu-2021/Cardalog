<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Users;
use App\Models\Otp;
use App\Interfaces\Statuscodes;
use Illuminate\Support\Facades\Auth;
use Validator;
class AuthController extends BaseController
{
    protected $ruleSet;

	/**
	 * AuthController constructor.
	 */
	public function __construct(){

		$this->ruleSet = config('rules');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

   /* check type and send otp email or mobile  */
   public function send_otp(Request $request){

    $validator = Validator::make($request->all(),  $this->ruleSet['send_otp']);
    if($validator->fails()){
        return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
    }


    $otp=rand(100000,999999);
    $expire_time=date('G:i',strtotime('+5 minutes', strtotime(date('G:i'))));

    switch ($request->auth_type) {
        case 1 : //Mobile send otp cse
            $get_user=Users::where('mobile',$request->mobile)->first();
            $is_exist_otp=Otp::where('user_id',$get_user->id)->first();
            if(! empty($is_exist_otp)){
                $create=Otp::where('id', $is_exist_otp->id)->update(['expire'=>$expire_time,'otp'=>$otp,'auth_type'=>'mobile','status'=>0]);
            }else{
                $store=array('user_id'=>$get_user->id,'otp'=>$otp,'expire'=>$expire_time,'auth_type'=>'mobile');
                $create=Otp::create($store);
                if($create){
                    $create=1;
                }
            }

            if($create==1){
                $otp_msg="Your OTP for online verification ".$otp." Which is valid for 5 min from now.Do not disclose
                OTP. if not done by you";
                $this->twillo_send_mobile_sms($request->mobile, $otp_msg); //send sms using getway api
                return response()->json(['status' => Statuscodes::Okay,'message'=> 'Otp has been send to your mobile number ']);
            }

            return response()->json(['status' => Statuscodes::Unauthorized, 'message'=>'Failed to send otp please try again !']);

        break;
        case 0 : //Email send otp case
            $get_user=Users::where('email',$request->email)->first();
            $is_exist_otp=Otp::where('user_id',$get_user->id)->first();
            if(! empty($is_exist_otp)){
                $create=Otp::where('id', $is_exist_otp->id)->update(['expire'=>$expire_time,'otp'=>$otp,'auth_type'=>'email','status'=>0]);
            }else{
                $store=array('user_id'=>$get_user->id,'otp'=>$otp,'expire'=>$expire_time,'auth_type'=>'email');
                $create=Otp::create($store);
                if($create){
                    $create=1;
                }
            }
            if($create==1){
                $otp_msg="Your OTP for online verification ".$otp." which is valid for 5 min from now.Do not disclose OTP. if not done by you";
                 $this->send_mail_otp($request->email,$otp);
                
                return response()->json(['status' => Statuscodes::Okay,'message'=> 'Otp has been send to your email']);
            }

            return response()->json(['status' => Statuscodes::Unauthorized, 'message'=>'Failed to send otp please try again !']);
        break;
        default:
        return response()->json(['status' => Statuscodes::Unauthorized, 'message'=>'Invalid auth type please enter valid auth type !']);
    }

}



/* verify otp */
public function verify_otp(Request $request){
    $validator = Validator::make($request->all(),  $this->ruleSet['verify_otp']);
    if($validator->fails()){
        return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
    }
    switch ($request->auth_type) {
        case 1:
        $get_user=Users::where('mobile',$request->mobile)->first();
        break;
        case 0:
        $get_user=Users::where('email',$request->email)->first();
        break;
        default:
        return response()->json(['status' => Statuscodes::Unauthorized, 'message'=>'Invalid auth type please enter valid auth type !']);

    }
    $store['verify_status']=0;
    if(! empty($get_user->id)){
        /* Match otp and time */
        $curent_time=date('G:i');
        $check_otp=Otp::where('otp',$request->otp)->where('user_id',$get_user->id)->first();
      if(!empty($check_otp)){
        $expire_time=$check_otp->expire;
        $expire_time_on= (strtotime($curent_time) - strtotime( $expire_time))/60;
         /* if time is grater than 5 min than exipre otp */
          if($expire_time_on >= 5){

             return response()->json(['status' => Statuscodes::Unauthorized,'message'=>'This otp has expired please resend otp and verify again !','data'=> $store]);
          }
          //Update status on otp table
          $update=Otp::where('id', $check_otp->id)->update(['status'=>1]);
          if($update !=1){
            return response()->json(['status' => Statuscodes::Unauthorized,'message'=>'This otp is not match.Please enter valid otp and verify again','data'=> $store]);
          }
         $store['verify_status']=1;
          return response()->json(['status' => Statuscodes::Okay,'message'=> 'This otp is verified successfully ','data'=> $store]);
      }

    }
    return response()->json(['status' => Statuscodes::Unauthorized,'message'=>'This otp is not match.Please enter valid otp and verify again','data'=>$store]);


}




}
