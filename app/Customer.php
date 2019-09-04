<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $primaryKey = "cust_id";
    protected $table = "customers";
    // Invoice
    public function invoice() {
        return $this->belongsTo(Customer::class, 'cust_id');
    }

    // Company
    public function company() {
        return $this->belongsTo(Customer::class, 'comp_id');
    }

}
