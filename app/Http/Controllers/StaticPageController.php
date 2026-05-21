<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class StaticPageController extends Controller
{
    public function services(): View  { return view('pages.services'); }
    public function airportInfo(): View { return view('pages.airport-info'); }
    public function contact(): View   { return view('pages.contact'); }
    public function privacy(): View   { return view('pages.privacy'); }
    public function cookies(): View   { return view('pages.cookies'); }
    public function terms(): View     { return view('pages.terms'); }

    public function contactSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string',
            'message' => 'required|string|min:10|max:2000',
            'privacy' => 'required|accepted',
        ]);

        // TODO: inviare email → Mail::to('info@...')->send(new ContactMail($request->all()));

        return redirect()->route('contact')
            ->with('success', 'Messaggio inviato con successo! Ti risponderemo entro 24 ore.');
    }

    public function sitemap(): Response
    {
        $xml = view('sitemap')->render();
        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
