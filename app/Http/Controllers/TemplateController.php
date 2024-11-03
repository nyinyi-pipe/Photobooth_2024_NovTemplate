<?php

// app/Http/Controllers/TemplateController.php

namespace App\Http\Controllers;

use App\Services\TemplateService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class TemplateController extends Controller
{
    protected $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function index()
    {
        $templateData = $this->templateService->getAllTemplates();
        return Inertia::render('Admin/Template/Index', ['templateData' => $templateData]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "template" => 'required|image|mimes:jpeg,png,jpg',
        ]);

        try {
            $template = $this->templateService->storeTemplate($request);
            return response()->json(['data' => $template, 'status' => true], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => false], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "template" => 'required|image|mimes:jpeg,png,jpg',
        ]);

        try {
            $template = $this->templateService->updateTemplate($request, $id);
            return response()->json(['data' => $template, 'status' => true], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => false], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->templateService->deleteTemplate($id);
            return response()->json(['status' => true], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => false], 400);
        }
    }
}

