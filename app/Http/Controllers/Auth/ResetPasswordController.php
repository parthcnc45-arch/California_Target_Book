<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

use App\User;
use App\Jobs\SendAddonInvitation;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function markVerifiedAndRedirect(Request $request, $token = null) 
    {
        $email = $request->get('email');
        
        $user = User::where('email', $email)->first();

        if (empty($user)) {
            return redirect('/');
        }

        if (!$user->verified) {
            $user->verified = 1;
            $user->save();
            // Send verification email to base account's add ons
            $user->activeSubscription()->addons()
                ->get()
                ->each(function ($addon) use ($user) {
                    dispatch(new SendAddonInvitation($user, $addon));
                });
        }

        return $this->showResetForm($request, $token);

        // return redirect("/password/reset/$token")
        //     ->with(['token' => $token, 'email' => $email])
        //     ->withInput(['token' => $token, 'email' => $email]);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
            ->with('message', 'Password set successfully.')
            ->with('status', trans($response));
    }
}
