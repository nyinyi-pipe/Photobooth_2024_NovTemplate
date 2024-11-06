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
            "template" => 'required|image|mimes:jpeg,png,jpg',
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
            "template" => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $template = Template::find($id);

        $filename = $template->template;

        if ($request->hasFile('template')) {
           
            if (!empty($filename)) {
               
                if (Storage::disk('public')->exists($filename)) {
                    Storage::disk('public')->delete($filename);
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
            
        } else {
            logger("File does not exist and cannot be deleted: $filename");
        }
        $template->delete();

        return response()->json([
           'status' => true
        ],200);
    }

    public function checkTemplate(){
        $template = Template::get();
        if (count($template) > 0) {
            return response()->json([
               'status' => true
            ],200);
        }else {
            return response()->json([
               'status' => false
            ],200);
        }
    }
    
}
