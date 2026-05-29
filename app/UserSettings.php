<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Extra settings attached to user
 */

class UserSettings extends Model
{
   protected $fillable = [
       'admin_notify_signup',
       'admin_notify_feedback',
   ];
}
