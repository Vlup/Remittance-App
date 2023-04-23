<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function notice()
    {
        return "Mohon untuk melakukan verifikasi email terlebih dahulu";
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->back()->with('success', 'Email has been verified successfully!');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return redirect()->back()->with('success', 'Verification has been sent!');
    }
}
