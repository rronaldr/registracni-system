<?php

declare(strict_types = 1);

namespace App\Services;

use App\Mail\CustomHtmlMail;
use App\Repositories\EventRepository;
use App\Services\Admin\BlacklistFacade;
use App\Services\Admin\DateFacade;
use App\Services\Admin\TemplateFacade;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;

class EmailFacade
{
    private TemplateFacade $templateFacade;

    public function __construct(
        TemplateFacade $templateFacade
    ){
        $this->templateFacade = $templateFacade;
    }
    public function sendUserEnrolledEmail(): void
    {
//        $userData = $this->userFacade->getUserForEmail($user->id);
//        $templateWithContent = str_replace('[message]', $event->template_content, $template->html);
//        $finalHtml = Blade::render($templateWithContent, ['user' => $userData, 'params' => $enrollmentData->toArray()]);
//        Mail::to([$user->email])
//            ->send(new CustomHtmlMail($event->template_subject, $finalHtml, $userData));
    }
}
