<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = ['nama', 'email', 'password'];
}
