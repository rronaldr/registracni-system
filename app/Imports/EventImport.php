<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EventImport implements ToCollection
{
    public ?Collection $importedData;

    public function collection(Collection $rows)
    {
        $this->importedData = new Collection();
        $eventData = $this->mapEventKeys($rows->get(1));
        $this->importedData->put('event', $eventData);

        // Imported excel format dates start
        $dates = $rows->slice(9);

        if($dates->isNotEmpty()) {
            $formattedDates = $dates->map(function (Collection $date) {
                return $this->mapDatesKeys($date);
            });

            $this->importedData->put('dates', $formattedDates->values());
        }
    }

    private function mapEventKeys(Collection $eventData): Collection
    {
        return collect([
            'name' => $eventData[0],
            'subtitle' => $eventData[1],
            'calendar_id' => $eventData[2],
            'contact_person' => $eventData[3],
            'contact_email' => $eventData[4],
            'type' => $eventData[5],
            'status' => $eventData[6],
            'global_blacklist' => $eventData[7],
            'event_blacklist' => $eventData[8],
            'user_group' => $eventData[9],
        ]);
    }

    private function mapDatesKeys(Collection $dateData): array
    {
        return [
            'location' => $dateData[0],
            'capacity' => $dateData[1],
            'date_start' => $dateData[2],
            'date_end' => $dateData[3],
            'enrollment_start' => $dateData[4],
            'enrollment_end' => $dateData[5],
            'withdraw_end' => $dateData[6],
        ];
    }
}
