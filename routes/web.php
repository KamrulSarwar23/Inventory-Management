<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerification;

use Illuminate\Support\Facades\Route;

// API Routes
Route::post('/userRegistration', [UserController::class, 'UserRegistration']);
Route::post('/userLogin', [UserController::class, 'UserLogin']);
Route::post('/sendOTP', [UserController::class, 'SendOTPCode']);
Route::post('/verifyOTP', [UserController::class, 'VerifyOTP']);
Route::post('/resetPassword', [UserController::class, 'ResetPassword'])->middleware([TokenVerification::class]);
Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware([TokenVerification::class]);
Route::post('/user-profile-update', [UserController::class, 'ProflleUpdate'])->middleware([TokenVerification::class]);
Route::get('/logout',[UserController::class,'userLogout']);

// Page Routes
Route::get('/',[UserController::class,'HomePage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerification::class]);
Route::get('/dashboard',[UserController::class,'DashboardPage'])->middleware([TokenVerification::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerification::class]);
