<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

class DateController extends Controller
{
    public function index(): view
    {
        return view('homepage');
    }
}
