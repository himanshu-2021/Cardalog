<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Users;
use Validator;
use File;


use Illuminate\Support\Facades\Hash;
use App\Interfaces\Statuscodes;

class RegisterController extends BaseController
{

   
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function socialRegister(Request $request)
    {
        $validator = Validator::make($request->all(), $this->social_rules());
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]); 
        }

        if(!($request->social_type =='facebook' || $request->social_type =='apple' || $request->social_type =='kakaotalk' || 
        $request->social_type =='google')){
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,
            'message'=>'Please enter valid social_type']); 
            exit;
        }

      $get_data= Users::where('email',$request->email)->first();
        if(!empty($get_data)){
            
            return response()->json(['status' => Statuscodes::Okay,
            'message'=>'Congratulations your account has been successfully created','data'=> $get_data]); 
        }else{
                $store=$request->all();
                unset($store['avatar']);
                $store['role']=0;
                $insert=Users::create(array_filter($store));
                $file = $request->file('avatar');
               
                if($insert){
                $file = $request->file('avatar');
                $store['token'] =  $insert->createToken('MyApp')->accessToken;
                $store['device_id'] =  $request->device_id;
                $user_id=$insert->id;
                if(! empty($user_id)){
                     //create directory
                    File::makeDirectory(base_path("/storage/app/public/".$user_id), 0755, true);
                    File::makeDirectory(base_path("/storage/app/public/".$user_id."/videos"), 0755, true);
                    File::makeDirectory(base_path("/storage/app/public/".$user_id."/images"), 0755, true);
                   if( $file !=''){
                        unset($store['avatar']);
                        $destinationPath = 'storage/app/public/'.$user_id."/images"; // upload path
                        $profileImage = date('YmdHis') . "." .  $file->getClientOriginalExtension();
                        $file->move($destinationPath, $profileImage);
                       $store_img['avatar']=$destinationPath.'/'.$profileImage;
                       Users::where('id',$user_id)->update($store_img);
                    }
                    $user_data= Users::where('id',$user_id)->first();
                    //send notification to mobile
                    // $this->push_notification($request->device_id,'Congratulations your account has been successfully created');
                    //send mail
                 
                  //$this->send_mail($request->name='', $request->email);
                    //$this->send_sms($mobile,'Your account has been register ');
                    return response()->json(['status' => Statuscodes::Okay,
                    'message'=>'Congratulations your account has been successfully created','data'=> $user_data]);
                }else{
                    return response()->json(['status' => Statuscodes::InvalidRequestFormat,
                    'message'=>'Failed to create registration !']);
                }
        }
    }
}

    public function register_user(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules());
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }

        $store=$request->all();
       
         $store['role']=0;
 
         if($request->password !=''){
            $store['password']=Hash::make($request->password);
         }

         $insert=Users::create(array_filter($store));
      if($insert){
            $store['token'] =  $insert->createToken('MyApp')->accessToken;
            $store['device_id'] =  $request->device_id;
            $user_id=$insert->id;
            if(! empty($user_id)){
                 //create directory
                File::makeDirectory(base_path("/storage/app/public/".$user_id), 0755, true);
                File::makeDirectory(base_path("/storage/app/public/".$user_id."/videos"), 0755, true);
                File::makeDirectory(base_path("/storage/app/public/".$user_id."/images"), 0755, true);
               
           }
           
          $user_data= Users::where('id',$user_id)->first();
          //send notification to mobile
            // $this->push_notification($request->device_id,'Congratulations your account has been successfully created');
        //send mail
         $this->send_mail($name='', $request->email);
        //$this->send_sms($mobile,'Your account has been register ');
            return response()->json(['status' => Statuscodes::Okay,
            'message'=>'Congratulations your account has been successfully created','data'=> $user_data]);
        }else{
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,
            'message'=>'Failed to create registration !']);
        }

    }

    public function send_m(){
        $mobile='917024974254';
        $messiage='The cardalog verfiy otp is 445544';
        $this->twillo_send_mobile_sms($mobile,$messiage);
    }
     
     public function rules()
    {
        return [
        'social_type' => ['bail', 'required', 'string',  'max:10'],
        'email' => ['bail', 'required', 'email','unique:users,email'],
        'password' => ['bail','required_if:social_type,email', 'min:10','max:20','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','nullable'],
        'confirm_password' => ['bail', 'required_with:password','same:password' ,'string','min:10','max:20', 'nullable'],
        'device_id' => ['bail', 'required', 'string'],
        ];
    }
    
    public function social_rules(){
        return [ 
        'social_type' => ['bail', 'required', 'string',  'max:10'],
        'email' => ['bail', 'required', 'email'],
        'name' => ['bail',  'string', 'min:2', 'max:100','nullable'],
        'avatar' => ['bail','mimes:jpg,jpeg,png,bmp','nullable'],
        'dob ' => ['bail','date_format:Y-m-d','nullable'],
        'gender ' => ['bail',  'string', 'min:2', 'max:10','nullable'],
        'device_id' => ['bail', 'required', 'string'],
     ];
    }

   
}
