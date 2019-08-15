<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public static function rules() {
        return [
            'first_name' => 'required|string|max:64',
            'last_name' => 'nullable|string|max:64',
            'phone' => 'required|unique:users|string|min:10',
            'email' => 'nullable|unique:users|email|string|min:10',
            'user_name' => 'required|unique:users|string|min:5',
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'phone', 'email', 'role', 'password', 'username', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    // To define role
    public function isAdmin() {
        return $this->role;
    }

    // To return User-Status for checking
    public function userStatus() {
        return $this->status;
    }
    public function company()
    {
        return $this->belongsTo('App\Company', 'comp_id');
    }
    
}
