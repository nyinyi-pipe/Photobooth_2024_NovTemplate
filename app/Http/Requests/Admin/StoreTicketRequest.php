<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ticket_by_date'=>'required',
            'ticket_mount'=>'required',
            'number_of_tickets'=>'required',
        ];
    }

    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
public function messages()
{
    return [
        'ticket_by_date.required' => 'A ticket date is required',
        'ticket_mount.required' => 'A ticket mount is required',
        'ticket_duration.required' => 'A ticket duration is required',
        'number_of_tickets.required' => 'A ticket type is required',
    ];
}

 
}
