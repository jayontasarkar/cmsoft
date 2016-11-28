<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ["name", "description", "amount", "business_id", "season_id", "user_id", "created_at"];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function season()
    {
        return $this->belongsTo('App\Models\Season');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = (float) bntoen($value);
    }
}
