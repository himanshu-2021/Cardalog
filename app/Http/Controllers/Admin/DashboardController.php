<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\Storage;
class DashboardController extends Controller
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
    public function index()
    {
        $active_users=Users::where('login_status',1)
        ->whereDate('created_at',date('Y-m-d'))
        ->whereNotIn('role',[1])->get();

        $in_active_users=Users::where('login_status',0)
        ->whereDate('created_at',date('Y-m-d'))
        ->whereNotIn('role',[1])->get();

        $today_registration=Users::whereDate('created_at',date('Y-m-d'))
        ->whereNotIn('role',[1])->get();
        return view('admin.dashboard',['active_user'=>$active_users,
        'in_active_users'=>$in_active_users,'today_registration'=>$today_registration,
        ]);

    }

/* admin profile details */
public function profile($id=null){
      
    if($id==null){
        return redirect(route('admin.user.list'))->with('error', 'Invalid  profile please try again !');
       exit;
     }

    
    $userdetails=Users::where('id',$id)->first();
    return view('admin.profile',['details'=>$userdetails]);
    
}
  /* admin profile update details */
  public function update(Request $request){
    $this->validate($request,[
        'userId'=>'required|max:50',
       
     ]);
     
     $store=array(
         'name'=>$request->name,
         'email'=>$request->email,
     );
     
     if($request->password !=''){
        $store['password']=bcrypt($request->password);
      }
      

     

     $update=Users::where('id',$request->userId)->update($store);
     if($update==1){
        notify()->success('Your profile has been  updated successfully !');
         return redirect('admin/profile/'.$request->userId);
     }else{
        notify()->error('Failed to update account please try again  !');
      
         return redirect('admin/profile/'.$request->userId);
     }

}


}
