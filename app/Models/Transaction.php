<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
