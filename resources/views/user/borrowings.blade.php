@extends('user.layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Peminjaman</h1>
    <p class="text-gray-600">Kelola dan pantau status peminjaman buku Anda</p>
</div>

<!-- Status Summary -->
@php
    $user = auth()->user();
    $member = \App\Models\Member::where('email', $user->email)->first();
    if ($member) {
        $statusCounts = [
            'pending' => $member->borrowings()->where('status', 'pending')->count(),
            'borrowed' => $member->borrowings()->where('status', 'borrowed')->count(),
            'returned' => $member->borrowings()->where('status', 'returned')->count(),
            'overdue' => $member->borrowings()->where('status', 'overdue')->count(),
        ];
    } else {
        $statusCounts = ['pending' => 0, 'borrowed' => 0, 'returned' => 0, 'overdue' => 0];
    }
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Pending</p>
                <p class="text-xl font-bold text-yellow-600">{{ $statusCounts['pending'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-book-open text-green-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Dipinjam</p>
                <p class="text-xl font-bold text-green-600">{{ $statusCounts['borrowed'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-check-circle text-blue-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Dikembalikan</p>
                <p class="text-xl font-bold text-blue-600">{{ $statusCounts['returned'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Terlambat</p>
                <p class="text-xl font-bold text-red-600">{{ $statusCounts['overdue'] }}</p>
            </div>
        </div>
    </div>
</div>

@if(!$member)
    <!-- Member Registration Notice -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-yellow-500 text-2xl mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold text-yellow-800">Belum Terdaftar sebagai Anggota</h3>
                <p class="text-yellow-700 mt-1">
                    Anda belum terdaftar sebagai anggota perpustakaan. Silakan hubungi admin untuk mendaftarkan akun Anda sebagai anggota.
                </p>
            </div>
        </div>
    </div>
@endif

<!-- Borrowings List -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($borrowings->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($borrowings as $borrowing)
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex items-start space-x-4">
                        <!-- Book Cover -->
                        <img src="{{ $borrowing->book->cover_url }}" alt="{{ $borrowing->book->title }}" 
                             class="w-16 h-20 object-cover rounded-lg shadow-sm flex-shrink-0">
                        
                        <!-- Borrowing Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $borrowing->book->title }}</h3>
                                    <p class="text-gray-600 mb-2">{{ $borrowing->book->author }}</p>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-3">
                                        <span>
                                            <i class="fas fa-barcode mr-1"></i>
                                            {{ $borrowing->borrow_code }}
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $borrowing->borrow_date->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div class="mb-3">
                                        @if($borrowing->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Menunggu Persetujuan
                                            </span>
                                        @elseif($borrowing->status === 'approved')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                                <i class="fas fa-check mr-1"></i>
                                                Disetujui
                                            </span>
                                        @elseif($borrowing->status === 'borrowed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                                <i class="fas fa-book-open mr-1"></i>
                                                Sedang Dipinjam
                                            </span>
                                        @elseif($borrowing->status === 'returned')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Sudah Dikembalikan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Terlambat
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Dates & Fine Info -->
                                <div class="text-right mt-4 md:mt-0 md:ml-6">
                                    <div class="space-y-1 text-sm">
                                        <div>
                                            <span class="text-gray-500">Jatuh Tempo:</span>
                                            <span class="font-medium {{ $borrowing->due_date->isPast() && $borrowing->status === 'borrowed' ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $borrowing->due_date->format('d/m/Y') }}
                                            </span>
                                        </div>
                                        
                                        @if($borrowing->return_date)
                                            <div>
                                                <span class="text-gray-500">Dikembalikan:</span>
                                                <span class="font-medium text-gray-900">{{ $borrowing->return_date->format('d/m/Y') }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($borrowing->fine_amount > 0)
                                            <div>
                                                <span class="text-gray-500">Denda:</span>
                                                <span class="font-medium text-red-600">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Duration Info -->
                                    <div class="mt-2 text-xs text-gray-400">
                                        @if($borrowing->status === 'borrowed')
                                            @if($borrowing->due_date->isFuture())
                                                <span class="text-green-600">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Sisa {{ $borrowing->due_date->diffInDays() }} hari
                                                </span>
                                            @else
                                                <span class="text-red-600">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Terlambat {{ now()->diffInDays($borrowing->due_date) }} hari
                                                </span>
                                            @endif
                                        @elseif($borrowing->status === 'returned')
                                            <span class="text-gray-500">
                                                Dipinjam {{ $borrowing->borrow_date->diffInDays($borrowing->return_date) }} hari
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if($borrowing->notes)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-sticky-note mr-1"></i>
                                        <strong>Catatan:</strong> {{ $borrowing->notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($borrowings->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $borrowings->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <i class="fas fa-book text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-medium text-gray-500 mb-2">Belum ada riwayat peminjaman</h3>
            <p class="text-gray-400 mb-6">Mulai jelajahi katalog buku dan lakukan peminjaman pertama Anda!</p>
            <a href="{{ route('user.catalog') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-search mr-2"></i>Jelajahi Katalog Buku
            </a>
        </div>
    @endif
</div>

<!-- Information Panel -->
<div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-blue-800 mb-3">
        <i class="fas fa-info-circle mr-2"></i>Informasi Peminjaman
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
        <div>
            <h4 class="font-medium mb-2">Status Peminjaman:</h4>
            <ul class="space-y-1">
                <li><span class="inline-block w-3 h-3 bg-yellow-400 rounded-full mr-2"></span><strong>Pending:</strong> Menunggu persetujuan admin</li>
                <li><span class="inline-block w-3 h-3 bg-green-400 rounded-full mr-2"></span><strong>Dipinjam:</strong> Buku sedang dipinjam</li>
                <li><span class="inline-block w-3 h-3 bg-gray-400 rounded-full mr-2"></span><strong>Dikembalikan:</strong> Buku sudah dikembalikan</li>
                <li><span class="inline-block w-3 h-3 bg-red-400 rounded-full mr-2"></span><strong>Terlambat:</strong> Melewati batas waktu pengembalian</li>
            </ul>
        </div>
        <div>
            <h4 class="font-medium mb-2">Ketentuan Peminjaman:</h4>
            <ul class="space-y-1">
                <li>• Periode peminjaman maksimal 14 hari</li>
                <li>• Denda keterlambatan Rp 1.000/hari</li>
                <li>• Maksimal 3 buku per anggota</li>
                <li>• Perpanjangan dapat dilakukan 1x</li>
            </ul>
        </div>
    </div>
</div>
@endsection