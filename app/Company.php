<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;

    protected $fillable = [
       'name',
       'address_id',
    ];

    public function address() {
        return $this->belongsTo('App\Address');
    }
}
