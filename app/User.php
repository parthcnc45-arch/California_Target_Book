<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Jobs\SendPasswordReset;

\Stripe\Stripe::setApiKey(config("app.STRIPE_KEY"));


class User extends Authenticatable
{
    use Notifiable;

    const ROLE_SUBSCRIBER = 'subscriber';
    const ROLE_EDITOR = 'editor';
    const ROLE_ADMIN = 'admin';
    const VALID_ROLES = [self::ROLE_SUBSCRIBER, self::ROLE_EDITOR, self::ROLE_ADMIN];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'company_id',
        'password',
        'role',
        'stripe_id',
        'email_token',
        'verified',
        'api_token',
        'notes',
        'register_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_token',
        'stripe_id',
    ];

    protected $attributes = [
        'verified' => 0,
        'role' => self::ROLE_SUBSCRIBER,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->attributes['api_token'] =  bin2hex(random_bytes(30));
        });
    }

    public function subscriptions() {
        return $this->belongsToMany('App\Subscription')
            ->withPivot('role')
            ->using('App\SubscriptionUser');
    }


    public function getIsAdminAttribute()
    {
        return $this->role === self::ROLE_ADMIN;
    }
    public function isAdmin() {
        return $this->getIsAdminAttribute();
    }

    public function name() {
        return "$this->first_name $this->last_name";
    }

    // Get profile of user and exclude things like password, etc.
    public function profile() {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->name(),
            'email' => $this->email,
            'company' => Company::find($this->company_id)->name,
            'has_active_subscription' => !empty($this->latestSubscription()),
        ];
    }

    public function setPassword($pass) {
        $this->password = \Hash::make($pass);;
        $this->save();
    }

    public function activeSubscription() {
        return $this->subscriptions()
            ->get()
            ->first();
    }

    public function settings() {
        return $this->hasOne('App\UserSettings');
    }
    public function company() {
        return $this->belongsTo('App\Company');
    }

    // Get active or pending subscription
    public function latestSubscription() {
        return $this->subscriptions()
            ->get()
            ->first(function ($sub) {
                return $sub->isActive() || $sub->isPending();
            });
    }

    public function hasActiveSubscription()
    {
        return $this->subscriptions()
            ->get()
            ->contains(function ($sub) {
                return $sub->isActive();
            });
    }

    public function addInvoiceItem($item) {
        $item['currency'] = 'usd';
        $item['customer'] = $this->stripe_id;

        return \Stripe\InvoiceItem::create($item);
    }

    public function createInvoice($invoice) {
        $invoice['customer'] = $this->stripe_id;
        $invoice['statement_descriptor'] = 'California Target Book';
        // $invoice['billing'] = 'send_invoice';
        // $invoice['days_until_due'] = 30;
        // dd($invoice,$this->stripe_id);

        return \Stripe\Invoice::create($invoice);
    }

    public function sendPasswordResetNotification($token)
    {
        dispatch(new SendPasswordReset($this, $token));
    }
}
