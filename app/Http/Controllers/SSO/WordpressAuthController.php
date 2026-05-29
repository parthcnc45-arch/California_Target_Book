<?php

namespace App\Http\Controllers\SSO;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class WordpressAuthController extends Controller
{

    public function login(Request $request)
    {
        $email_new =base64_decode($request->RegUS7GUvL0bGD3);
        $token = $request->key;
        $user = User::where('email',$email_new)->where('api_token',$token)->first();
        
        // $key='amuzBwLjU9d7GUvL0bGD38i5';//this is default key
        // if (!Hash::check($key, $request->key)) {
        //     return false; 
        // } 
        if($user){
            $sub = $user->latestSubscription();
            if (!empty($sub)) {
                if($sub->status == 'active' && $sub->isActive()){
                    Auth::guard('web')->login($user, true);
                    return true;
                }
                else{
                    Auth::guard('web')->logout();
                    return false;
                }
            }
            else{
                Auth::guard('web')->logout();
                return false;
            }
        }
        return true;
    }
    public function chk()
    {
        $key='amuzBwLjU9d7GUvL0bGD38i5';
        $k=password_hash($key, PASSWORD_BCRYPT);
        if (Hash::check($key, $k)) {
            return response()->json(['success'=>true, 'message' => 'great']);
         }
        return 'false';

    }

    public function getActiveUsers()
    {
        $users=User::with('subscriptions')->where('role','subscriber')->where('verified',1)->get();
        if ($users!=null){
            return response()->json([
                'data' => $users,
                'success'=>true
            ]);
        }
        return response()->json([
            'message' => 'no record found',
            'success'=>false
        ]);
    }

}
