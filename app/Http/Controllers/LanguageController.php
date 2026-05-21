<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    protected array $allowed = ['it', 'en', 'de', 'fr'];

    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, $this->allowed)) {
            Session::put('locale', $locale);
            app()->setLocale($locale);
        }

        return redirect()->back();
    }
}
