<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    // in months
    const VALID_SUBSCRIPTION_LENGTHS = [0, 12, 24];

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_EXPIRED = 'expired';

    protected $fillable = [
        'frequency',
        'account_id',
        'next_payment',
        'end_date',
        'status',
        'wordpress_subscription_id',
    ];

    public function status() {
        if ($this->isActive()) {
            return self::STATUS_ACTIVE;
        }
        if ($this->isPending()) {
            return self::STATUS_PENDING;
        }
        return self::STATUS_EXPIRED;
    }

    public function isActive() {
        return $this->cycles()
            ->get()
            ->contains(function ($cycle) {
                return $cycle->isCurrent();
            });
    }

    public function isPending() {
        return $this->cycles()
            ->get()
            ->contains(function ($cycle) {
                return $cycle->isPending();
            });
    }

    public function getCurrentCycle() {
        return $this->cycles()->get()
            ->sortByDesc('ends_on')
            ->first(function ($c) {
                return $c->isCurrent();
            });
    }

    public function getLatestCycle() {
        return $this->cycles()->get()
            ->sortByDesc('ends_on')
            ->first(function ($c) {
                return !empty($c->ends_on);
            });
    }

    public function cycles() {
        return $this->hasMany('App\Cycle');
    }

    public function users() {
        return $this->belongsToMany('App\User')
            ->withPivot('role')
            ->using('App\SubscriptionUser');
    }
    public function book_subscriptions() {
        return $this->hasMany('App\BookSubscription');
    }

    public function subscriber() {
        return $this->users()->wherePivot('role', SubscriptionUser::SUBSCRIBER);
    }
    public function addons() {
        return $this->users()->wherePivot('role', SubscriptionUser::ADDON);
    }

    /**
     * Create addon account for this subscription
     * @param $addonEmail
     */
    public function addUser($addonEmail, $body = []) {

        $baseAccount = User::find($this->account_id);

        $existing = User::where(['email' => $addonEmail])->first();

        if (empty($existing)) {
            $addonBody = User::make([
                'email' => $addonEmail,
                'first_name' => $body['first_name'] ?? null,
                'last_name' => $body['last_name'] ?? null,
                'company_id' => $baseAccount->company_id,
                'email_token' => base64_encode($addonEmail),
                'api_token' => \Illuminate\Support\Str::random(60),
            ]);
        } else {
            $addonBody = $existing;
            if (empty($addonBody->first_name) && !empty($body['first_name'])) {
                $addonBody->first_name = $body['first_name'];
            }
            if (empty($addonBody->last_name) && !empty($body['last_name'])) {
                $addonBody->last_name = $body['last_name'];
            }
            if ($addonBody->isDirty()) {
                $addonBody->save();
            }
        }

        $addon = $this->users()
            ->save($addonBody, ['role' => SubscriptionUser::ADDON]);

        dispatch(new Jobs\SendAddonInvitation($baseAccount, $addon));

        return $addon;
    }

    public function getProductName() {
        $hasPrint = $this->book_subscriptions()->count() > 0;
        return self::determineProductName((int)$this->frequency, $hasPrint);
    }

    public static function determineProductName($frequency, $hasPrint) {
        if ($frequency === (int)config('subscriptions.duration_one_year')) {
            return $hasPrint 
                ? config('subscriptions.names.one_year_print') 
                : config('subscriptions.names.one_year_online');
        } elseif ($frequency === (int)config('subscriptions.duration_two_year')) {
            return $hasPrint 
                ? config('subscriptions.names.two_year_print') 
                : config('subscriptions.names.two_year_online');
        } elseif ($frequency === 0) {
            return config('subscriptions.names.trial');
        } else {
            return "CTB Online Subscription (" . $frequency . " Months)";
        }
    }

}
