<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Helper\JWTToken;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    function HomePage()
    {
        return view('pages.home');
    }

    function DashboardPage()
    {
        return view('pages.dashboard.dashboard-page');
    }

    function LoginPage()
    {
        return view('pages.auth.login-page');
    }

    function RegistrationPage()
    {
        return view('pages.auth.registration-page');
    }
    function SendOtpPage()
    {
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage()
    {
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage()
    {
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage()
    {
        return view('pages.dashboard.profile-page');
    }

    public function UserRegistration(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required'],
                'firstName' => ['required'],
                'lastName' => ['required'],
                'mobile' => ['required'],
                'password' => ['required'],
            ]);

            User::create([
                'email' => $request->email,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'mobile' => $request->mobile,
                'password' => $request->password
            ]);
            return response()->json(['status' => 'success', 'message' => 'User Registration Successfull'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Something Went Wrong']);
        }
    }

    public function UserLogin(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $count  = User::where(['email' => $request->email, 'password' => $request->password])->select('id')->first();

        if ($count) {
            $token = JWTToken::CreateToken($request->email, $count->id);

            return response()->json(['status' => 'success', 'message' => 'User Login Successfull'], 200)->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'unauthorized'], 200);
        }
    }

    public function SendOTPCode(Request $request)
    {
        $request->validate([
            'email' => ['required']
        ]);

        $email  = $request->email;
        $count = User::where(['email' => $email])->count();
        $otp  = rand(1000, 9999);

        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));
            $user = User::where('email', $email)->update(['otp' =>  $otp]);
            return response()->json(['status' => 'success', 'message' => '4 Digit OTP Code Send To Your Email'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'unauthorized'], 200);
        }
    }


    public function VerifyOTP(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'otp' => ['required']
        ]);

        $email =  $request->email;
        $otp =  $request->otp;

        $count = User::where(['email' => $email, 'otp' => $otp])->count();

        if ($count == 1) {
            User::where('email', $email)->update(['otp' =>  0]);
            $token = JWTToken::CreateTokenForPassowordReset($email);
            return response()->json(['status' => 'success', 'message' => 'OTP Verified Successfull'], 200)->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'unauthorized'], 200);
        }
    }

    public function ResetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => ['required']
            ]);

            $email = $request->header('email');

            $password = $request->password;

            User::where('email', $email)->update([
                'password' => $password
            ]);

            return response()->json(['status' => 'success', 'message' => 'Password Set Successfull'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'unauthorized'], 200);
        }
    }

    public function userLogout(){
        return redirect('/userLogin')->cookie('token', '', -1);
    }


    public function UserProfile(Request $request){
        $email = $request->header('email');
        $user = User::where('email', $email)->first();
        return response()->json(['status' => 'success', 'message' => 'User Profile', 'data' => $user]);
    }
    


    public function ProflleUpdate(Request $request){
        $email = $request->header('email');
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $mobile = $request->mobile;
        $password = $request->password;
    
        User::where('email', $email)->update([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'mobile' => $mobile,
            'password' => $password
        ]);

        return response()->json(['status' => 'success', 'message' => 'User Profile Update Successfull']);
    }
}
