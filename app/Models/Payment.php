<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        "season_id", "business_id", "customer_id", "schedule_id", "amount", "discount"
    ];

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule');
    }

    public function setAmountAttribute($amount)
    {
        $this->attributes['amount'] = floatval(bntoen($amount));
    }
}
