<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Ticket;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class PhotoController extends Controller
{
    public function index():Response
    {
        return Inertia::render('Front/Client/Photos', [
            'photos' => Photo::where('user_id', auth()->user()->id)->latest()->first()
        ]);
    }

    public function show(Photo $photo, Request $request)
    {
        if($request->get('theme') == 'white'){
            return Inertia::render('Front/Client/Show', [
                'photos' => $photo
            ]);
        }else{

            return Inertia::render('Front/Client/ShowBl', [
                'photos' => $photo
            ]);
        }
    }

    public function filter():Response
    {
        return Inertia::render("Front/Client/Filter", [
            'photos' => Photo::where('user_id', auth()->user()->id)->latest()->first()
        ]);
    }

    public function qrcode(Photo $photo):Response
    {
        return Inertia::render("Front/Client/Qrcode", [
            'photo' => $photo
        ]);
    }

    public function filterColor(Request $request):RedirectResponse
    {

        $photo = Photo::findOrFail($request->id);
        $photo['filter'] = $request->filter;
        $photo->save();
        return redirect()->route('photo.index');
    }

    public function clientIndex():Response
    {
        // return Inertia::render('Front/Client/Home');
        return Inertia::render('Front/Client/CameraTest');
    }

    public function store(Request $request):RedirectResponse
    {
        $code = session()->get('code');
        $ticket = Ticket::where('ticket_code', $code)->first();
        if($ticket) {
            $ticket->ticket_used = 1;
            $ticket->save();
        };
        Photo::create([
            'user_id'=>auth()->user()->id,
            'image'=>json_encode($request->images),
            'folder'=>auth()->user()->name
        ]);

        return redirect()->route('photo.filter');
    }

    public function downloadIndex(Photo $photo):Response
    {
        return Inertia::render('Front/Client/Download', [
            'photos'=>$photo
        ]);
    }
}
