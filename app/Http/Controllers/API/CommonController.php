<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\Pages;
use Validator;
use App\Interfaces\Statuscodes;

class CommonController extends BaseController
{

    protected $ruleSet;

	/**
	 * AuthController constructor.
	 */
	public function __construct(){

		$this->ruleSet = config('rules');
    }

   /* Get country list */
   public function get_country(){
    $get=Country::orderBy('country','ASC')->get();
    return response()->json(['status' => Statuscodes::Okay,'message'=> 'Show all country','data'=>$get]);
  }

  /* Terms & conditions  content */
  public function pages_content(){


    $store=array('terms_and_conditions'=>url('terms-and-conditions'),'privacy_policy'=>url('privacy-policy'),
    'location_service_policy'=>url('location-service-policy'));
    return response()->json(['status' => Statuscodes::Okay,'message'=> 'Show page content ','data'=>$store]);
  }

}
