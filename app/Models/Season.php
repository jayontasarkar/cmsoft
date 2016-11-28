<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ["name", "start_date", "end_date", 'active'];

    protected $dates = ["start_date", "end_date"];

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::parse($value);
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::parse($value);
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }
}
