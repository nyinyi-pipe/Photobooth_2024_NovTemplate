<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Template;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Crypt;

class PhotoController extends Controller
{
    public function index():Response
    {
        $photo = Photo::where('user_id', auth()->user()->id)->latest()->first();
        $photoId = Crypt::encryptString($photo->id);
        return Inertia::render('Front/Client/Photos', [
            'photos' => $photo,
            'template' => Template::get(),
            'photoId' => $photoId ?? $photo->id,
        ]);
    }

    public function show($id, Request $request)
    {
        $photoId = Crypt::decryptString($id);
        $photo = Photo::findOrFail($photoId);
        $template = Template::get();
        $photoIdHashed = Crypt::encryptString($photo->id);
        
        if($request->get('theme') == 'white'){
            return Inertia::render('Front/Client/Show', [
                'photos' => $photo,
            ]);
        }else if($request->get('theme') == 'custom'){
            return Inertia::render('Front/Client/ShowCustomTemplate', [
                'photos' => $photo,
                'template' => $template,
                'photoId' => $photoIdHashed ?? $photo->id
            ]);
        }else{

            return Inertia::render('Front/Client/ShowBl', [
                'photos' => $photo,
            ]);
        }
    }

    public function filter():Response
    {
        return Inertia::render("Front/Client/Filter", [
            'photos' => Photo::where('user_id', auth()->user()->id)->latest()->first()
        ]);
    }

    public function qrcode($id): Response
    {
        $photoId = Crypt::decryptString($id);
        $photo = Photo::findOrFail($photoId);
        $hashedId = Crypt::encryptString($photo->id);

        return Inertia::render("Front/Client/Qrcode", [
            'photo' => $photo,
            'hashedId' => $hashedId,
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
       
        return Inertia::render('Front/Client/CameraTest');
    }

    public function store(Request $request): RedirectResponse
    {
        $code = session()->get('code');
        $ticket = Ticket::where('ticket_code', $code)->first();

        if ($ticket) {
            $ticket->ticket_used = 1;
            $ticket->save();
        }

        $images = $request->images;
        $resizedImages = [];

        $manager = new ImageManager(array('driver' => 'gd'));

        foreach ($images as $base64Image) {

            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

            $image = $manager->make($decodedImage);

            $image->resize(3840, 2160, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $resizedImageData = 'data:image/' . $image->mime() . ';base64,' . base64_encode($image->encode($image->mime()));

            $resizedImages[] = $resizedImageData;
        }

        Photo::create([
            'user_id' => auth()->user()->id,
            'image' => json_encode($resizedImages),
            'folder' => auth()->user()->name,
        ]);

        return redirect()->route('photo.filter');
    }

    public function downloadIndex($id)
    {
        
        
        $photoId = Crypt::decryptString($id);
        $photo = Photo::findOrFail($photoId);
        $template = Template::get();
        logger($template);
        return Inertia::render('Front/Client/Download', [
            'photos'=>$photo,
            'template'=> $template
        ]);
    }
}
