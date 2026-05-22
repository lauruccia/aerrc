<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Models\Destination;
use App\Models\TourismArticle;

class StaticPageController extends Controller
{
    public function services(): View    { return view('pages.services'); }
    public function airportInfo(): View { return view('pages.airport-info'); }
    public function contact(): View     { return view('pages.contact'); }
    public function privacy(): View     { return view('pages.privacy'); }
    public function cookies(): View     { return view('pages.cookies'); }
    public function terms(): View       { return view('pages.terms'); }
    public function mediaKit(): View    { return view('pages.media-kit'); }
    public function becomePartner(): View { return view('pages.become-partner'); }

    public function contactSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string',
            'message' => 'required|string|min:10|max:2000',
            'privacy' => 'required|accepted',
        ], [
            'name.required'    => 'Il nome è obbligatorio.',
            'email.required'   => "L'indirizzo email è obbligatorio.",
            'email.email'      => "Inserisci un indirizzo email valido.",
            'subject.required' => "L'oggetto è obbligatorio.",
            'message.required' => 'Il messaggio non può essere vuoto.',
            'message.min'      => 'Il messaggio è troppo breve (minimo 10 caratteri).',
            'privacy.accepted' => 'Devi accettare la Privacy Policy per procedere.',
        ]);

        $data = $request->only(['name', 'email', 'subject', 'message']);

        try {
            // Email di notifica all'amministratore
            Mail::send([], [], function ($mail) use ($data) {
                $mail->to(config('mail.admin_address', env('MAIL_FROM_ADDRESS', 'info@aeroportoreggiocalabria.it')))
                     ->replyTo($data['email'], $data['name'])
                     ->subject('[ARC Portale] ' . $data['subject'])
                     ->html(
                        '<div style="font-family:Georgia,serif;max-width:600px;margin:0 auto;padding:20px;">' .
                        '<div style="background:#0D2347;padding:20px 28px;border-radius:8px 8px 0 0;">' .
                        '<h2 style="color:#C9A84C;margin:0;font-size:18px;">Aeroporto Reggio Calabria</h2>' .
                        '<p style="color:#fff;margin:4px 0 0;font-size:12px;opacity:.7;">Nuovo messaggio dal form contatti</p>' .
                        '</div>' .
                        '<div style="background:#fff;padding:28px;border:1px solid #e5e5e0;border-top:none;border-radius:0 0 8px 8px;">' .
                        '<table style="width:100%;border-collapse:collapse;">' .
                        '<tr><td style="padding:6px 0;color:#666;width:90px;">Nome</td><td style="padding:6px 0;font-weight:bold;">' . e($data['name']) . '</td></tr>' .
                        '<tr><td style="padding:6px 0;color:#666;">Email</td><td style="padding:6px 0;"><a href="mailto:' . e($data['email']) . '" style="color:#0D2347;">' . e($data['email']) . '</a></td></tr>' .
                        '<tr><td style="padding:6px 0;color:#666;">Oggetto</td><td style="padding:6px 0;">' . e($data['subject']) . '</td></tr>' .
                        '</table>' .
                        '<hr style="border:none;border-top:1px solid #eee;margin:16px 0;">' .
                        '<p style="white-space:pre-line;line-height:1.6;">' . e($data['message']) . '</p>' .
                        '</div></div>'
                     );
            });

            // Email di conferma automatica al mittente
            Mail::send([], [], function ($mail) use ($data) {
                $mail->to($data['email'], $data['name'])
                     ->from(env('MAIL_FROM_ADDRESS', 'info@aeroportoreggiocalabria.it'), 'Aeroporto Reggio Calabria')
                     ->subject('Messaggio ricevuto — Aeroporto Reggio Calabria')
                     ->html(
                        '<div style="font-family:Georgia,serif;max-width:600px;margin:0 auto;padding:20px;">' .
                        '<div style="background:#0D2347;padding:20px 28px;border-radius:8px 8px 0 0;">' .
                        '<h2 style="color:#C9A84C;margin:0;font-size:18px;">Aeroporto Reggio Calabria</h2>' .
                        '</div>' .
                        '<div style="background:#fff;padding:28px;border:1px solid #e5e5e0;border-top:none;border-radius:0 0 8px 8px;">' .
                        '<p>Gentile <strong>' . e($data['name']) . '</strong>,</p>' .
                        '<p>Grazie per averci contattato. Abbiamo ricevuto il tuo messaggio relativo a <em>"' . e($data['subject']) . '"</em>.</p>' .
                        '<p>Ti risponderemo entro <strong>24 ore lavorative</strong>.</p>' .
                        '<hr style="border:none;border-top:1px solid #eee;margin:20px 0;">' .
                        '<p style="font-size:12px;color:#999;">Aeroporto Reggio Calabria · aeroportoreggiocalabria.it<br>' .
                        'Per urgenze: info@aeroportoreggiocalabria.it</p>' .
                        '</div></div>'
                     );
            });

        } catch (\Exception $e) {
            // Log dell'errore senza esporre dettagli all'utente
            \Log::error('ContactForm mail error: ' . $e->getMessage());
        }

        return redirect()->route('contact')
            ->with('success', 'Messaggio inviato con successo! Ti risponderemo entro 24 ore.');
    }

    public function becomePartnerSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'org_name'    => 'required|string|max:200',
            'contact_name'=> 'required|string|max:100',
            'email'       => 'required|email|max:150',
            'phone'       => 'nullable|string|max:30',
            'org_type'    => 'required|string',
            'interest'    => 'required|string',
            'message'     => 'nullable|string|max:2000',
            'privacy'     => 'required|accepted',
        ]);

        $data = $request->only(['org_name', 'contact_name', 'email', 'phone', 'org_type', 'interest', 'message']);

        try {
            Mail::send([], [], function ($mail) use ($data) {
                $mail->to(config('mail.admin_address', env('MAIL_FROM_ADDRESS', 'info@aeroportoreggiocalabria.it')))
                     ->replyTo($data['email'], $data['contact_name'])
                     ->subject('[PARTNERSHIP] Richiesta da ' . $data['org_name'])
                     ->html(
                        '<div style="font-family:Georgia,serif;max-width:600px;margin:0 auto;padding:20px;">' .
                        '<div style="background:#0D2347;padding:20px 28px;border-radius:8px 8px 0 0;">' .
                        '<h2 style="color:#C9A84C;margin:0;">Nuova Richiesta di Partnership</h2>' .
                        '</div>' .
                        '<div style="background:#fff;padding:28px;border:1px solid #e5e5e0;border-top:none;border-radius:0 0 8px 8px;">' .
                        '<table style="width:100%;border-collapse:collapse;">' .
                        '<tr><td style="padding:6px 0;color:#666;width:140px;">Organizzazione</td><td style="padding:6px 0;font-weight:bold;">' . e($data['org_name']) . '</td></tr>' .
                        '<tr><td style="padding:6px 0;color:#666;">Referente</td><td style="padding:6px 0;">' . e($data['contact_name']) . '</td></tr>' .
                        '<tr><td style="padding:6px 0;color:#666;">Email</td><td style="padding:6px 0;">' . e($data['email']) . '</td></tr>' .
                        '<tr><td style="padding:6px 0;color:#666;">Telefono</td><td style="padding:6px 0;">' . e($data['phone'] ?? '—') . '</td></tr>' .
                        '<tr><td style="padding:6px 0;color:#666;">Tipo ente</td><td style="padding:6px 0;">' . e($data['org_type']) . '</td></tr>' .
                        '<tr><td style="padding:6px 0;color:#666;">Interesse</td><td style="padding:6px 0;">' . e($data['interest']) . '</td></tr>' .
                        '</table>' .
                        '<hr style="border:none;border-top:1px solid #eee;margin:16px 0;">' .
                        '<p style="white-space:pre-line;">' . e($data['message'] ?? '') . '</p>' .
                        '</div></div>'
                     );
            });
        } catch (\Exception $e) {
            \Log::error('PartnerForm mail error: ' . $e->getMessage());
        }

        return redirect()->route('become-partner')
            ->with('success', 'Richiesta inviata! Ti contatteremo entro 48 ore per discutere la collaborazione.');
    }

    public function sitemap(): Response
    {
        $destinations    = Destination::select('slug', 'updated_at')->get();
        $tourismArticles = TourismArticle::select('slug', 'updated_at')->get();

        $xml = view('sitemap', compact('destinations', 'tourismArticles'))->render();
        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
