<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function getLocale(): JsonResponse
    {
        return response()->json(['locale' => app()->getLocale()], 200);
    }

    public function setLocale(string $locale): RedirectResponse
    {
        if (auth()->check()) {
            auth()->user()->locale = $locale;
            auth()->user()->save();
        }
        session()->put('locale', $locale);
        app()->setLocale($locale);

        return redirect()->back();
    }
}
