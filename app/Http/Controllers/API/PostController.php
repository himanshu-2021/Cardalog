<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Validator;
use File;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\Statuscodes;
class PostController extends BaseController
{

    protected $ruleSet;

	/**
	 * AuthController constructor.
	 */
	public function __construct(){
		$this->ruleSet = config('rules');
  }

   /* Post created */
   public function create(Request $request){
    $validator = Validator::make($request->all(), $this->ruleSet['post']);
    if($validator->fails()){
        return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
    }

    $store=$request->all();

    $user_id=$request->user_id;

    unset($store['file']);
   
    $file = $request->file('file');

    if( $file !=''){
      $ext=$file->getClientOriginalExtension();

      if(($request->file_type==1) &&  ($ext=='mkv')  || ($ext=='mp4')   || ($ext=='flv')  || ($ext=='avi')  || ($ext=='wmv') ){
        $destinationPath = 'storage/app/public/'.$user_id."/videos"; // upload path
          }elseif(($request->file_type==0) && ($ext=='bmp') || ($ext=='jpg') || ($ext=='jpeg')  || ($ext=='png')){
          $destinationPath = 'storage/app/public/'.$user_id."/images"; // upload path
        }else{
          return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Invalid file type or file please enter valid type or file !']);
          exit;
        } 
        $profileImage = date('YmdHis') . "." .  $file->getClientOriginalExtension();
        $file->move($destinationPath, $profileImage);
        $store['file']=$destinationPath.'/'.$profileImage;
      }
    Post::create($store);
    return response()->json(['status' => Statuscodes::Okay,'message'=> 'Post has been created successfully','data'=> $store]);
  }
  
  public function delete_post(Request $request){
    $validator = Validator::make($request->all(), $this->ruleSet['post-delete']);
    if($validator->fails()){
        return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
    }
    $delete=Post::where('id',$request->post_id)->update(['status'=>0]);
    if($delete==1){
      return response()->json(['status' => Statuscodes::Okay,'message'=> 'Post has been deleted successfully']);
    }else{
      return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Failed to delete post please try again']);
    }
  }


  public function edit_post(Request $request){
      $validator = Validator::make($request->all(), $this->ruleSet['post']);
      if($validator->fails()){
          return response()->json(['status'=>Statuscodes::InvalidRequestFormat,'message'=>$validator->errors()->first()]);
      }

    $store=$request->all();
    $post_id=$request->post_id;
    $user_id=$request->user_id;
    unset($store['file']);
    unset($store['post_id']);
    unset($store['user_id']);
    $file = $request->file('file');

    if( $file !=''){
      $ext=$file->getClientOriginalExtension();

      if(($request->file_type==1) &&  ($ext=='mkv')  || ($ext=='mp4')   || ($ext=='flv')  || ($ext=='avi')  || ($ext=='wmv') ){
        $destinationPath = 'storage/app/public/'.$user_id."/videos"; // upload path
          }elseif(($request->file_type==0) && ($ext=='bmp') || ($ext=='jpg') || ($ext=='jpeg')  || ($ext=='png')){
          $destinationPath = 'storage/app/public/'.$user_id."/images"; // upload path
        }else{
          return response()->json(['status' => Statuscodes::InvalidRequestFormat,'message'=> 'Invalid file type or file please enter valid type or file !']);
          exit;
        } 
        $profileImage = date('YmdHis') . "." .  $file->getClientOriginalExtension();
        $file->move($destinationPath, $profileImage);
        $store['file']=$destinationPath.'/'.$profileImage;
      }
       Post::where('id',$request->post_id)->update($store);

       return response()->json(['status' => Statuscodes::Okay,'message'=> 'Post has been updated successfully','data'=> $store]);
  }



}
