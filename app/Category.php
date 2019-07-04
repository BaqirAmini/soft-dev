<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\company;

class Category extends Model
{
    protected $primaryKey = "ctg_id";
    public function item()
    {
        return $this->hasMany(Item::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    

}
