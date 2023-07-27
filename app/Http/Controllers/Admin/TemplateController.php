<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomHtmlMail;
use App\Mail\DefaultMail;
use App\Models\Template;
use App\Models\User;
use App\Repositories\TemplateRepository;
use App\Services\EventFacade;
use App\Services\TemplateFacade;
use App\Services\UserFacade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
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
                'html' => 'required_without:text',
                'text' => 'required_without:html',
            ]);

            $templateFacade->createTemplate($request);

            Session::flash('message', trans('app.templates.saved-approval'));

            return redirect()->route('admin.templates');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function show(int $id, TemplateFacade $templateFacade): view
    {
        $template = $templateFacade->getTemplateById($id);

        return view('admin.templates-detail', [
            'template' => $template,
        ]);
    }

    public function edit(int $id, TemplateFacade $templateFacade): View
    {
        $template = $templateFacade->getTemplateById($id);

        return view('admin.templates-edit', [
            'template' => $template,
        ]);
    }

    public function update(int $id, Request $request, TemplateFacade $templateFacade): RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'html' => 'required_without:text',
                'text' => 'required_without:html',
            ]);

            $templateFacade->updateTemplate($id, $request);

            Session::flash('message', trans('app.templates.updated'));
            return redirect()->back();

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    public function destroy(int $id, TemplateFacade $templateFacade): RedirectResponse
    {
        $templateFacade->deleteTemplate($id);

        Session::flash('message', trans('app.templates.deleted'));

        return back();
    }

    public function sendTest(int $id, TemplateFacade $templateFacade, UserFacade $userFacade): RedirectResponse
    {
        $currentUser = $userFacade->getUserForEmail($userFacade->getCurrentUser()->id);
        $template = $templateFacade->getTemplateById($id);

        Mail::to([$currentUser->email])
            ->send(new CustomHtmlMail($currentUser, $template->html));

        return redirect()->route('admin.templates');
    }

    public function approvals(TemplateFacade $templateFacade): view
    {
        $templates = $templateFacade->getTemplatesForApproval();

        return view('admin.templates-approval', [
            'templates' => $templates,
        ]);
    }

    public function approve(int $id, TemplateFacade $templateFacade): RedirectResponse
    {
        $templateFacade->approveTemplate($id);

        return redirect()->back()->with('message', __('app.templates.approved'));
    }

    public function showAuthorTemplates(int $userId, TemplateFacade $templateFacade): view
    {
        $templates = $templateFacade->getTemplatesByUser($userId);

        return view('admin.templates', [
            'templates' => $templates,
        ]);
    }
}
