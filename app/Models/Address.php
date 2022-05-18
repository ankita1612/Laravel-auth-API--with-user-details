<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\PersonAddress;
class Address extends Model
{
    use HasFactory;
    protected $table="address";
    protected $primaryKey = 'id';
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function person_address()
    {
        return $this->hasOne(PersonAddress::class,"address_id","person_id");
    }


}
