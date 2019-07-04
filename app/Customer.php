<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $primaryKey = "cust_id";
    // Invoice
    public function invoice() {
        return $this->belongsTo(Customer::class);
    }

    // Company
    public function company() {
        return $this->hasMany(Customer::class);
    }
}
