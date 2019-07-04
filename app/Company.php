<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey = "company_id";
    protected $table = "companies";

    protected $fillable = ['status', 'user_count'];
    
    public function user() {
        return $this->hasMany(User::class);
    }
    
    public function compStatus() {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $companies = DB::table('companies')
            ->join('users', 'companies.company_id', '=', 'users.comp_id')
            ->select('companies.comp_status')
            ->where('users.id', $id)
            ->get();
            $compStatus = $companies[0]->comp_status;
            return $compStatus;
        }
        
    }
}
