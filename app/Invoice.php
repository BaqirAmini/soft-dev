<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\Sale;
use App\Payment;

class Invoice extends Model
{

    protected $primaryKey = "inv_id";
    // Customer...
    public function customer() {
        return $this->belongsTo(Customer::class, 'cust_id');
    }

    // Sale...
    public function sale() {
        return $this->hasMany(Sale::class);
    }
    // Payment
    public function payment()
    {
        return $this->hasMany(Payment::class, 'inv_id');
    }
}
