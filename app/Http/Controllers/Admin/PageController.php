<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Pages;
class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $pages=Pages::where('id',1)->first();

        return view('admin.pages', ['pages'=>$pages]);
    }
     /* This function abotus page updated */
    public function about_us(Request $request){
        $this->validate($request,[
            'content'=>'required|max:2000',
         ]);

         $update=Pages::where('id',1)->update(['about_us'=>$request->content]);
         if($update==1){
            notify()->success('About us  has been  updated successfully !');
            return redirect('admin/page/content');
         }else{
            notify()->error('Failed to update about us  please try again  !');
             return redirect('admin/page/content');
         }
    }

    /* This function using terms & conditions page updated */
    public function terms_conditions(Request $request){
        $this->validate($request,[
            'content'=>'required|max:2000',
         ]);

         $update=Pages::where('id',1)->update(['terms_conditions'=>$request->content]);
         if($update==1){
            notify()->success('Terms & conditions  has been  updated successfully !');
            return redirect('admin/page/content');
         }else{
            notify()->error('Failed to update terms & conditions please try again  !');
            return redirect('admin/page/content');
         }
    }

       /* This function privacy policy page updated */
    public function privacy_policy(Request $request){
        $this->validate($request,[
            'content'=>'required|max:2000',
         ]);

         $update=Pages::where('id',1)->update(['privacy_policy'=>$request->content]);
         if($update==1){
            notify()->success('Privacy policy has been  updated successfully !');
            return redirect('admin/page/content');
         }else{
            notify()->error('Failed to update privacy policy please try again  !');
            return redirect('admin/page/content');
         }
    }

     /* This function location service policy page updated */
    public function location_service_policy(Request $request){
        $this->validate($request,[
            'content'=>'required|max:2000',
         ]);

         $update=Pages::where('id',1)->update(['location_service_policy'=>$request->content]);
         if($update==1){
            notify()->success('Location service policy has been  updated successfully !');
            return redirect('admin/page/content');
         }else{
            notify()->error('Failed to update location service policy please try again  !');
            return redirect('admin/page/content');
         }
    }
}
