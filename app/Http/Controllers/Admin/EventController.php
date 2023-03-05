<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EventController extends Controller
{
    public function show(): View
    {
        return view('home');
    }
}
