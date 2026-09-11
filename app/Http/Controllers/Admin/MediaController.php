<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        return view('admin.media.index', [
            'gallery' => MediaItem::collection('gallery')->get(),
            'hero'    => MediaItem::collection('hero')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'collection' => ['required', 'in:gallery,hero'],
            'caption'    => ['nullable', 'string', 'max:120'],
            'size_class' => ['nullable', 'in:,wide,tall'],
            'image'      => ['required', 'image', 'max:8192'],
        ]);

        MediaItem::create([
            'collection' => $data['collection'],
            'path'       => $this->storeImage($request->file('image'), $data['collection']),
            'caption'    => $data['caption'] ?? null,
            'size_class' => $data['size_class'] ?: null,
            'sort'       => (MediaItem::where('collection', $data['collection'])->max('sort') ?? -1) + 1,
        ]);

        return back()->with('status', 'Image uploaded.');
    }

    public function update(Request $request, MediaItem $medium)
    {
        $medium->update($request->validate([
            'caption'    => ['nullable', 'string', 'max:120'],
            'size_class' => ['nullable', 'in:,wide,tall'],
            'sort'       => ['nullable', 'integer', 'min:0'],
        ]));

        return back()->with('status', 'Image updated.');
    }

    public function destroy(MediaItem $medium)
    {
        $this->deleteImage($medium->path);
        $medium->delete();

        return back()->with('status', 'Image removed.');
    }
}
