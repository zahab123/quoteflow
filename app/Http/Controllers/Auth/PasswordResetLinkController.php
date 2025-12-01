<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login_by' => 'required|email|exists:users,email',
        ], [
            'login_by.required' => 'Please enter your email.',
            'login_by.email' => 'Please enter a valid email address.',
            'login_by.exists' => 'This email does not exist in our system.',
        ]);

        $status = Password::sendResetLink(
            ['email' => $request->input('login_by')]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Password reset link has been sent to your email address.');
        } else {
            
            return back()->withErrors([
                'login_by' => 'Unable to send reset link. Please try again later.'
            ]);
        }
    }
}
