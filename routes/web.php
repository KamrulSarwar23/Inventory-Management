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

// User Logout
Route::get('/logout',[UserController::class,'UserLogout']);

// Page Routes
Route::get('/',[UserController::class,'HomePage']);
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage']);
Route::get('/dashboard',[UserController::class,'DashboardPage']);
Route::get('/userProfile',[UserController::class,'ProfilePage']);
