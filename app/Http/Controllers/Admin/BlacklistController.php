<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blacklist;
use App\Services\BlacklistFacade;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        /**
         * jan.novak@vse.cz;1.5.2030 9:15;Váš důvod,
         berg@gmail.com;10.12.2030 22:50;reason,
         */

        $blacklistData = $blacklistFacade
            ->getBlacklistJsonFromResponse($request->blacklist)
            ->toJson();

        Blacklist::create([
            'data' => $blacklistData,
        ]);


        return redirect()->route('admin.blacklist');
    }

    public function update(string $blacklistId, Request $request, BlacklistFacade $blacklistFacade): RedirectResponse
    {
        /**
         * jan.jiri@vse.cz,
        test@gmail.com;10.12.2050 22:50,
         */
        $blacklist = Blacklist::query()
            ->where('id', $blacklistId)
            ->first();

        $existingBlacklist = json_decode($blacklist->data, true);
        $newData = $blacklistFacade->getBlacklistJsonFromResponse($request->blacklist)->toArray();
        $mergedBlacklist = array_merge($existingBlacklist, $newData);

        $blacklist->data = json_encode($mergedBlacklist);
        $blacklist->save();

        return redirect()->route('admin.blacklist');
    }

    public function destroy(string $blacklistId, string $email): RedirectResponse
    {
        $x =$blacklistId;

        return redirect()->route('admin.blacklist');
    }
}
