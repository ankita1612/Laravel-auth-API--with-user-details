<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address;
use App\Models\Country;

class State extends Model
{
    use HasFactory;
    protected $table="state";
    protected $primaryKey = 'id';
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    // public function address()
    // {
    //     return $this->hasOne(Address::class,'address_id','id')->with("person_address");
    // }
}
