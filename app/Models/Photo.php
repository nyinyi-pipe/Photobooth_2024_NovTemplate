<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','image','device_id','ticket_id','payment_id','status','folder'];

    public function getImageAttribute($value){
        return json_decode($value);
    }
}
