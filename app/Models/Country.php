<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\State;
class Country extends Model
{
    use HasFactory;
    protected $table="country";
    protected $primaryKey = 'id';
    public function state()
    {
        return $this->hasOne(State::class,'country_id','id')->with("address")->with("person_address");
        //return $this->hasManyThrough('State::class', 'App\User');
    }
}
