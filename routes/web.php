<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\PostController as AdminUserPost;
use App\Http\Controllers\Admin\PageController as AdminPage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

/* Frontend Routes Collection */
Route::get('/', [HomeController::class,'index']);
Route::get('/about-us', [HomeController::class,'about_us']);
Route::get('/terms-and-conditions', [HomeController::class,'terms_conditions']);
Route::get('/privacy-policy', [HomeController::class,'privacy_policy']);
Route::get('/location-service-policy', [HomeController::class,'location_service_policy']);

/* Backend Routes  */

Route::prefix('admin')->group(function (){
    Route::get('/dashboard', [AdminDashboard::class,'index'])->name('admin.dashboard');
    Route::get('/profile/{id}', [AdminDashboard::class,'profile'])->name('admin.profile');
    Route::post('/profile-update', [AdminDashboard::class,'update'])->name('admin.profile-update');


    /*--Pages routes--*/
    Route::prefix('page')->group(function (){
        Route::get('/content', [AdminPage::class,'index'])->name('admin.page.content');
        Route::post('/about-us-update', [AdminPage::class,'about_us'])->name('admin.page.about-us-update');
        Route::post('/terms-conditions-update', [AdminPage::class,'terms_conditions'])->name('admin.page.content.terms-conditions-update');
        Route::post('/privacy-policy-update', [AdminPage::class,'privacy_policy'])->name('admin.page.content.privacy-policy-update');
        Route::post('/location-service-policy-update', [AdminPage::class,'location_service_policy'])->name('admin.page.content.location-service-policy-update');
    });
    /* pages content  */

    /*--User routes--*/
    Route::prefix('user')->group(function (){
        Route::get('/videos', [AdminUser::class,'video'])->name('admin.user.videos');
        Route::get('/list', [AdminUser::class,'index'])->name('admin.user.list');
        Route::post('/search', [AdminUser::class,'search_user'])->name('admin.user.search');
        Route::get('/profile/{id}', [AdminUser::class,'profile'])->name('admin.user.profile');
        Route::post('/account-update', [AdminUser::class,'update'])->name('admin.user.account-update');
        Route::get('/acount-delete/{id}', [AdminUser::class,'delete'])->name('admin.user.acount-delete');
         
        /* User Post Routes */
        Route::prefix('post')->group(function (){
            Route::get('/', [AdminUserPost::class,'index'])->name('admin.user.post');
            Route::get('/details/{post_id}', [AdminUserPost::class,'details'])->name('admin.user.post.details');
        }); 

    });
   /*--User routes end--*/


});
