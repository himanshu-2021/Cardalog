<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\Statuscodes;
use App\Models\Chatting;
use App\Models\Diamond;
use App\Models\Group;
use App\Models\Media;
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
        $store=$request->all();
        //media file
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
              $mediaData['path']=$destinationPath.'/'.$media;
              $mediaData['file_type']=$request->file_type;
              $media_id=Media::create(array_filter($mediaData));
              $store['media_id']=$media_id->id;
        }
        //media file uploaded
        $chat_id='Car-'.rand(9999,0000);

        $store['chat_id']=$chat_id;
        if($request->chat_type=='personal'){
            $validator = Validator::make($request->all(),  ['to'=>['bail', 'numeric','exists:users,id'],
                        ]);
            if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
            }
                $store['chat_type']='personal';
        }else{
            $validator = Validator::make($request->all(),  ['group_id'=>['bail', 'required','exists:groups,group_id'],
                        ]);
            if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
            }
                $store['chat_type']='group';
                $store['to']=$request->group_id;
        }
        $store['from_user_id']=$request->user_id;
        //dd($store);
        $insert=Chatting::create(array_filter($store));
        if($insert){
            return response()->json(['status' => Statuscodes::Okay,'message'=> 'Message send successfully','data'=>$insert]);
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
    public function giftDiamonds(Request $request)
    {
        $validator = Validator::make($request->all(),  $this->ruleSet['gift-diamonds']);
        if($validator->fails()){
            return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
        }
        //$store=$request->all();
        $store['sender_id']=$request->user_id;
        if($request->type=="purchase"){
            $validator = Validator::make($request->all(),  ['transection_id'=>['bail', 'required'],
                                                           ]);
            if($validator->fails()){
                return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
            }
            $store['type']='purchase';
            $store['status']='credit';
            $store['diamonds_qty']=$request->quantity;
            $store['transection_id']=$request->transection_id;
        }else{
            $validator = Validator::make($request->all(),  ['reciever_id'=>['bail', 'required', 'numeric','exists:users,id'],
                                                            'image'=>['bail','mimes:jpg,jpeg,png,bmp','required'],]);
            if($validator->fails()){
                return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
            }
            $file = $request->file('image');
            if( $file !=''){
                $ext=$file->getClientOriginalExtension();
                if( ($ext=='bmp') || ($ext=='jpg') || ($ext=='jpeg')  || ($ext=='png')){
                $destinationPath = 'storage/app/public/diamonds/images'; // upload path
                }else{
                return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Invalid file type or file please enter valid type or file !']);
                exit;
                }
                $media = date('YmdHis') . "." .  $file->getClientOriginalExtension();
                $file->move($destinationPath, $media);
                $store['diamonds_images']=$destinationPath.'/'.$media;
            }
            $store['type']='transfer';
            $store['status']='debit';
            $store['diamonds_qty']=$request->quantity;
            $store['reciever_id']=$request->reciever_id;
            //at transfer time android developer must check the quantity not more than credited diamonds (we didn't do it backend)
        }
        $insert=Diamond::create(array_filter($store));
        if($insert){
            if($insert->type=='purchase'){
                $get_user=Users::where('id',$insert->sender_id)->select('id','diamonds')->first();
                //update Diamonds User
                $diamonds=$get_user->diamonds+$insert->diamonds_qty;
                $user=Users::where('id',$get_user->id)->update(['diamonds'=> $diamonds]);
            }else{
                $get_user=Users::where('id',$insert->sender_id)->select('id','diamonds')->first();
                //update Diamonds User
                $diamonds=$get_user->diamonds-$insert->diamonds_qty;
                $user=Users::where('id',$get_user->id)->update(['diamonds'=> $diamonds]);
            }
            return response()->json(['status' => Statuscodes::Okay,'message'=> 'Success','data'=>$insert]);
        }else{
            return response()->json(['status' => Statuscodes::InvalidRequestFormat,
            'message'=>'Failed']);
        }
    }
}
