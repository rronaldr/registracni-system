<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\CustomHtmlMail;
use App\Mail\DefaultMail;
use App\Repositories\EnrollmentRepository;
use App\Repositories\EventRepository;
use App\Services\Admin\BlacklistFacade;
use App\Services\Admin\DateFacade;
use App\Services\Admin\TemplateFacade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailFacade
{
    private TemplateFacade $templateFacade;
    private EnrollmentRepository $enrollmentRepository;

    public function __construct(
        TemplateFacade $templateFacade,
        EnrollmentRepository $enrollmentRepository
    ) {
        $this->templateFacade = $templateFacade;
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function sendUserEnrolledEmail(): void
    {
//        $userData = $this->userFacade->getUserForEmail($user->id);
//        $templateWithContent = str_replace('[message]', $event->template_content, $template->html);
//        $finalHtml = Blade::render($templateWithContent, ['user' => $userData, 'params' => $enrollmentData->toArray()]);
//        Mail::to([$user->email])
//            ->send(new CustomHtmlMail($event->template_subject, $finalHtml, $userData));
    }

    public function sendSignOffEmail(array $enrollmentIds, string $blockReason): void
    {
        collect($enrollmentIds)->each(function (int $id) use ($blockReason) {
            $enrollment = $this->enrollmentRepository->getById($id);
            $user = $enrollment->user;
            $date = $enrollment->date;

            $dateStart = Carbon::parse($date->date_start)->format('j.n.Y H:i') ;

            $subject = __('app.notifications.sign_off_title');
            $content = __('app.notifications.sign_off', ['date' => $dateStart, 'reason' => $blockReason], 'cs');

            Mail::to($user->email)
                ->send(new DefaultMail($content, $subject));
        });
    }
}
