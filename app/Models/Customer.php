<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ["name", "phone", "address", "area_id"];

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

    public function payments()
    {
        return $this->hasManyThrough('App\Models\Payment', 'App\Models\Schedule', 'customer_id', 'schedule_id', 'id' );
    }
}
