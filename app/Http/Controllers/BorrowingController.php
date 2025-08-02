<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $borrowings = Borrowing::with(['book', 'member', 'user'])
            ->when($request->search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($request->status, function ($query, $status) {
                return $query->status($status);
            })
            ->latest()
            ->paginate(10);

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $books = Book::where('available', '>', 0)->get();
        $members = Member::where('status', 'active')->get();

        return view('admin.borrowings.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
            'notes' => 'nullable|string',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->available <= 0) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam!');
        }

        $data = $request->all();
        $data['borrow_code'] = Borrowing::generateBorrowCode();
        $data['user_id'] = auth()->id();
        $data['status'] = 'borrowed';

        Borrowing::create($data);

        // Update book availability
        $book->decrement('available');

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil dibuat!');
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['book', 'member', 'user']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function edit(Borrowing $borrowing)
    {
        $books = Book::all();
        $members = Member::where('status', 'active')->get();

        return view('admin.borrowings.edit', compact('borrowing', 'books', 'members'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
            'return_date' => 'nullable|date',
            'status' => 'required|in:pending,approved,borrowed,returned,overdue',
            'notes' => 'nullable|string',
            'fine_amount' => 'nullable|numeric|min:0',
        ]);

        $oldStatus = $borrowing->status;
        $borrowing->update($request->all());

        // Update book availability based on status change
        if ($oldStatus !== $request->status) {
            $book = $borrowing->book;

            if ($oldStatus === 'borrowed' && $request->status === 'returned') {
                $book->increment('available');
            } elseif ($oldStatus === 'returned' && $request->status === 'borrowed') {
                $book->decrement('available');
            }
        }

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return back()->with('error', 'Buku tidak dalam status dipinjam!');
        }

        $borrowing->update([
            'return_date' => Carbon::now(),
            'status' => 'returned',
            'fine_amount' => $borrowing->calculateFine(),
        ]);

        // Update book availability
        $borrowing->book->increment('available');

        return back()->with('success', 'Buku berhasil dikembalikan!');
    }

    // User functions
    public function userIndex()
    {
        $user = auth()->user();
        $borrowings = Borrowing::whereHas('member', function ($query) use ($user) {
            $query->where('email', $user->email);
        })->with(['book', 'member'])->latest()->paginate(10);

        return view('user.borrowings', compact('borrowings'));
    }

    public function requestBorrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = auth()->user();
        $book = Book::findOrFail($request->book_id);

        // Check if user has member record
        $member = Member::where('email', $user->email)->first();
        if (!$member) {
            return back()->with('error', 'Anda belum terdaftar sebagai anggota perpustakaan!');
        }

        if (!$book->isAvailable()) {
            return back()->with('error', 'Buku tidak tersedia!');
        }

        // Check if user already has pending/active borrow for this book
        $existingBorrow = Borrowing::where('book_id', $book->id)
            ->where('member_id', $member->id)
            ->whereIn('status', ['pending', 'approved', 'borrowed'])
            ->exists();

        if ($existingBorrow) {
            return back()->with('error', 'Anda sudah memiliki peminjaman aktif untuk buku ini!');
        }

        Borrowing::create([
            'borrow_code' => Borrowing::generateBorrowCode(),
            'book_id' => $book->id,
            'member_id' => $member->id,
            'user_id' => $user->id,
            'borrow_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14), // 2 weeks
            'status' => 'pending',
        ]);

        return back()->with('success', 'Permohonan peminjaman berhasil diajukan!');
    }

    public function approveBorrow(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Status peminjaman tidak valid!');
        }

        $borrowing->update(['status' => 'borrowed']);
        $borrowing->book->decrement('available');

        return back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    public function rejectBorrow(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Status peminjaman tidak valid!');
        }

        $borrowing->delete();

        return back()->with('success', 'Peminjaman berhasil ditolak!');
    }
}
