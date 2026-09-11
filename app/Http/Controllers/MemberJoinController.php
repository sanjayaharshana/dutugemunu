<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MemberJoinController extends Controller
{
    public function create()
    {
        if (Auth::guard('member')->check()) {
            return redirect()->route('member.dashboard');
        }

        return view('pages.join', ['member' => new Member()]);
    }

    public function store(Request $request)
    {
        // Normalise the NIC (uppercase the V/X suffix, trim) so lookups/logins are consistent.
        $request->merge(['nic' => strtoupper(trim((string) $request->input('nic')))]);

        $data = $request->validate([
            'full_name'               => ['required', 'string', 'max:160'],
            'permanent_address'       => ['required', 'string', 'max:500'],
            'phone'                   => ['required', 'string', 'max:40'],
            'nic'                     => [
                'required', 'string', 'max:20',
                'regex:/^(\d{9}[VX]|\d{12})$/',
                Rule::unique('members', 'nic'),
            ],
            'workplace_address_phone' => ['nullable', 'string', 'max:500'],
            'occupation'              => ['nullable', 'string', 'max:160'],
            'admission_number'        => ['required', 'string', 'max:60'],
            'year_left'               => ['required', 'digits:4', 'integer', 'between:1919,' . date('Y')],
            'password'                => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nic.regex' => 'Enter a valid NIC number (9 digits + V/X, or 12 digits).',
            'year_left.between' => 'Enter a year between 1919 and ' . date('Y') . '.',
        ]);

        $member = Member::create([
            'full_name'               => $data['full_name'],
            'permanent_address'       => $data['permanent_address'],
            'phone'                   => $data['phone'],
            'nic'                     => $data['nic'],
            'workplace_address_phone' => $data['workplace_address_phone'] ?? null,
            'occupation'              => $data['occupation'] ?? null,
            'admission_number'        => $data['admission_number'],
            'year_left'               => $data['year_left'],
            'password'                => $data['password'],
        ]);

        Auth::guard('member')->login($member);
        $request->session()->regenerate();

        return redirect()->route('member.dashboard')->with('status', 'Welcome! Your membership account has been created.');
    }
}
