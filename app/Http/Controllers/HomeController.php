<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            return view('home');
    }

    public function about_us()
    {
        $page=Pages::where('id',1)->first();
        return view('pages/about_us',['content'=>$page]);
    }

    public function privacy_policy()
    {
        $page=Pages::where('id',1)->first();
        return view('pages/privacy_policy',['content'=>$page]);
    }

    public function terms_conditions()
    {
        $page=Pages::where('id',1)->first();
        return view('pages/terms_and_conditions',['content'=>$page]);
    }

    public function location_service_policy()
    {
        $page=Pages::where('id',1)->first();
        return view('pages/location_service_policy',['content'=>$page]);
    }
}
