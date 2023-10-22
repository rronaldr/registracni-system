<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exports\UsersEmailExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Services\Admin\EventFacade;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{

    public function exportUsers(int $id, EventFacade $eventFacade)
    {
        return Excel::download(new UsersExport($id, $eventFacade), 'seznam_ucastniku.xlsx');
    }

    public function exportUsersEmail(int $id, EventFacade $eventFacade)
    {
        return Excel::download(new UsersEmailExport($id, $eventFacade), 'seznam_ucastniku_email.xlsx');
    }
    
    public function exportEvents()
    {
    }

    public function importEvents()
    {

    }
}
