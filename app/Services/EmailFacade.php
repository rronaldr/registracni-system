<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\CustomHtmlMail;
use App\Mail\DefaultMail;
use App\Models\Date;
use App\Repositories\EnrollmentRepository;
use App\Repositories\EventRepository;
use App\Services\Admin\BlacklistFacade;
use App\Services\Admin\DateFacade;
use App\Services\Admin\TemplateFacade;
use Carbon\Carbon;
use Illuminate\Support\Collection;
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

            $dateStart = Carbon::parse($date->date_start)->format('j.n.Y H:i');

            $subject = __('app.notifications.sign_off_title', [], $user->locale);
            $content = __('app.notifications.sign_off', ['date' => $dateStart, 'reason' => $blockReason], $user->locale);

            Mail::to($user->email)
                ->send(new DefaultMail($content, $subject));
        });
    }

    public function sendEnrollmentEndEmail(Collection $dates): void
    {
        $dates->each(function (Date $date): void {
            $event = $date->event;
            $author = $event->author;

            $dateStart = Carbon::parse($date->date_start)->format('j.n.Y H:i');
            $dateEnd = Carbon::parse($date->date_end)->format('j.n.Y H:i');
            $dateDuration = sprintf('%s - %s',$dateStart, $dateEnd);

            $subject = __('app.notifications.enrollment_end_title', [], $author->locale);
            $content = __('app.notifications.enrollment_end', ['date' => $dateDuration, 'event' => $event->name], $author->locale);

            Mail::to($author->email)
                ->send(new DefaultMail($content, $subject));
        });
    }
}
