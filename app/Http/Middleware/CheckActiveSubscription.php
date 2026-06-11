<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sub = Auth::user()->activeSubscription();

        //this is only for testing purpose
        // if (Auth::user()->email==='joe@epicenterconsulting.com' && Auth::user()->id==722) {
        //     return $next($request);
        // }
        if ($sub && $sub->isActive()) {

            $isTrial = $sub->frequency === 0;

            if ($isTrial && !Session::has('trial_end')) {
                $cycle = $sub->getLatestCycle();
                Session::put('trial_end', (new Carbon($cycle->ends_on))->toFormattedDateString());

            } else if (!Session::has('cycle_end')) {
                $cycle = $sub->getLatestCycle();
                $ending = (new Carbon($cycle->ends_on))->between(Carbon::now(), Carbon::now()->addDays(90));
                if ($ending) {
                    Session::put('cycle_end', (new Carbon($cycle->ends_on))->toFormattedDateString());
                }
            }

            return $next($request);
        }
        return redirect()->route('auth.account.subscriptions')
            ->with('message', 'Your subscription is not active. It is either pending, or you may need to renew it.');
    }
}
