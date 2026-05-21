<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        return view('partners.index');
    }
}
