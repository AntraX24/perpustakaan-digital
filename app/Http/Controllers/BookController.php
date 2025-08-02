<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::query()
            ->when($request->search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($request->category, function ($query, $category) {
                return $query->category($category);
            })
            ->latest()
            ->paginate(10);

        $categories = Book::distinct('category')->pluck('category');

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:1',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'publisher' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['available'] = $data['stock'];

        // Handle cover upload
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Book $book)
    {
        $book->load(['borrowings.member', 'borrowings.user']);
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:1',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'publisher' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        // Handle cover upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Update available stock based on difference
        $stockDifference = $data['stock'] - $book->stock;
        $data['available'] = $book->available + $stockDifference;

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Book $book)
    {
        // Check if book has active borrowings
        if ($book->activeBorrowings()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus buku yang sedang dipinjam!');
        }

        // Delete cover if exists
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }

    // User catalog view
    public function catalog(Request $request)
    {
        $books = Book::query()
            ->where('available', '>', 0)
            ->when($request->search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($request->category, function ($query, $category) {
                return $query->category($category);
            })
            ->latest()
            ->paginate(12);

        $categories = Book::distinct('category')->pluck('category');

        return view('user.catalog', compact('books', 'categories'));
    }
}