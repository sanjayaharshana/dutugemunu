<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Models\Event;
use App\Models\MediaItem;
use App\Models\NewsArticle;

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
            'recentNews' => NewsArticle::newest()->take(5)->get(),
        ]);
    }
}
