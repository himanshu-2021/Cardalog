<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController as MemberRegister;
use App\Http\Controllers\API\LoginController as MemberLogin;
use App\Http\Controllers\API\AuthController as MemberAuth;
use App\Http\Controllers\API\UserController as User;
use App\Http\Controllers\API\PostController as UserPost;
use App\Http\Controllers\API\ChattingController as UserMessage;
use App\Http\Controllers\API\CommonController as Common;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/test_sendsms', [MemberRegister::class,'send_m'])->name('test_sendsms');

Route::prefix('common')->group(function(){
    Route::get('/country', [Common::class,'get_country'])->name('common.country');

    /*
     #Function : This api using showing page content
     #Page: Terms & condition / About us / Privacy Policy / Location service
     */
    Route::get('/pages-content', [Common::class,'pages_content'])->name('common.pages-content');
});


Route::prefix('auth')->group(function(){
    Route::post('/send-otp', [MemberAuth::class,'send_otp'])->name('auth.send-otp');
    Route::post('/verify-otp', [MemberAuth::class,'verify_otp'])->name('auth.verify-otp');
    Route::post('/register', [MemberRegister::class,'register_user'])->name('auth.register');
    Route::post('/social_register', [MemberRegister::class,'socialRegister'])->name('auth.social_register');
    Route::post('/login', [MemberLogin::class,'login'])->name('auth.login');
    Route::post('/forgot-password', [MemberLogin::class,'forgot_password'])->name('auth.forgot-password');

});

Route::middleware('auth:api')->group( function () {

    Route::prefix('user')->group(function(){
        Route::post('/change-password', [User::class,'change_password'])->name('user.change-password');
        Route::post('/all-terms', [User::class,'allterms_update'])->name('user.all-terms');
        Route::post('/profile-update', [User::class,'profile_update'])->name('user.profile-update');
        Route::post('/block', [User::class,'block_user'])->name('user.block');

       /*--User Post Conversation Route--*/
        Route::prefix('post')->group(function(){
            Route::post('/create', [UserPost::class,'create'])->name('user.post.create');
            Route::post('/delete', [UserPost::class,'delete_post'])->name('user.post.delete');
            Route::post('/edit', [UserPost::class,'edit_post'])->name('user.post.edit');

        });
        /*--//User  Post Route--*/
        // new code
         /*--User Post Conversation Route--*/
         Route::prefix('message')->group(function(){
            Route::post('/create', [UserMessage::class,'sendMessage'])->name('user.message.create');
        });
        Route::prefix('group')->group(function(){
            Route::post('/create', [UserMessage::class,'createGroup'])->name('user.group.create');
        });
        /*--//User  Post Route--*/
    });



});
