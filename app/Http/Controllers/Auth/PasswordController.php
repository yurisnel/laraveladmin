<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function showModalForm(Request $request): View
    {
        return view('auth.passwords.reset-modal', ['request' => $request]);
    }


    /**
     * Update the user's password.
     */
    public function update(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        if (request()->has('ajax')) {
            return response()->json(['message' => __('messages.reset_password_ok')]);
        } else {
            return back()->with('status', 'password-updated');
        }
    }
}
