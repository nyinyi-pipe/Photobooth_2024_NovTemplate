<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Ticket;

class TicketStatus implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ticket = Ticket::where('ticket_code',$value)->first();
        if($ticket){
            return $ticket->status && !$ticket->ticket_used;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This ticket had disabled.';
    }
}
