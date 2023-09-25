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

    public function parseTagsToJson(array $tags): string
    {
        return json_encode($tags);
    }

    public function parseJsonTagsToArray(string $jsonTags): array
    {
        return json_decode($jsonTags, true);
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
}
