<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\Admin\BlacklistFacade;
use App\Services\Admin\EventFacade;
use App\Services\Admin\TagFacade;
use App\Services\Admin\UserFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class EventController extends Controller
{
    public function index(EventFacade $eventFacade, UserFacade $userFacade): View
    {
        Artisan::call('view:clear');
        $user = $userFacade->getCurrentUser();

        if ($user->can('event-see-all')) {
            $events = $eventFacade->getEventsPaginated();
        } else {
            $collaborations = $user->collaborations()->pluck('event_id');
            $collaborationsIds = $collaborations->isNotEmpty() ? $collaborations : null;
            $events = $eventFacade->getEventsByAuthor($user->id, $collaborationsIds);
        }

        return view('admin.events', [
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        $this->authorize('event-create', Event::class);

        return view('admin.event-create');
    }

    public function store(Request $request, EventFacade $eventFacade): JsonResponse
    {
        $this->authorize('event-create', Event::class);

        try {
            $validator = Validator::make($request->all(), $eventFacade->getEventCreateValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $eventFacade->createEvent($request);

            Session::flash('message', __('app.event.saved'));

            return response()->json(null, 204);
        } catch (Throwable $e) {
            return response()->json(['error' => [$e->getMessage()]], 400);
        }
    }

    public function detail(string $id, EventFacade $eventFacade, UserFacade $userFacade): view
    {
        $event = $eventFacade->getEventById((int) $id);
        $event->load('author');

        $user = $event->last_changed_by === null
            ? null :
            $userFacade->getUserById($event->last_changed_by)->getFullname();

        return view('admin.event-detail', [
            'event' => $event,
            'last_changed' => $user ?? null,
            'can_view' => auth()->user()->can('view', $event)
        ]);
    }

    public function edit(string $id, EventFacade $eventFacade, UserFacade $userFacade): view
    {
        $event = $eventFacade->getEventById((int) $id);
        $event->load('author');

        $user = $event->last_changed_by === null
            ? null :
            $userFacade->getUserById($event->last_changed_by)->getFullname();

        if (auth()->user()->cannot('view', $event)) {
            return abort(403);
        }

        return view('admin.event-edit', [
            'event' => $event,
            'last_changed' => $user ?? null
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
        if (auth()->user()->cannot('delete', [Event::class, $id])){
            Session::flash('message', __('app.event.delete-date-error'));

            return redirect()->route('admin.events');
        }

        try {
            $eventFacade->deleteEvent($id);
        } catch (\Exception $e) {
            dump($e);
        }

        Session::flash('message', __('app.event.deleted'));

        return redirect()->route('admin.events');
    }

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

    public function changeEventStatus(int $id, Request $request, EventFacade $eventFacade): JsonResponse
    {
        $validator = Validator::make($request->get('data'), [
            'status' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $eventFacade->changeEventStatus($id, $request->get('data')['status']);

        return response()->json(null, 204);
    }

}
