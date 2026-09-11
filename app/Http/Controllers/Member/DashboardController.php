<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\FundTransaction;
use App\Models\Member;
use App\Support\Money;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $events = collect(config('association.events'))
            ->map(function (array $e) {
                $e['date'] = Carbon::parse($e['date']);

                return $e;
            })
            ->sortBy(fn (array $e) => $e['date'])
            ->values();

        $news = collect(config('association.news'))
            ->map(function (array $n) {
                $n['date'] = Carbon::parse($n['date']);

                return $n;
            })
            ->sortByDesc(fn (array $n) => $n['date'])
            ->values();

        $transactions = FundTransaction::query()
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->take(25)
            ->get();

        $latestDate = FundTransaction::latestDate();

        return view('member.dashboard', [
            'member'       => $request->user('member'),
            'events'       => $events,
            'news'         => $news,
            'funds'        => [
                'total_formatted' => Money::format(FundTransaction::totalBalance()),
                'as_of'           => $latestDate ? Carbon::parse($latestDate)->format('j F Y') : null,
                'breakdown'       => FundTransaction::breakdownByCategory(),
            ],
            'transactions' => $transactions,
            'donations'    => config('association.donations', []),
            'fundGrowth'   => FundTransaction::growthSeries(),
            'memberGrowth' => Member::growthSeries(),
        ]);
    }

    public function editProfile(Request $request)
    {
        return view('member.profile', ['member' => $request->user('member')]);
    }

    public function updateProfile(Request $request)
    {
        $member = $request->user('member');

        $data = $request->validate([
            'full_name'               => ['required', 'string', 'max:160'],
            'permanent_address'       => ['required', 'string', 'max:500'],
            'phone'                   => ['required', 'string', 'max:40'],
            'workplace_address_phone' => ['nullable', 'string', 'max:500'],
            'occupation'              => ['nullable', 'string', 'max:160'],
        ]);

        $member->update($data);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
            $member->update(['password' => $request->input('password')]);
        }

        return back()->with('status', 'Your details have been updated.');
    }
}
