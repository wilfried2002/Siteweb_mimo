<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $lang)
    {
        if (in_array($lang, ['fr', 'en'])) {
            session(['locale' => $lang]);
        }

        return redirect()->back()->withHeaders([
            'Cache-Control' => 'no-store',
        ]);
    }
}
