<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function nasabah()
    {
        return $this->hasMany(Customer::class, 'room_id');
    }
}
