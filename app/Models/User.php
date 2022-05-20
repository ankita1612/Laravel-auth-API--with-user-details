<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
  
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table="login";
    protected $primaryKey = 'person_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [      
        'email',
        'pass',
    ];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pass',  
    ];
  

   
}