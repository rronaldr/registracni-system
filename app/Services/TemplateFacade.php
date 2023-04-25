<?php

declare(strict_types = 1);

namespace App\Services;
use App\Repositories\TemplateRepository;
use Illuminate\Database\Eloquent\Collection;


class TemplateFacade
{

    private TemplateRepository $templateRepository;

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    public function getApprovedTemplates()
    {
        $this->templateRepository->getApprovedTemplates();
    }
}
