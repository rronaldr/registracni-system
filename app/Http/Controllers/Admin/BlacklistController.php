<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blacklist;
use App\Services\BlacklistFacade;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlacklistController extends Controller
{
    public function index(BlacklistFacade $blacklistFacade): View
    {
        $blacklist = $blacklistFacade->getGlobalBlacklist();

        return view('admin.blacklist', [
            'blacklist' => $blacklist,
        ]);
    }

    /** @todo add validation */
    public function store(Request $request, BlacklistFacade $blacklistFacade): RedirectResponse
    {
        $blacklistData = $blacklistFacade
            ->getBlacklistJsonFromResponse($request->blacklist)
            ->toJson();

        Blacklist::create([
            'data' => $blacklistData,
        ]);


        return redirect()->route('admin.blacklist');
    }

    public function update(int $id, Request $request, BlacklistFacade $blacklistFacade)
    {
        try {
            $blacklistFacade->addUsersToBlacklist($id, $request->blacklist);

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getBlacklistUsers(int $id, BlacklistFacade $blacklistFacade): JsonResponse
    {
        $blacklist = $blacklistFacade->getBlacklistById($id);

        return response()->json(['users' => $blacklist->users()->get()]);
    }

    public function destroy(int $id, int $user, BlacklistFacade $blacklistFacade)
    {
        try {
            $blacklistFacade->removeUserFromBlacklist($id, $user);

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }

    }
}
