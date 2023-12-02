<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exports\DateUsersEmailExport;
use App\Exports\DateUsersExport;
use App\Exports\EventExport;
use App\Exports\UsersEmailExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\EventImport;
use App\Services\Admin\DateFacade;
use App\Services\Admin\EventFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelController extends Controller
{

    public function exportUsers(int $id, EventFacade $eventFacade)
    {
        return Excel::download(new UsersExport($id, $eventFacade), 'seznam_ucastniku.xls');
    }

    public function exportUsersEmail(int $id, EventFacade $eventFacade)
    {
        return Excel::download(new UsersEmailExport($id, $eventFacade), 'seznam_ucastniku_email.xls');
    }

    public function exportDateUsers(int $id, DateFacade $dateFacade)
    {
        return Excel::download(new DateUsersExport($id, $dateFacade), 'seznam_ucastniku.xls');
    }

    public function exportDateUsersEmail(int $id, DateFacade $dateFacade)
    {
        return Excel::download(new DateUsersEmailExport($id, $dateFacade), 'seznam_ucastniku_email.xls');
    }
    
    public function exportEvent(int $id, EventFacade $eventFacade)
    {
        return Excel::download(new EventExport($id, $eventFacade), 'export_udalosti.xls', );
    }

    public function importEvent(Request $request)
    {
        try {
            $request->validate([
                'event_import' => 'required|mimes:xls',
            ]);

            $fileToImport = $request->file('event_import');
            $import = new EventImport;
            Excel::import($import, $fileToImport);

            $event = $import->importedData->get('event');
            $dates = $import->importedData->get('dates');

            Session::flash('message', __('app.event.imported'));

            return view('admin.event-create', [
                'event' => $event,
                'dates' => $dates
            ]);
        } catch (ValidationException $e) {
            Session::flash('message', $e->getMessage());

            return redirect()->back();
        }
    }

    public function downloadImportTemplate(): StreamedResponse
    {
        return Storage::disk('public')->download('dist/import_template.xls');
    }
}
