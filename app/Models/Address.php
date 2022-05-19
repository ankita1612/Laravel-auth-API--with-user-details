<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Person;
class Address extends Model
{
    use HasFactory;
    protected $table="address";
    protected $primaryKey = 'id';
    // public function state()
    // {
    //     return $this->belongsTo(State::class);
    // }
    // public function person_address()
    // {
    //     return $this->hasOne(PersonAddress::class,"address_id","person_id");
    // }
    public function adress_person()
    {
        return $this->belongsToMany(Person::class,'person_address');
        // OR return $this->hasOne('App\Phone');
    }


}
