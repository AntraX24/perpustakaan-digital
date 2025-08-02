@extends('user.layouts.app')

@section('content')
<!-- Welcome Header -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang Kembali!</h1>
                <p class="text-blue-100 text-lg">{{ Auth::user()->name }}</p>
                <p class="text-blue-200 text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-graduate text-3xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Active Borrowings -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Sedang Dipinjam</p>
                <p class="text-3xl font-bold text-blue-600 mb-2">{{ $activeBorrowings }}</p>
                <div class="flex items-center text-xs text-blue-600">
                    <i class="fas fa-clock mr-1"></i>
                    <span>Aktif saat ini</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center shadow-inner">
                <i class="fas fa-book-open text-blue-600 text-xl"></i>
            </div>
        </div>
        @if($activeBorrowings > 0)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('user.borrowings') }}" class="inline-flex items-center text-blue-600 text-sm hover:text-blue-800 font-medium transition-colors">
                    Lihat detail peminjaman
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @else
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Total Borrowings -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Total Peminjaman</p>
                <p class="text-3xl font-bold text-green-600 mb-2">{{ $totalBorrowings }}</p>
                <div class="flex items-center text-xs text-green-600">
                    <i class="fas fa-chart-line mr-1"></i>
                    <span>Riwayat lengkap</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center shadow-inner">
                <i class="fas fa-history text-green-600 text-xl"></i>
            </div>
        </div>
        @if($totalBorrowings > 0)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('user.borrowings') }}" class="inline-flex items-center text-green-600 text-sm hover:text-green-800 font-medium transition-colors">
                    Lihat riwayat lengkap
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @else
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Available Books -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Buku Tersedia</p>
                <p class="text-3xl font-bold text-purple-600 mb-2">{{ $availableBooks }}</p>
                <div class="flex items-center text-xs text-purple-600">
                    <i class="fas fa-star mr-1"></i>
                    <span>Siap dipinjam</span>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center shadow-inner">
                <i class="fas fa-book text-purple-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('user.catalog') }}" class="inline-flex items-center text-purple-600 text-sm hover:text-purple-800 font-medium transition-colors">
                Jelajahi katalog
                <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8">
    <div class="p-6 border-b border-gray-200 bg-gray-50 rounded-t-xl">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-bolt text-blue-600"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Quick Actions</h2>
                <p class="text-sm text-gray-600">Akses cepat ke fitur utama</p>
            </div>
        </div>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('user.catalog') }}" class="group bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-search text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg mb-1">Cari Buku</h3>
                        <p class="text-sm opacity-90">Jelajahi koleksi buku perpustakaan</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('user.borrowings') }}" class="group bg-gradient-to-r from-green-600 to-green-700 text-white p-6 rounded-xl hover:from-green-700 hover:to-green-800 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-list text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg mb-1">Riwayat Peminjaman</h3>
                        <p class="text-sm opacity-90">Lihat status dan riwayat peminjaman</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-8">
    <div class="p-6 border-b border-gray-200 bg-gray-50 rounded-t-xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-history text-green-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Aktivitas Terbaru</h2>
                    <p class="text-sm text-gray-600">5 transaksi terakhir</p>
                </div>
            </div>
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-bar text-green-600"></i>
            </div>
        </div>
    </div>
    <div class="p-6">
        @php
            $user = auth()->user();
            $member = \App\Models\Member::where('email', $user->email)->first();
            $recentBorrowings = $member ? $member->borrowings()->with('book')->latest()->take(5)->get() : collect();
        @endphp
        
        @if($recentBorrowings->count() > 0)
            <div class="space-y-4">
                @foreach($recentBorrowings as $borrowing)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 border border-gray-100 rounded-xl hover:bg-blue-50 hover:border-blue-200 transition-all duration-200">
                        <div class="flex-shrink-0">
                            <img src="{{ $borrowing->book->cover_url }}" alt="{{ $borrowing->book->title }}" 
                                 class="w-12 h-16 object-cover rounded-lg shadow-md">
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-gray-800 truncate">{{ $borrowing->book->title }}</h4>
                            <p class="text-sm text-gray-600 truncate">{{ $borrowing->book->author }}</p>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $borrowing->borrow_date->format('d/m/Y') }}
                                </span>
                                <span class="px-3 py-1 text-xs font-medium rounded-full border
                                    @if($borrowing->status === 'pending') bg-yellow-50 text-yellow-800 border-yellow-200
                                    @elseif($borrowing->status === 'borrowed') bg-green-50 text-green-800 border-green-200
                                    @elseif($borrowing->status === 'returned') bg-gray-50 text-gray-800 border-gray-200
                                    @else bg-red-50 text-red-800 border-red-200
                                    @endif">
                                    {{ ucfirst($borrowing->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ route('user.borrowings') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                    Lihat semua riwayat peminjaman
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-500 mb-2">Belum ada aktivitas</h3>
                <p class="text-gray-400 mb-6">Mulai jelajahi katalog buku dan lakukan peminjaman pertama Anda!</p>
                <a href="{{ route('user.catalog') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-search mr-2"></i>
                    Jelajahi Katalog
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Popular Books -->
<div class="bg-white rounded-xl shadow-lg border border-gray-100">
    <div class="p-6 border-b border-gray-200 bg-gray-50 rounded-t-xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-fire text-purple-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Buku Populer</h2>
                    <p class="text-sm text-gray-600">Koleksi favorit pengguna</p>
                </div>
            </div>
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-trophy text-purple-600"></i>
            </div>
        </div>
    </div>
    <div class="p-6">
        @php
            // Get popular books based on borrowing frequency
            $popularBooks = \App\Models\Book::withCount('borrowings')
                ->where('available', '>', 0)
                ->orderBy('borrowings_count', 'desc')
                ->take(6)
                ->get();
        @endphp
        
        @if($popularBooks->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularBooks as $book)
                    <div class="group border border-gray-200 rounded-xl p-4 hover:shadow-lg hover:border-blue-200 transition-all duration-300 bg-gradient-to-br from-white to-gray-50">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" 
                                     class="w-14 h-18 object-cover rounded-lg shadow-md group-hover:shadow-lg transition-shadow">
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-800 truncate group-hover:text-blue-600 transition-colors">{{ $book->title }}</h4>
                                <p class="text-sm text-gray-600 truncate">{{ $book->author }}</p>
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                                        <span class="text-xs text-gray-500">
                                            {{ $book->borrowings_count }} peminjaman
                                        </span>
                                    </div>
                                    <form method="POST" action="{{ route('user.borrow.request') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit" 
                                                class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition-colors text-xs font-medium transform hover:scale-105"
                                                onclick="return confirm('Pinjam buku {{ $book->title }}?')">
                                            <i class="fas fa-plus mr-1"></i>
                                            Pinjam
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8 text-center">
                <a href="{{ route('user.catalog') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors bg-blue-50 px-6 py-3 rounded-lg hover:bg-blue-100">
                    <i class="fas fa-book-open mr-2"></i>
                    Lihat semua buku
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-500 mb-2">Belum ada buku tersedia</h3>
                <p class="text-gray-400">Buku populer akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>
@endsection