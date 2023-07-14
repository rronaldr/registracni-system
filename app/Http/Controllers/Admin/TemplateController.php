<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomHtmlMail;
use App\Mail\DefaultMail;
use App\Models\Template;
use App\Models\User;
use App\Services\TemplateFacade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(TemplateFacade $templateFacade): view
    {
        $templates = $templateFacade->getApprovedTemplates();

        $user = User::find(1);

        $tags['test'] = 'ahoj';
        $finalHtml = $templateFacade->getTemplateHtml(2, $user);

        return view('admin.templates', [
            'templates' => $templates,
            'html' => $finalHtml,
        ]);
    }

    public function create(): view
    {
        return view('admin.templates-create');
    }

    public function store(): RedirectResponse
    {

    }

    public function send(TemplateFacade $templateFacade): RedirectResponse
    {
        $user = User::find(1);

        $template = Template::find(2);
        $tags['test'] = 'ahoj';
        $finalHtml = $templateFacade->getTemplateHtml(1, $user);

        Mail::to(['test@ronald.sk'])
            ->send(new CustomHtmlMail($template->subject, $user, $finalHtml));

        return redirect()->route('admin.templates');
    }
}
