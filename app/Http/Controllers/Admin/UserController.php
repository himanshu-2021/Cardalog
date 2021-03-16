<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /* Users List */
    public function index()
    {
        $users=Users::orderBy('id','DESC')->where('is_deleted',0)->whereNotIn('role',[1])->paginate(10);
        return view('admin.user.list',['users'=>$users]);

    }

      /*Search Users List */
      public function search_user(Request $request)
      {   
       $this->validate($request,[
            'keyword'=>'required|max:100',
         ]);
         
          $users=Users::where('name',$request->keyword)
          ->where('is_deleted',1)
          ->orWhere('email',$request->keyword)
          ->orWhere('mobile',$request->keyword)
          ->orWhere('gender',$request->keyword)
          ->orWhere('nick_name',$request->keyword)
          ->orWhere('contact_details',$request->keyword)
          ->whereNotIn('role',[1])
          ->orderBy('id','DESC')->paginate(9);
          if(!count($users)>0){
            

            notify()->error('Users not found please try again after sme time !');
            return redirect(route('admin.user.list'));
            exit;
          }
         
          
          return view('admin.user.list',['users'=>$users]);
  
      }
    
    
    /* User profile details */
    public function profile($id=null){
      
        if($id==null){
            notify()->error('Invalid user profile please try again !');
            return redirect(route('admin.user.list'));
           exit;
         }
         
        $userId = base64_decode($id);
        $userdetails=Users::where('id',$userId)->first();
        return view('admin.user.profile',['details'=>$userdetails]);
        
    }

    /* User profile update details */
    public function update(Request $request){
        $this->validate($request,[
            'userId'=>'required|max:50',
           
         ]);
         
         $store=array(
             'name'=>$request->name,
             'nick_name'=>$request->nick_name,
             'mobile'=>$request->mobile,
             'gender'=>$request->gender,
             'email'=>$request->email,
             'contact_details'=>$request->contact_details,
             'account_status'=>$request->account_status,
             //'login_status'=>$request->login_status,
             //'is_deleted'=>$request->is_deleted,
         );
   
         $update=Users::where('id',$request->userId)->update($store);
         if($update==1){
            notify()->success('Profile updated successfully !');
            return redirect(route('admin.user.list'));
         }else{
            notify()->error('Failed to update account please try again !');
            return redirect(route('admin.user.list'));
            
         }

    }
    
    /* User profile delete */
    public function delete($id=null){

        if($id==null){
            return redirect(route('admin.user.list'))->with('error', 'Failed to delete account please try again !');
           exit;
         }

        $userId = base64_decode($id);
      

        $delete=Users::where('id',$userId)->update(['is_deleted'=>(int)1]);
        if($delete==1){
            notify()->success('Account deleted successfully !');
            return redirect(route('admin.user.list'));
        }else{
            notify()->error('Failed to delete account please try again !');
            return redirect(route('admin.user.list'));
        }
    }
    
      /* User profile delete */
      public function video($id=null){
        return view('admin.user.videos');
      }

}
