<?php

namespace App\Exports;

use App\Services\Admin\DateFacade;
use App\Services\Admin\EventFacade;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DateUsersEmailExport implements FromCollection
{
    private int $dateId;
    private DateFacade $dateFacade;

    public function __construct(int $dateId, DateFacade $dateFacade)
    {
        $this->dateId = $dateId;
        $this->dateFacade = $dateFacade;
    }

    public function collection(): Collection
    {
        return $this->dateFacade->getDateUsersForExport($this->dateId)->transform(function (array $user) {
            return [
                'id' => $user['id'],
                'email' => $user['email'],
            ];
        });
    }
}
