<?php

namespace App\Http\Controllers\Nami\Translator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\TranslateWithGemini;

class TranslatorController extends Controller
{
    use TranslateWithGemini;

    public function index(Request $request)
    {
        $text = $request->input('texts');
        $targetLang = $request->input('target_lang', 'en');
        $sourceLang = $request->input('source_lang', 'ar');

        $result = $this->translateWithGemini($text, $targetLang, $sourceLang);

        return response()->json([
            'original' => $text,
            'translated' => $result,
            'target_language' => $targetLang
        ]);
    }
}
