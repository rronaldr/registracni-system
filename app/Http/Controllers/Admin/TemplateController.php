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
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(TemplateFacade $templateFacade): view
    {
        $templates = $templateFacade->getApprovedTemplates();

        return view('admin.templates', [
            'templates' => $templates,
        ]);
    }

    public function create(): view
    {
        return view('admin.templates-create');
    }

    public function store(Request $request, TemplateFacade $templateFacade): RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'html' => 'required'
            ]);

            $templateFacade->createTemplate($request);
        } catch (\Exception $e) {
            Session::flash('error', trans('template.error'));
            dump($e);
        }
        Session::flash('message', trans('template.saved'));

        return redirect()->route('admin.templates');
    }

    public function send(TemplateFacade $templateFacade): RedirectResponse
    {
        $user = User::find(1);

        $template = Template::find(2);
        $tags['test'] = 'ahoj';
        $finalHtml = $templateFacade->getTemplateHtmlWithParams(5, $user);

        Mail::to(['test@ronald.sk'])
            ->send(new CustomHtmlMail($user, $finalHtml));

        return redirect()->route('admin.templates');
    }
}
