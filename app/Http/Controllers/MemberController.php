<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::query()
            ->when($request->search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $data['member_number'] = Member::generateMemberNumber();

        Member::create($data);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(Member $member)
    {
        $member->load(['borrowings.book']);
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $member->update($request->all());

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil diupdate!');
    }

    public function destroy(Member $member)
    {
        // Check if member has active borrowings
        if ($member->activeBorrowings()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus anggota yang memiliki peminjaman aktif!');
        }

        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus!');
    }
}
