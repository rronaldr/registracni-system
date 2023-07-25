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


class TemplateFacade
{

    private TemplateRepository $templateRepository;

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    public function getApprovedTemplates(): LengthAwarePaginator
    {
        return $this->templateRepository->getApprovedTemplates();
    }

    public function getTemplatesForApproval(): LengthAwarePaginator
    {
        return $this->templateRepository->getUnapprovedTemplates();
    }

    public function createTemplate(Request $request): void
    {
        $template = new Template();
        $template->name = $request->name;
        $cleanedHtml = $this->cleanHtmlBody($request->html);
        $template->html = $cleanedHtml;
        $template->save();
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

    private function cleanHtmlBody(string $html): string
    {
        preg_match("/<body[^>]*>(.*?)<\/body>/is", $html, $bodyContent);
        preg_match("/<body[^>]*>(.*?)/si", $html, $bodyTag);

        $purifiedBodyHtml = sprintf("%s%s</body>",$bodyTag[0], clean($bodyContent[0]));
        $cleanedHtml = preg_replace("/<body[^>]*>(.*?)<\/body>/is", $purifiedBodyHtml, $html);

        return $cleanedHtml;
    }
}
