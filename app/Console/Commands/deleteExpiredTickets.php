<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class deleteExpiredTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tickets = Ticket::latest()->get();
        foreach ($tickets as $ticket) {
            $date = Carbon::create($ticket->ticket_by_date, 'Asia/Yangon')->addDays($ticket->ticket_duration);
            if($date->toDateTimeString() < Carbon::today()->toDateString()){
                $ticket->delete();
            }
        }
        return;
    }
}
