<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'users_notification';

    protected $fillable = [
        'user_id',
        'renewal_reminders',
        'shipping_emails',
    ];

    /**
     * Get the user that owns the notification settings.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
