<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Http\Resources\TicketResource;
use App\Models\User;
use App\Models\Ticket;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index():Response
    {
        return Inertia::render("Admin/DashboardTest",[
            'staffs'=>UserResource::collection(User::with('roles')->get()),
            'tickets'=>TicketResource::collection(Ticket::all())
        ]);
        // return Inertia::render("Admin/OnGoingDashboard");
        // return Inertia::render("Admin/Dashboard");
    }
}
