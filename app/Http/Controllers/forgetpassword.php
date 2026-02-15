<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;

class forgetpassword extends Controller
{
    public function emailForm()
    {
        return view('forgetpassword');
    }

  public function generateOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return back()->with('error', 'Email not found');
    }

    $otp = rand(1000, 9999);

    // Delete old OTPs
    Otp::where('email', $request->email)->delete();

    // Create new OTP
    Otp::create([
        'email' => $request->email,
        'otp' => $otp,
        'is_used' => false
    ]);

    // Show OTP verify page with generated OTP (for demo purpose)
    return view('otpverfiy', [
        'otp' => $otp,
        'email' => $request->email
    ]);
}


  public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required'
    ], [
        'otp.required' => 'OTP field is required.'
    ]);

    $otpData = Otp::where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('is_used', false)
        ->first();

    if (!$otpData) {
        // Invalid OTP: same view me message show karo
        $otpRecord = Otp::where('email', $request->email)
                        ->where('is_used', false)
                        ->first();

        return view('otpverfiy', [
            'otp' => $otpRecord ? $otpRecord->otp : null, // demo OTP
            'email' => $request->email,
            'error' => 'Invalid OTP'
        ]);
    }

    // OTP valid
    $otpData->update(['is_used' => true]);

   return redirect()->route('password.reset.form', [
    'email' => $request->email
]);

}


    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/'
                ],
            ],
            [
                'password.required'  => 'Password field is required.',
                'password.confirmed' => 'Password and Confirm Password must match.',
                'password.min'       => 'Password must be at least 8 characters.',
                'password.regex'     => 'Password must contain uppercase, lowercase, number, and special character.',
            ]
        );

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('account.login')
            ->with('success', 'Password updated successfully');
    }

    public function showResetForm(Request $request)
{
    return view('resetpassword', [
        'email' => $request->email
    ]);
}
}
