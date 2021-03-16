<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\Users;
use App\Models\Block;
use Validator;
use App\Interfaces\Statuscodes;
use File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class UserController extends BaseController
{

    protected $ruleSet;

	/**
	 * AuthController constructor.
	 */
	public function __construct(){

		$this->ruleSet = config('rules');
    }

    /* Update Password api */
    public function change_password(Request $request){
        $validator = Validator::make($request->all(), $this->ruleSet['change_password']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }
        $update=Users::where('id',$request->user_id)->update(['password'=>Hash::make($request->password)]);
        if($update==1){
            return response()->json(['status' => Statuscodes::Okay,'message'=> 'Password has been changed successfully']);
        }else{
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Failed to change password please try again','data'=>$get]);
        }

    }

    /* Terms && conditions | Privacy Policy | Location service */
    public function allterms_update(Request $request){
        $validator = Validator::make($request->all(), $this->ruleSet['common_check']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }
        $store=array('terms_conditions'=>$request->terms_use,'privacy_policy'=>$request->privacy_policy,'location_service_policy'=>$request->location_service_policy);
        $update=Users::where('id',$request->user_id)->update($store);
        if($update==1){
            return response()->json(['status' => Statuscodes::Okay,'message'=> 'I agree to all terms has been updated successfully']);
        }else{
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Failed to select all terms','data'=>$get]);
        }
    }

    /* This function using user profile update */
    public function profile_update(Request $request){
        $validator = Validator::make($request->all(), $this->ruleSet['profile_update']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }

        $store=array_filter($request->all());
         $user_id=$request->user_id;
         unset($store['user_id']); //remove user id array item
        /* Profile Image upload */
        $file = $request->file('avatar');
        if( $file !=''){
            $get_user=Users::where('id',$user_id)->first();
            unset($store['avatar']);

            if($get_user->avatar !='' || $get_user->avatar !=null){
                File::Delete($get_user->avatar); // delete old file
               }

            $destinationPath = 'storage/app/public/'.$user_id."/images"; // upload path
            $profileImage = date('YmdHis') . "." .  $file->getClientOriginalExtension();
            $file->move($destinationPath, $profileImage);
           $store['avatar']=$destinationPath.'/'.$profileImage;
        }

        $insert=Users::where('id',$user_id)->update($store);
        if($insert==1){
            return response()->json(['status' => Statuscodes::Okay,'message'=> 'Profile has been updated successfully','data'=>$store]);
        }else{
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Failed to update profile']);
        }


    }
    
    /* User block one 2 one api */
    public function block_user(Request $request){
        $validator = Validator::make($request->all(), $this->ruleSet['block']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }
            $store=array(
            'user_id'=>$request->from_user_id,
            'block_user_id'=>$request->block_user_id,
            'reason_for_block'=>$request->reason_for_block,
            'status'=>$request->status,
             );

         $check=Block::where('user_id',$request->from_user_id)->where('block_user_id',$request->block_user_id)->first();
        if(! empty($check)){
            $insert=Block::where('id',$check->id)->update($store);
        }else{
            $insert=Block::create($store);
        }
        
        if($request->status==1){
            $b_status='block';

        }else{
            $b_status='unblock';

        }
         
         if($insert || $insert==1){
            return response()->json(['status' => Statuscodes::Okay,'message'=> 'Profile bas been '.$b_status.' successfully','data'=>$store]);
        }else{
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Failed to '.$b_status.' profile']);
        }
      
    }
   

}
