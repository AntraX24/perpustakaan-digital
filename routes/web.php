<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalBooks = \App\Models\Book::count();
        $totalMembers = \App\Models\Member::count();
        $activeBorrowings = \App\Models\Borrowing::whereIn('status', ['borrowed', 'overdue'])->count();
        $pendingBorrowings = \App\Models\Borrowing::where('status', 'pending')->count();
        
        return view('admin.dashboard', compact('totalBooks', 'totalMembers', 'activeBorrowings', 'pendingBorrowings'));
    })->name('dashboard');
    
    // Books management
    Route::resource('books', BookController::class);
    
    // Members management
    Route::resource('members', MemberController::class);
    
    // Borrowings management
    Route::resource('borrowings', BorrowingController::class);
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');
    Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approveBorrow'])->name('borrowings.approve');
    Route::post('/borrowings/{borrowing}/reject', [BorrowingController::class, 'rejectBorrow'])->name('borrowings.reject');
});

// User routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $member = \App\Models\Member::where('email', $user->email)->first();
        $activeBorrowings = $member ? $member->activeBorrowings()->count() : 0;
        $totalBorrowings = $member ? $member->borrowings()->count() : 0;
        $availableBooks = \App\Models\Book::where('available', '>', 0)->count();
        
        return view('user.dashboard', compact('activeBorrowings', 'totalBorrowings', 'availableBooks'));
    })->name('dashboard');
    
    Route::get('/catalog', [BookController::class, 'catalog'])->name('catalog');
    Route::post('/borrow-request', [BorrowingController::class, 'requestBorrow'])->name('borrow.request');
    Route::get('/my-borrowings', [BorrowingController::class, 'userIndex'])->name('borrowings');
});

// Middleware untuk role checking
Route::middleware(['auth'])->group(function () {
    // Redirect based on role
    Route::get('/redirect-dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('redirect.dashboard');
});

require __DIR__.'/auth.php';