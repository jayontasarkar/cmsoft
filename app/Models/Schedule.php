<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        "season_id", "business_id", "customer_id", "description", "event_date", "quantity", "discount", "completed"
    ];

    protected $dates = ["event_date"];

    public function setEventDateAttribute($value)
    {
        $this->attributes['event_date'] = Carbon::parse($value);
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    public function season()
    {
        return $this->belongsTo('App\Models\Season');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
}
