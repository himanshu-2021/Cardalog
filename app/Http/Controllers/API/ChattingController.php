<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Statuscodes;
use App\Models\Chatting;
use App\Models\Group;
use App\Models\Users;
//use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Validator;

class ChattingController extends Controller
{
    protected $ruleSet;
    /**
	 * ChattingController constructor.
	 */
	public function __construct(){

		$this->ruleSet = config('rules');
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(),  $this->ruleSet['send-message']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }
        $chat_id='Car-'.rand(9999,0000);
        $store=$request->all();
        $store['chat_id']=$chat_id;
        if($request->chat_type=='personal'){
                $store['chat_type']='personal';
        }else{
                $store['chat_type']='group';
                $store['to']=$request->group_id;
        }
        $store['from_user_id']=$request->user_id;
        $insert=Chatting::create(array_filter($store));
        if($insert){
            //media file
            $mediaData=[];
            $file = $request->file('file');
            if( $file !=''){
                $ext=$file->getClientOriginalExtension();
                if(($request->file_type==1) &&  ($ext=='mkv')  || ($ext=='mp4')   || ($ext=='flv')  || ($ext=='avi')  || ($ext=='wmv') ){
                  $destinationPath = 'storage/app/public/group/videos'; // upload path
                }elseif(($request->file_type==0) && ($ext=='bmp') || ($ext=='jpg') || ($ext=='jpeg')  || ($ext=='png')){
                $destinationPath = 'storage/app/public/group/images'; // upload path
                }else{
                return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Invalid file type or file please enter valid type or file !']);
                exit;
                }
                  $media = date('YmdHis') . "." .  $file->getClientOriginalExtension();
                  $file->move($destinationPath, $media);
                  $mediaData['file']=$destinationPath.'/'.$media;

            }
            return response()->json(['status' => Statuscodes::Okay,'message'=> 'Message send successfully']);
        }else{
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,
            'message'=>'Failed to send message!']);
        }
    }
    public function createGroup(Request $request)
    {
        $validator = Validator::make($request->all(),  $this->ruleSet['create-group']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }
        $user_id=$request->master;
        $get_user=Users::where('id',$user_id)->select('id','diamonds')->first();
        if(($get_user->diamonds)>=200){

            $group_id='Room-'.rand(9999,0000);
            $store=$request->all();
            $store['group_id']=$group_id;
            unset($store['group_icon']);

            $file = $request->file('group_icon');

            if( $file !=''){
            $ext=$file->getClientOriginalExtension();
                if( ($ext=='bmp') || ($ext=='jpg') || ($ext=='jpeg')  || ($ext=='png')){
                $destinationPath = 'storage/app/public/group_icon/'.$user_id."/images"; // upload path
                }else{
                return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Invalid file type or file please enter valid type or file !']);
                exit;
                }
                $profileImage = date('YmdHis') . "." .  $file->getClientOriginalExtension();
                $file->move($destinationPath, $profileImage);
                $store['group_icon']=$destinationPath.'/'.$profileImage;
            }
            //admin insert
            unset($store['user_id']);
            $store['user_id']=$request->master;
            $store['master']=1;
            Group::create($store);
            unset($store['master']);
            //user insert
            foreach($request->user_id as $r){
                $store['user_id']=$r;
                $store['master']=0;
                Group::create($store);
            }
            //update Diamonds of master
            $diamonds=$get_user->diamonds-200;
            $user=Users::where('id',$get_user->id)->update(['diamonds'=> $diamonds]);
            $group=Group::where('group_id',$group_id)->get();
            return response()->json(['status' => Statuscodes::Okay,'message'=> 'Group Created Successfully','data'=> $group]);
        }else{
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'You do not have sufficient diamonds']);
        }
    }
}
