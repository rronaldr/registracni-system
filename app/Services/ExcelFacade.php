<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\EventRepository;
use Maatwebsite\Excel\Facades\Excel;

class ExcelFacade
{

    private EventFacade $eventFacade;
    private DateFacade  $dateFacade;
    public function __construct(
        EventRepository $eventRepository,
        DateFacade $dateFacade
    ){
        $this->$eventRepository = $eventRepository;
        $this->dateFacade = $dateFacade;
    }

    public function getImportPreview(string $file)
    {
//        Excel::import();
    }
}
