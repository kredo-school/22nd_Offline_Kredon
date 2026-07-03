<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        $available = config('app.available_locales', ['ja', 'en']);

        if (! in_array($locale, $available, true)) {
            abort(404);
        }

        session(['locale' => $locale]);

        return redirect()->back();
    }
}
