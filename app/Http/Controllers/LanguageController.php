<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch the application language locale.
     */
    public function switchLang($locale)
    {
        if (in_array($locale, ['en', 'id'])) {
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }
}
