<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Events\ExpireOtp;

class GoogleLoginController extends Controller
{
    public function signIn()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {

        try{
            Auth::logout();
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('gauth_id', $googleUser->id)->first();

            $otp = \Str::random(5);
      
            if($user){
      
                Auth::login($user);

                ExpireOtp::dispatch($user);
     
                return view('user',['otp'=>$otp,'email'=>$googleUser->email,'name'=>$googleUser->name]);
      
            }else{
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'gauth_id'=>$googleUser->id,
                    'gauth_type'=> 'google',
                    'password' => encrypt('password'),
                    'otp'=>$otp
                ]);
     
                Auth::login($newUser);
      
                return view('user',['otp'=>$otp,'email'=>$googleUser->email,'name'=>$googleUser->name]);
            }
     
        } catch (Exception $e) {
            info('Login error', [$e]);
            redirect()->back()->with(['error'=>'An error occured, please try again']);
        }
    }

    public function user()
    {
        $user = auth()->user();
        return view('user',['otp'=>$user->otp,'email'=>$user->email,'name'=>$user->name]);
    }

}
