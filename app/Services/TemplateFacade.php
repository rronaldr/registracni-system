<?php

declare(strict_types = 1);

namespace App\Services;
use App\Mail\DefaultMail;
use App\Models\User;
use App\Repositories\TemplateRepository;
use Illuminate\Database\Eloquent\Collection;
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

    public function getTemplateHtml(int $id, User $user): ?string
    {
        $template = $this->templateRepository->getById($id);

        if (!$template->hasParams()) {
            return $template->html;
        }

        return Blade::render($template->html, ['user' => $user, 'params' => $template->getParamsAsArray()]);
    }
}
