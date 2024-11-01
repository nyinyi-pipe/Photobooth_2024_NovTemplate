<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = ['ticket_code','ticket_mount','ticket_by_date','ticket_duration','number_of_tickets'];
    protected $date;

    public function getTicketByDateAttribute($value){
        $this->date = $value;
        return date('d/m/y',strtotime($value));
    }

    public function setTicketTypeAttribute($value){
        $this->attributes['ticket_type'] = Str::lower($value);
    }

    public function getTicketTypeAttribute($value){
        return ucwords($value);
    }

    public function getTicketDurationAttribute($value){
        $date = Carbon::create($this->date, 'Asia/Yangon')->addDays($value);
        return date('d/m/y',strtotime($date->toDateTimeString()));
    }
}
