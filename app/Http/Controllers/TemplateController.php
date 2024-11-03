<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TemplateController extends Controller
{
    public function index() {
        $template = Template::get();
        return Inertia::render('Admin/Template/Index',['templateData' => $template]);
    }

    public function store(Request $request) {
        
        $request->validate([
            "template" => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (Template::count() >= 1) {
            return response()->json([
                'error' => 'Only one template can be uploaded.',
                'status' => false
            ]);
        }else{
            $filename = null;
    
            if ($request->hasFile('template')) {
                
                $filename = $request->file('template')->store('template', 'public');
            } else {
                logger("No template file uploaded."); 
            }

            $template = Template::create([
                'user_id' => null,
                'name' => $request->name ?? null,
                'template' => $filename,
                'description' => $request->description ?? null,
            ]);
        
            
            return response()->json([
                'data' => $template,
                'status' => true
            ],200);
        }
    
        
    }

    public function update(Request $request,$id) {
       

        $request->validate([
            "template" => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $template = Template::find($id);

        $filename = $template->template;

        if ($request->hasFile('template')) {
           
            if (!empty($filename)) {
               
                logger("Deleting existing template file: $filename");
        
                
                if (Storage::disk('public')->exists($filename)) {
                    Storage::disk('public')->delete($filename);
                    logger("Successfully deleted: $filename");
                } else {
                    logger("File does not exist and cannot be deleted: $filename");
                }
            }
        
            
            $filename = $request->file('template')->store('template', 'public');
        }
        

        $template->update([
            'user_id' => null,
            'name' => $request->name?? null,
            'template' => $filename,
            'description' => $request->description?? null,
        ]);
        return response()->json([
            'data' => $template,
            'status' => true
        ],200);
    }

    public function destroy($id) {
        $template = Template::find($id);
        $filename = $template->template;
        if (Storage::disk('public')->exists($filename)) {
            Storage::disk('public')->delete($filename);
            logger("Successfully deleted: $filename");
        } else {
            logger("File does not exist and cannot be deleted: $filename");
        }

        return response()->json([
           'status' => true
        ],200);
    }
    
}
