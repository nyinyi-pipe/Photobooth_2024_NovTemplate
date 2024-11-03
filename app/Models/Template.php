<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = ['event_id','user_id','name','template','description'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
