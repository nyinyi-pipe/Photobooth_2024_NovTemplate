<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Models\Ticket;
use App\Http\Requests\Admin\StoreTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Ticket/Index',[
            'tickets'=>Ticket::orderBy('id', 'desc')->paginate(6)
        ]);
    }

    public function getTickets()
    {
        $tickets = Ticket::orderBy('id','desc')->get();
    	return response()->json($tickets);
    }

    public function getFilteredTickets($date)
    {
        // $formattedDate = \Carbon\Carbon::createFromFormat('d-m-y', $date)->format('Y-m-d');
        $tickets = Ticket::where('ticket_by_date', '=', $date)
                ->orderBy('id', 'desc')
                ->get();
    	return response()->json($tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        $request->validated();

        $ticketCodes = array();

        for ($i=0; $i < $request->number_of_tickets ; $i++) { 
            $gerenateCode = mt_rand(100000, 999999);
            $ticket = Ticket::where('ticket_code',$gerenateCode)->first();
            if($ticket){
                $gerenateCode = mt_rand(100000, 999999);
            }
            Ticket::create([
                'ticket_by_date'=>$request->ticket_by_date,
                'ticket_code'=>$gerenateCode,
                'ticket_mount'=>$request->ticket_mount,
                'ticket_duration'=>1 ,
                'number_of_tickets'=>$request->number_of_tickets,
            ]);

            array_push($ticketCodes, $gerenateCode);
        }

        return response()->json(['ticketCodes' => $ticketCodes]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return response()->json([
            'ticket'=>$ticket
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'ticket_by_date'=>$request->ticketDateEdit ?? $ticket->ticket_by_date,
            // 'ticket_duration'=>$request->ticketDurationEdit ?? $ticket->ticket_duration,
            'ticket_mount'=>$request->ticketMount ?? $ticket->ticket_mount,
            'ticket_type'=>$request->ticketType ?? $ticket->ticket_type,
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->back();
    }

    public function generateCode(Request $request){
        dd($request->all);
        $gerenateCode = mt_rand(100000, 999999);
        return response()->json([
            'code'=>$gerenateCode
        ]);
    }

    public function changeStatus(Request $request,$id)
    {
        $ticket = Ticket::findOrFail($id);        
        $ticket->status = $request->status;
        $ticket->save();
        return redirect()->back();
    }
}
