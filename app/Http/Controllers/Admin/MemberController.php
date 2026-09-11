<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        return view('admin.members.index', [
            'members' => Member::orderByDesc('created_at')->get(),
        ]);
    }

    public function show(Member $member)
    {
        return view('admin.members.show', ['member' => $member]);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')->with('status', 'Membership record removed.');
    }
}
