<?php

namespace App\Services;

use App\Repositories\TemplateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class TemplateService
{
    protected $repository;

    public function __construct(TemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTemplates()
    {
        return $this->repository->getAll();
    }

    public function storeTemplate(Request $request)
    {
        if ($this->repository->getAll()->count() >= 1) {
            throw new Exception('Only one template can be uploaded.');
        }

        $filename = null;
        if ($request->hasFile('template')) {
            $filename = $request->file('template')->store('template', 'public');
        }

        return $this->repository->create([
            'user_id' => null,
            'name' => $request->name,
            'template' => $filename,
            'description' => $request->description,
        ]);
    }

    public function updateTemplate(Request $request, $id)
    {
        $template = $this->repository->findById($id);
        if (!$template) {
            throw new Exception('Template not found.');
        }

        $filename = $template->template;
        if ($request->hasFile('template')) {
            if (!empty($filename) && Storage::disk('public')->exists($filename)) {
                Storage::disk('public')->delete($filename);
            }
            $filename = $request->file('template')->store('template', 'public');
        }

        return $this->repository->update($template, [
            'user_id' => null,
            'name' => $request->name,
            'template' => $filename,
            'description' => $request->description,
        ]);
    }

    public function deleteTemplate($id)
    {
        $template = $this->repository->findById($id);
        if (!$template) {
            throw new Exception('Template not found.');
        }

        $this->repository->delete($template);
    }
}
