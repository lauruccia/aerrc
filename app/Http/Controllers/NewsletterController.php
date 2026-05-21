<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email', 'max:255']]);

        NewsletterSubscriber::firstOrCreate(
            ['email' => $request->email],
            ['subscribed_at' => now(), 'locale' => app()->getLocale()]
        );

        return back()->with('newsletter_success', true);
    }
}
