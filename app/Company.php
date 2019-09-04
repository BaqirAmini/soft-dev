<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    protected $primaryKey = "company_id";
    protected $table = "companies";

    protected $fillable = ['status', 'email','user_count'];

    public function user() {
        return $this->hasMany('App\User', 'comp_id');
    }

    // Company
    public function customer() {
        return $this->hasMany(Customer::class);
    }

}
