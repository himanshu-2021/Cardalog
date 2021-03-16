<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
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
        $Post=Post::leftJoin('users as t1','t1.id','=','post.user_id')->select('t1.name as user_name','post.*')->orderBy('t1.id','DESC')->paginate(10);
        return view('admin.user.post.list',['post'=>$Post]);

    }

    public function details($post_id)
    {
        $id=base64_decode($post_id);
        $Post=Post::leftJoin('users as t1','t1.id','=','post.user_id')->select('t1.name as user_name','post.*')
        ->where('post.id',$id)->first();
      
        return view('admin.user.post.details',['post'=>$Post]);

    }

    

}
