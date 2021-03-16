<?php

/**
 * |----------------------------------------------------------------------------------------------------
 * |  This file contains all the validation rules used throughout the app.
 * |  Each rule group is divided into subsets of various categories, so use them through nesting.
 * |----------------------------------------------------------------------------------------------------
 */

use App\Interfaces\Tables;
use Illuminate\Validation\Rule;
return [

			'login' => [
				'email' => ['bail', 'required', 'email','exists:users,email','max:100'],
				'password' => ['bail', 'required', 'string', 'max:20'],
				'device_id' => ['bail', 'required', 'string'],
            ],

            'forgot-password' => [
                'auth_type' => ['bail', 'required','string', 'max:50'],

				'email' => ['bail', 'required_if:auth_type,0', 'email', 'exists:users,email','nullable'],
               'mobile' => ['bail', 'required_if:auth_type,1', 'numeric', 'exists:users,mobile','nullable'],

               // 'password' => ['bail','required_if:social_type,email', 'min:10','max:20','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','nullable'],
               'password' => ['bail','required', 'min:10','max:20','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            ],

            'verify_otp' => [
                'auth_type' => ['bail', 'required','string', 'max:50'],
                'email' => ['bail', 'required_if:auth_type,0', 'email', 'exists:users,email','nullable'],
                'mobile' => ['bail', 'required_if:auth_type,1', 'numeric', 'exists:users,mobile','nullable'],
                'otp' => ['bail', 'required','numeric', 'min:111111', 'max:999999'],
            ],

            'send_otp' => [
                'auth_type' => ['bail', 'required','string', 'max:50'],
                'email' => ['bail', 'required_if:auth_type,0', 'email', 'exists:users,email','nullable'],
                'mobile' => ['bail', 'required_if:auth_type,1','numeric', 'exists:users,mobile','nullable'],

            ],

            'change_password' => [
                'user_id' => ['bail', 'required', 'exists:users,id'],
                'password' => ['bail','required_if:social_type,email', 'min:10','max:20','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','nullable'],
				'confirm_password' => ['bail', 'required_with:password','same:password' ,'string', 'min:10','max:20'],

            ],

            'common_check' => [
                'user_id' => ['bail', 'required', 'exists:users,id'],
            ],

            'block' => [
                'from_user_id' => ['bail', 'required', 'exists:users,id','max:20'],
                'block_user_id' => ['bail', 'required', 'exists:users,id','max:20'],
                'reason_for_block' => ['bail' ,'max:2000','nullable'],
            ],

            'profile_update' => [
                'user_id' => ['bail', 'required', 'exists:users,id'],
                'name' => ['bail', 'string', 'max:100','nullable'],
                'nick_name' => ['bail', 'string', 'max:100','nullable'],
                'mobile' => ['bail', 'max:15','unique:users,mobile','nullable'],
                'phone_code' => ['bail','max:5','exists:country,phone_code','nullable'],
                'country' => ['bail',  'string','unique:users,mobile','exists:country,country_nicename','nullable'],
                'dob'=>['bail','date_format:Y-m-d','nullable'],
                'gender'=>['bail','string','max:10','nullable'],
                'avatar'=>['bail','mimes:jpg,jpeg,png,bmp','nullable'],
                'contact_details'=>['bail','max:200','nullable'],
            ],

            'post' => [
                'user_id' => ['bail', 'required', 'exists:users,id'],
                'title' => ['bail', 'string', 'max:100','nullable'],
                'conversation' => ['bail','required', 'string', 'max:10'],
                'billing_per_minute' => ['bail','required', 'string', 'max:15'],
                'pieces' => ['bail','required', 'numeric','min:1', 'max:11'],
                'file'=>['bail','mimes:jpg,jpeg,png,bmp,mkv,mp4,flv,avi,wmv','min:1','max:2048000'],
                'file_type'=>['bail','required','max:1','numeric'],
            ],

            'post-delete' => [
                'post_id' => ['bail', 'required', 'exists:post,id'],
            ],

            'post' => [
                'user_id' => ['bail', 'required', 'exists:users,id'],
                'post_id' => ['bail', 'required', 'exists:post,id'],
                'title' => ['bail', 'string', 'max:100','nullable'],
                'conversation' => ['bail','required', 'string', 'max:10'],
                'billing_per_minute' => ['bail','required', 'string', 'max:15'],
                'pieces' => ['bail','required', 'numeric','min:1', 'max:11'],
                'file'=>['bail','mimes:jpg,jpeg,png,bmp,mkv,mp4,flv,avi,wmv','min:1','max:2048000'],
                'file_type'=>['bail','required','max:1','numeric'],
            ],
            //new work
            'send-message' => [
                'user_id' => ['bail', 'required', 'exists:users,id'],
                'to' => ['bail', 'required'],
                'message'=>['bail','required'],
                'chat_type' => ['bail', 'required'],
            ],
            'create-group' => [
                'user_id' => ['bail','array','required', 'exists:users,id'],
                'group_name' => ['bail','string', 'required','min:1','max:255'],
                'group_icon'=>['bail','mimes:jpg,jpeg,png,bmp','required'],
                //'group_creater_user_id' => ['bail', 'required', 'numeric'],
                'master'=>['bail','required', 'numeric'],
            ],


];
