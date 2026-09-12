<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\FundTransaction;
use App\Models\MediaItem;
use App\Models\NewsArticle;
use App\Support\Money;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'counts' => [
                'office_bearers' => CommitteeMember::officeBearers()->count(),
                'members'        => CommitteeMember::members()->count(),
                'news'           => NewsArticle::count(),
                'events'         => Event::count(),
                'gallery'        => MediaItem::where('collection', 'gallery')->count(),
                'hero'           => MediaItem::where('collection', 'hero')->count(),
            ],
            'fundBalance'      => Money::abbreviate(FundTransaction::totalBalance()),
            'fundBalanceExact' => Money::format(FundTransaction::totalBalance()),
            'unreadMessages'   => ContactMessage::whereNull('read_at')->count(),
            'recentNews'      => NewsArticle::newest()->take(5)->get(),
        ]);
    }
}
