<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $foreignKey = "inv_id";
    protected $primaryKey = "payment_id";
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    //
}
