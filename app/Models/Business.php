<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = ["name", "description", "business_id", "rate"];


    /**
     * Each Business SubGroup has many Areas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function areas()
    {
        return $this->hasMany('App\Models\Area');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Business', 'business_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Business', 'Business_id');
    }

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

    public function setRateAttribute($value)
    {
        $this->attributes['rate'] = bntoen($value);
    }
}
