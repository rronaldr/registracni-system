<?php

namespace App\Services\Admin;

use App\Models\Enrollment;
use App\Repositories\EventRepository;
use Illuminate\Support\Collection;

class TagFacade
{

    private EventRepository $eventRepository;

    public function __construct(
        EventRepository $eventRepository,
        DateFacade $dateFacade,
        BlacklistFacade $blacklistFacade
    ){
        $this->eventRepository = $eventRepository;
        $this->dateFacade = $dateFacade;
        $this->blacklistFacade = $blacklistFacade;
    }

    public function getCustomFieldsValueWithLabel(array $labels, Enrollment $enrollment): Collection
    {
        /** @todo refactor custom field label is taken from event */
        $data = collect(json_decode($enrollment->c_fields, true));
        return $data->mapWithKeys(function ($value, $key) use ($labels): array
        {
            return [$labels[$key]['label'] => $value];
        });
    }

    public function storeTag(int $eventId, array $data): void
    {
        $event = $this->eventRepository->getEventById($eventId);
        $tags = $event->getTagsCollection();
        $tags->push($data);
        $event->c_fields = $tags->toArray();
        $event->save();
    }

    public function updateTag(int $eventId, int $tagId, array $data): void
    {
        $event = $this->eventRepository->getEventById($eventId);
        $tags = $event->getTagsCollection()->filter(static fn($tag) => $tag['id'] !== $tagId);
        $tags->push($data);
        $event->c_fields = $tags->toArray();
        $event->save();
    }

    public function removeTag(int $eventId, int $tagId): void
    {
        $event = $this->eventRepository->getEventById($eventId);
        $remainingTags = $event->getTagsCollection()->filter(static fn($tag) => $tag['id'] !== $tagId);

        $event->c_fields = $remainingTags->toArray();
        $event->save();
    }

    public function getTagValidationRules(): array
    {
        return [
            'tag.label' => 'required|string',
            'tag.value' => 'required|string',
            'tag.required' => 'required|bool',
            'tag.options' => 'required_if:tag.type,radio,checkbox,select|sometimes:string'
        ];
    }
}
