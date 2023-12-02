<?php

namespace App\Exports;

use App\Services\Admin\DateFacade;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DateUsersExport implements FromCollection
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
        return $this->dateFacade->getDateUsersForExport($this->dateId);
    }
}
