<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{

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
