<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'customer_id', 'id');
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Account::class, 'customer_id', 'account_id');
    }
}
