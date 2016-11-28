<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
    	"name", "meter_no", "energy_value", "remaining_balance", "user_id"
    ];
}
