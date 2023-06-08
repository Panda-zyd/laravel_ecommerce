<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminContoller;
use App\Http\Controllers\Authentificatio;
use App\Http\Controllers\Reviewcontroller;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
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
//css
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('categories',[GetDataController::class,'getCategories']);
Route::post('spects/{id}',[GetDataController::class,'getSpects']);
Route::get('getAllproducts',[GetDataController::class,'getAllproducts']);
Route::get('getProduct/{id}',[GetDataController::class,'getProduct']);
Route::get('getAdmins',[GetDataController::class,'getAdmins']);
Route::get('getMain',[GetDataController::class,'getMain']);
Route::get('newArrivals',[GetDataController::class,'newArrivals']);
Route::post('productsSpects',[GetDataController::class,'productsSpects']);
Route::get('GetAllReviews/{id}',[Reviewcontroller::class,'GetAllReviews']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('AjouterProduit',[ProductController::class,'AjouterProduit']);
    Route::post('EditeProduct/{id}',[ProductController::class,'EditProduct']);
    Route::post('DeleteProduct/{idProduct}',[ProductController::class,'DeleteProduct']);
    Route::post('AjouterCatSpect',[CategorieController::class,'AjouterCategorieSpect']);
    Route::post('addAdmin',[AdminContoller::class,'AddAdmin']);
    Route::post('deleteAdmin',[AdminContoller::class,'deleteAdmin']);
    Route::post('ModifierCategorie',[CategorieController::class,'ModifierCategorie']);
    Route::post('DeleteCategorie/{id}',[CategorieController::class,'DeleteCategorie']);
    Route::post('setMain/{id}',[ProductController::class,'setMain']);
    Route::post('addreview',[Reviewcontroller::class,'addreview']);
    Route::get('getAllWishList',[WishlistController::class,'getAllWishList']);
    Route::post('toogle',[WishlistController::class,'toogle']);
});




Route::post('/register', [Authentificatio::class, 'register'])
                ->name('register');

Route::post('/login', [Authentificatio::class, 'login'])
                ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::post('/logout', [Authentificatio::class, 'logout'])
                ->middleware('auth')
                ->name('logout');
