<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\CustomHtmlMail;
use App\Mail\DefaultMail;
use App\Models\Date;
use App\Models\Enrollment;
use App\Models\Event;
use App\Models\User;
use App\Repositories\DateRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\UserRepository;
use App\Services\Admin\TemplateFacade;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;

class EmailFacade
{
    private TemplateFacade $templateFacade;
    private EnrollmentRepository $enrollmentRepository;
    private UserRepository $userRepository;
    private DateRepository $dateRepository;

    public function __construct(
        TemplateFacade $templateFacade,
        EnrollmentRepository $enrollmentRepository,
        UserRepository $userRepository,
        DateRepository $dateRepository
    ) {
        $this->templateFacade = $templateFacade;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->userRepository = $userRepository;
        $this->dateRepository = $dateRepository;
    }

    public function sendUserEnrolledEmail(int $id): void
    {
        $enrollment = $this->enrollmentRepository->getByIdWithRelations($id);
        $event = $enrollment->date->event;
        $participant = $enrollment->user;
        $date = $enrollment->date;

        $defaultTagData = $this->buildEnrollmentEmailDefaultData($participant, $date, $event, $enrollment);

        if ($event->template_id !== 0 && !empty($event->template_content)) {
            $template = $this->templateFacade->getTemplateById($event->template_id);
            $subject = __('app.notifications.enrollment_title', [], $participant->locale);

            $eventHtml = $this->buildHtmlWithData($event->template_content, $defaultTagData, $enrollment->c_fields);
            $html = str_replace('[message]', $eventHtml, $template->html);

            Mail::to([$participant->email])
                ->send(new CustomHtmlMail($subject, $html));
        } elseif (empty($event->template_content)) {
            $dateStart = Carbon::parse($date->date_start)->format('j.n.Y H:i');

            $subject = __('app.notifications.enrollment_title', [], $participant->locale);
            $content = __('app.notifications.enrollment_text', ['event' => $event->name, 'date' => $dateStart], $participant->locale);

            if (!empty($enrollment->c_fields)) {
                $content = sprintf("%s %s", $content,
                    __('app.notifications.enrollment_tags', ['tags' => $enrollment->tagsToStringWithLabel()], $participant->locale)
                );
            }

            Mail::to($participant->email)
                ->send(new DefaultMail($content, $subject));
        } else {
            $subject = __('app.notifications.enrollment_title', [], $participant->locale);
            $html = $this->buildHtmlWithData($event->template_content, $defaultTagData, $enrollment->c_fields);

            Mail::to($participant->email)
                ->send(new CustomHtmlMail($subject, $html));
        }
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

    public function sendCapacityReachedEmail(Date $date): void
    {
        $event = $date->event;
        $author = $event->author;
        $dateStart = Carbon::parse($date->date_start)->format('j.n.Y H:i');
        $link = route('admin.events.edit',['id' => $event->id]);

        $subject = __('app.notifications.capacity_full_title', [], $author->locale);
        $content = __('app.notifications.capacity_full', ['date' => $dateStart, 'event' => $event->name, 'link' => $link], $author->locale);

        Mail::to($author->email)
            ->send(new DefaultMail($content, $subject));
    }

    public function sendFreeSpotNotificationToSubstitutes(Date $date, Collection $emailsWithLocale): void
    {
        $eventName = $date->event->name;
        $dateStart = Carbon::parse($date->date_start)->format('j.n.Y H:i');

        $emailsWithLocale->each(function (User $userData) use ($date, $eventName, $dateStart) {
            $link = route('date.enroll.email',['id' => $date->id, 'email' => $userData->email]);

            $subject = __('app.notifications.free_spot_title', [], $userData->locale);
            $content = __('app.notifications.free_spot', ['date' => $dateStart, 'event' => $eventName, 'link' => $link], $userData->locale);

            Mail::to($userData->email)
                ->send(new DefaultMail($content, $subject));
        });
    }

    public function sendSubstituteEnrolled(Date $date, User $user) {
        $event = $date->event;
        $dateStart = Carbon::parse($date->date_start)->format('j.n.Y H:i');

        $subject = __('app.notifications.substitute_signed_title', [], $user->locale);
        $content = __('app.notifications.substitute_signed', ['date' => $dateStart, 'event' => $event->name], $user->locale);

        Mail::to($user->email)
            ->send(new DefaultMail($content, $subject));
    }

    private function buildHtmlWithData(string $html, array $data, array $enrollmentFields): string
    {
        $tags = collect($enrollmentFields)->mapWithKeys(function ($tag) {
            return [$tag['name'] => $tag['value']];
        })->toArray();

        $html = $this->replaceTagsWithVariables($html);

        return Blade::render($html, ['data' => $data, 'tags' => $tags]);
    }

    private function buildEnrollmentEmailDefaultData(User $user, Date $date, Event $event, Enrollment $enrollment): array
    {
        $dataArray = collect();

        $dataArray->put('user', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'xname' => $user->xname,
            'email' => $user->email,
            ]);
        $dataArray->put('event', [
            'name' => $event->name
        ]);
        $dataArray->put('date', [
            'date_start' => Carbon::parse($date->date_start)->format('j.n.Y H:i'),
            'date_end' => Carbon::parse($date->date_end)->format('j.n.Y H:i'),
        ]);
        $dataArray->put('enrollment', [
            'created_at' => Carbon::parse($enrollment->created_at)->format('j.n.Y H:i'),
        ]);

        return Arr::dot($dataArray->toArray());
    }

    private function replaceTagsWithVariables(string $content): string
    {
        $regex = '/\[(\w+)\]/';
        $strings = ['[user.first_name]','[user.last_name]','[user.xname]','[user.email]','[event.name]','[date.date_start]','[date.date_end]','[enrollment.created_at]'];
        $variables = ['{{ $data["user.first_name"] }}', '{{ $data["user.last_name"] }}', '{{ $data["user.xname"] }}', '{{ $data["user.email"] }}', '{{ $data["event.name"] }}', '{{ $data["date.date_start"] }}', '{{ $data["date.date_end"] }}', '{{ $data["enrollment.created_at"] }}'];

        $contentWithSystemTags = str_replace($strings, $variables, $content);
        $contentWithAllTags = preg_replace($regex, '{{ $tags["$1"] }}', $contentWithSystemTags);

        return $contentWithAllTags;
    }
}
