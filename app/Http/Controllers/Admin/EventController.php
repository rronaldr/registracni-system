<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\BlacklistFacade;
use App\Services\Admin\EventFacade;
use App\Services\Admin\TagFacade;
use App\Services\Admin\UserFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class EventController extends Controller
{
    public function index(EventFacade $eventFacade, UserFacade $userFacade): View
    {
        $user = $userFacade->getCurrentUser();

        /** @todo refactor once event collaboration feature is done */
        if ($user->can('event-see-all')) {
            $events = $eventFacade->getEventsPaginated();
        } else {
            $events = $eventFacade->getEventsByAuthor($user->id);
        }

        return view('admin.events', [
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        return view('admin.event-create');
    }

    public function store(Request $request, EventFacade $eventFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), $eventFacade->getEventCreateValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $eventFacade->createEvent($request);

            Session::flash('message', __('app.event.saved'));

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function edit(string $id, EventFacade $eventFacade): View
    {
        $event = $eventFacade->getEventById((int) $id);
        $event->load('author');

        return view('admin.event-edit', [
            'event' => $event,
        ]);
    }

    public function update(int $id, Request $request, EventFacade $eventFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->get('data'), $eventFacade->getEventUpdateValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $eventFacade->updateEvent($id, $request->get('data'));

            Session::flash('message', __('app.event.updated'));

            return response()->json(null, 204);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }

    public function destroy(int $id, EventFacade $eventFacade): RedirectResponse
    {
        try {
            $eventFacade->deleteEvent($id);
        } catch (\Exception $e) {
            dump($e);
        }

        Session::flash('message', __('app.event.deleted'));

        return redirect()->route('admin.events');
    }

    /* @todo REDO this with VUE and json response */
    public function duplicate(int $id, EventFacade $eventFacade): View
    {
        $event = $eventFacade->duplicateEvent($id);

        return view('admin.event-create', [
            'event' => $event
        ]);
    }

    public function getEventEnrollmentsUsers(string $id, EventFacade $eventFacade): JsonResponse
    {
        try {
            $users = $eventFacade->getEventEnrollmentsAndUsers((int) $id);
            return response()->json($users);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => trans('An error occurred.')]);
        }
    }

    public function exportEventUsers(int $id, EventFacade $eventFacade): BinaryFileResponse
    {
        /** @todo rewrite into ExportFacade and Excel */
        $data = $eventFacade->getEventEnrollmentsAndUsers($id);

        $filename = public_path('seznam_ucastniku.csv');

        $csvHandle = fopen($filename, 'w');
        $data->each(function ($row) use ($csvHandle) {
            $row['c_fields'] = json_encode($row['c_fields']);
            fputcsv($csvHandle, $row);
        });

        fclose($csvHandle);

        return response()->download($filename, 'seznam_ucastniku.csv', ['Content-Type' => 'text/csv']);
    }

    public function exportEventUsersEmails(int $id, EventFacade $eventFacade): BinaryFileResponse
    {
        /** @todo rewrite into ExportFacade and Excel */
        $data = $eventFacade->getEventUsersEmail($id);

        $filename = public_path('seznam_ucastniku_email.csv');

        $csvHandle = fopen($filename, 'w');
        $data->each(function ($row) use ($csvHandle) {
            fputcsv($csvHandle, $row);
        });

        fclose($csvHandle);

        return response()->download($filename, 'seznam_ucastniku_email.csv', ['Content-Type' => 'text/csv']);
    }

    public function getEventTags(int $id, EventFacade $eventFacade): JsonResponse
    {
        $event = $eventFacade->getEventById($id);
        $tags = collect($event->c_fields)->sortBy('id')->values()->toArray();

        return response()->json([
            'tags' => $tags
        ]);
    }

    public function storeEventTag(int $id, Request $request, TagFacade $tagFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), $tagFacade->getTagValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $tagFacade->storeTag($id, $request->get('tag'));

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updateEventTag(int $id, int $tag, Request $request, TagFacade $tagFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), $tagFacade->getTagValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $tagFacade->updateTag($id, $tag, $request->get('tag'));

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function destroyEventTag(int $id, int $tag, TagFacade $tagFacade): Response
    {
        $tagFacade->removeTag($id, $tag);

        return response()->noContent();
    }

    public function createAndGetBlacklistForEvent(
        int $id,
        EventFacade $eventFacade,
        BlacklistFacade $blacklistFacade
    ): JsonResponse {
        try {
            $event = $eventFacade->getEventById($id);

            if ($event->blacklist_id !== null) {
                return response()->json(['blacklist' => $event->blacklist_id], 200);
            }

            $blacklist = $blacklistFacade->createBlacklist();
            $event->blacklist_id = $blacklist->id;
            $event->save();

            return response()->json(['blacklist' => $event->blacklist_id], 200);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }

    public function addEventCollaborator(int $id, Request $request, EventFacade $eventFacade, UserFacade $userFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->get('data'), [
                'collaborator' => 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $collaborator = $userFacade->getOrCreateUserByEmail($request->get('data')['collaborator']);
            $currentUser = $userFacade->getCurrentUser();
            $eventFacade->addEventCollaborator($id, $collaborator->id, $currentUser->id);

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}
