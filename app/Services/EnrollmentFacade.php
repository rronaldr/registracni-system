<?php

declare(strict_types = 1);

namespace App\Services;

use App\Mail\CustomHtmlMail;
use App\Repositories\EnrollmentRepository;
use App\Services\Admin\DateFacade;
use App\Services\Admin\TemplateFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;


class EnrollmentFacade
{

    private EnrollmentRepository $enrollmentRepository;
    private UserFacade $userFacade;
    private DateFacade $dateFacade;
    private TemplateFacade $templateFacade;

    public function __construct(EnrollmentRepository $enrollmentRepository, UserFacade $userFacade, DateFacade $dateFacade, TemplateFacade $templateFacade){
        $this->enrollmentRepository = $enrollmentRepository;
        $this->userFacade = $userFacade;
        $this->dateFacade = $dateFacade;
        $this->templateFacade = $templateFacade;
    }

    /** @todo Refactor email send and save enrollment */
    public function createEnrollment(int $dateId, Request $request): void
    {
        $date = $this->dateFacade->getDateById($dateId);
        $event = $date->getRelation('event');
        $user = $this->userFacade->getCurrentUser();
        $userData = $this->userFacade->getUserForEmail($user->id);
        $template = $this->templateFacade->getTemplateById($event->template_id);
        $enrollmentData = collect($request->get('enrollment'));

        $templateWithContent = str_replace('[message]', $event->template_content, $template->html);

        $finalHtml = Blade::render($templateWithContent, ['user' => $userData, 'params' => $enrollmentData->toArray()]);

        Mail::to([$user->email])
            ->send(new CustomHtmlMail($event->template_subject, $finalHtml, $userData));
    }

}
