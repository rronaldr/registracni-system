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
    ) {
        $this->eventRepository = $eventRepository;
        $this->dateFacade = $dateFacade;
        $this->blacklistFacade = $blacklistFacade;
    }

    public function getTagsWithLabelAndValue(Enrollment $enrollment): Collection
    {
        $tags = collect($enrollment->c_fields);
        return $tags->mapWithKeys(function ($tag): array {
            return [$tag['label'] => $tag['value']];
        });
    }

    public function storeTag(int $eventId, array $data): void
    {
        $event = $this->eventRepository->getEventById($eventId);
        $tags = $event->getTagsCollection();
        $tags->push($data);
        $event->c_fields = $tags->values()->toArray();
        $event->last_changed_by = auth()->user()->id;
        $event->save();
    }

    public function updateTag(int $eventId, int $tagId, array $data): void
    {
        $event = $this->eventRepository->getEventById($eventId);
        $tags = $event->getTagsCollection()->filter(static fn($tag) => $tag['id'] !== $tagId);
        $tags->push($data);
        $event->c_fields = $tags->values()->toArray();
        $event->last_chagned_by = auth()->user()->id;
        $event->save();
    }

    public function removeTag(int $eventId, int $tagId): void
    {
        $event = $this->eventRepository->getEventById($eventId);
        $remainingTags = $event->getTagsCollection()->filter(static fn($tag) => $tag['id'] !== $tagId);
        $event->c_fields = $remainingTags->values()->toArray();
        $event->last_changed_by = auth()->user()->id;
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
