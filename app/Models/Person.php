<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address;
use App\Models\PersonAddress;

class Person extends Model
{
    use HasFactory;    
    protected $table="person";
    protected $primaryKey = 'person_id';

}
