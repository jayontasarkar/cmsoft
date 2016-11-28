<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ["name", "description", "business_id"];

    /**
     * Each area belongs to a Business Subgroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
}
