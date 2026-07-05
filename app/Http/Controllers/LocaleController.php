<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        session(['locale' => config('app.locale', 'ja')]);

        return redirect()->back();
    }
}
