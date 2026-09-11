<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        return view('admin.committee.index', [
            'officeBearers' => CommitteeMember::officeBearers()->get(),
            'members'       => CommitteeMember::members()->get(),
        ]);
    }

    public function create(Request $request)
    {
        $member = new CommitteeMember([
            'group' => $request->query('group') === 'member' ? 'member' : 'office_bearer',
        ]);

        return view('admin.committee.form', ['member' => $member]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['sort'] = (CommitteeMember::where('group', $data['group'])->max('sort') ?? -1) + 1;

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storeImage($request->file('photo'), 'committee');
        }

        CommitteeMember::create($data);

        return redirect()->route('admin.committee.index')->with('status', 'Committee member added.');
    }

    public function edit(CommitteeMember $committee)
    {
        return view('admin.committee.form', ['member' => $committee]);
    }

    public function update(Request $request, CommitteeMember $committee)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $this->deleteImage($committee->photo);
            $data['photo'] = $this->storeImage($request->file('photo'), 'committee');
        }

        $committee->update($data);

        return redirect()->route('admin.committee.index')->with('status', 'Committee member updated.');
    }

    public function destroy(CommitteeMember $committee)
    {
        $this->deleteImage($committee->photo);
        $committee->delete();

        return redirect()->route('admin.committee.index')->with('status', 'Committee member removed.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->input('order', []) as $position => $id) {
            CommitteeMember::where('id', $id)->update(['sort' => $position]);
        }

        return response()->json(['ok' => true]);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'group' => ['required', 'in:office_bearer,member'],
            'role'  => ['nullable', 'string', 'max:120'],
            'name'  => ['required', 'string', 'max:160'],
            'photo' => ['nullable', 'image', 'max:6144'],
        ]);
    }
}
