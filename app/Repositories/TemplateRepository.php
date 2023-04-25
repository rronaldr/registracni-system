<?php

declare(strict_types = 1);

namespace App\Repositories;
use App\Models\Template;
use Illuminate\Database\Eloquent\Collection;

class TemplateRepository
{

    public function getApprovedTemplates()
    {
        Template::query()
            ->where('approved', 1)
            ->get();
    }
}
