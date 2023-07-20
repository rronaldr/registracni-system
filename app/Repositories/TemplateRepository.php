<?php

declare(strict_types = 1);

namespace App\Repositories;
use App\Models\Template;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TemplateRepository
{

    public function getById(int $id): Template
    {
        /** @var \App\Models\Template $template */
        $template = Template::query()
            ->where('id', $id)
            ->first();

        return $template;
    }

    public function getApprovedTemplates(): LengthAwarePaginator
    {
        return Template::query()
            ->where('approved', true)
            ->with('author')
            ->paginate(10);
    }

    public function getUnapprovedTemplates(): LengthAwarePaginator
    {
        return Template::query()
            ->where('approved', false)
            ->with('author')
            ->paginate(10);
    }

    public function getTemplatesByUser(int $id): LengthAwarePaginator
    {
        return Template::query()
            ->where('user_id', $id)
            ->with('author')
            ->paginate(10);
    }
}
