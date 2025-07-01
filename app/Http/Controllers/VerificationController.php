<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{
        public function show()
    {
        return view('authentication.verification-code');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'code' => ['required', 'array', 'size:6'],
            'code.*' => ['required', 'digits:1'],
        ]);

        $inputCode = implode('', $request->input('code'));


        $correctCode = Session::get('verification_code', '123456');

        if ($inputCode === $correctCode) {

            Session::put('verified', true);

            return redirect()->route('home')->with('success', 'Great! Your account verification was successful.');
        }

        return back()->withErrors(provider: ['code' => 'Oops! The code you entered is not valid. Please check and enter it again.'])->withInput();
    }

    public function resend()
    {
        $newCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        Session::put('verification_code', $newCode);

        return back()->with('success', "New code sent : $newCode");
    }
}
