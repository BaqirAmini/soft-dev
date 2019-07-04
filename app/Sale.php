<?php

namespace App;
use App\Item;
use App\Customer;
use App\Invoice;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['inv_id', 'comp_id', 'item_id', 'qty_sold', 'sell_price', 'subtotal'];
    protected $primaryKey = "sale_id";
    public function item() {
        return $this->hasMany(Item::class);
    }

    public function customer() {
        return $this->hasMany(Customer::class);
    }
    // Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
