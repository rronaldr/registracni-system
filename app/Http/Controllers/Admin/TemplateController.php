<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(): view
    {
        $templates = Template::query()
            ->paginate(10);

        return view('admin.templates', [
            'templates' => $templates,
        ]);
    }

    public function create(): view
    {
        return view('admin.templates-create');
    }

    public function store(): RedirectResponse
    {

    }
}
