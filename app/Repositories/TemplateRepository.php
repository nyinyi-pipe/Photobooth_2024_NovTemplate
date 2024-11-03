<?php


namespace App\Repositories;

use App\Models\Template;
use Illuminate\Support\Facades\Storage;

class TemplateRepository
{
    public function getAll()
    {
        return Template::all();
    }

    public function findById($id)
    {
        return Template::find($id);
    }

    public function create(array $data)
    {
        return Template::create($data);
    }

    public function update(Template $template, array $data)
    {
        $template->update($data);
        return $template;
    }

    public function delete(Template $template)
    {
        if ($template->template && Storage::disk('public')->exists($template->template)) {
            Storage::disk('public')->delete($template->template);
        }
        return $template->delete();
    }
}
