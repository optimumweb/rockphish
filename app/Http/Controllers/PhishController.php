<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class PhishController extends Controller
{
    public function opened(Request $request, Email $email)
    {
        $email->open();

        return response('');
    }

    public function hooked(Request $request, Email $email)
    {
        $email->hook();

        return view('phish.hooked', compact('email'));
    }
}
