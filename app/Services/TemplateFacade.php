<?php

declare(strict_types = 1);

namespace App\Services;
use App\Mail\DefaultMail;
use App\Models\Template;
use App\Models\User;
use App\Repositories\TemplateRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class TemplateFacade
{

    private TemplateRepository $templateRepository;
    private UserFacade $userFacade;

    public function __construct(TemplateRepository $templateRepository, UserFacade $userFacade)
    {
        $this->templateRepository = $templateRepository;
        $this->userFacade = $userFacade;
    }

    public function getApprovedTemplates(): LengthAwarePaginator
    {
        return $this->templateRepository->getApprovedTemplates();
    }

    public function getTemplatesForApproval(): LengthAwarePaginator
    {
        return $this->templateRepository->getUnapprovedTemplates();
    }

    /**
     * @throws ValidationException
     */
    public function createTemplate(Request $request): void
    {
        $template = new Template();
        $this->setTemplateAttributes($request, $template);
        $template->user_id = $this->userFacade->getCurrentUser()->id;
        $template->save();
    }

    /**
     * @throws ValidationException
     */
    public function updateTemplate(int $id, Request $request): void
    {
        $template = $this->templateRepository->getById($id);
        $this->setTemplateAttributes($request, $template);
        $template->save();

    }

    public function deleteTemplate(int $id): void
    {
        $template = $this->templateRepository->getById($id);
        $template->deleteOrFail();
    }

    public function checkTemplateContainsContent(string $content): bool
    {
        if (preg_match('/\[content]/', $content)) {
            return true;
        }

        return false;
    }

    public function getTemplateHtmlWithParams(int $id, User $user): ?string
    {
        $template = $this->templateRepository->getById($id);

        if (!$template->hasParams()) {
            return $template->html;
        }

        return Blade::render($template->html, ['user' => $user, 'params' => $template->getParams()->toArray()]);
    }

    public function approveTemplate(int $id): void
    {
        $template = $this->templateRepository->getById($id);
        $template->approved = true;
        $template->save();
    }

    public function getTemplatesByUser(int $userId): LengthAwarePaginator
    {
        return $this->templateRepository->getTemplatesByUser($userId);
    }

    public function getTemplateById(int $id): Template
    {
        return $this->templateRepository->getById($id);
    }

    private function setTemplateAttributes(Request $request, Template $template): Template
    {
        $template->name = $request->name;
        $html = $request->type === 'default'
            ? $request->text
            : $this->cleanHtmlBody($request->html);

        if (!$this->checkTemplateContainsContent($html)) {
            throw ValidationException::withMessages(['content' => __('app.templates.content-missing')]);
        }

        $template->html = $html;
        $template->type = $request->type;

        return $template;
    }

    private function cleanHtmlBody(string $html): string
    {
        preg_match("/<body[^>]*>(.*?)<\/body>/is", $html, $bodyContent);
        preg_match("/<body[^>]*>(.*?)/si", $html, $bodyTag);

        $purifiedBodyHtml = sprintf("%s%s</body>",$bodyTag[0], clean($bodyContent[0]));
        $cleanedHtml = preg_replace("/<body[^>]*>(.*?)<\/body>/is", $purifiedBodyHtml, $html);

        return $cleanedHtml;
    }
}
