@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Header Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard</h1>
                    <p class="text-blue-100">Kelola perpustakaan Anda dengan mudah dan efisien</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Books -->
        <div
            class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Buku</p>
                    <p class="text-3xl font-bold text-gray-800 mb-2">{{ $totalBooks }}</p>
                    <div class="flex items-center text-xs text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>Koleksi tersedia</span>
                    </div>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>
        </div>

        <!-- Total Members -->
        <div
            class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Anggota</p>
                    <p class="text-3xl font-bold text-gray-800 mb-2">{{ $totalMembers }}</p>
                    <div class="flex items-center text-xs text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>Anggota aktif</span>
                    </div>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 72%"></div>
                </div>
            </div>
        </div>

        <!-- Active Borrowings -->
        <div
            class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-gray-800 mb-2">{{ $activeBorrowings }}</p>
                    <div class="flex items-center text-xs text-yellow-600">
                        <i class="fas fa-clock mr-1"></i>
                        <span>Dalam proses</span>
                    </div>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-exchange-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-600 h-2 rounded-full" style="width: 45%"></div>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div
            class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Permintaan Pending</p>
                    <p class="text-3xl font-bold text-gray-800 mb-2">{{ $pendingBorrowings }}</p>
                    <div class="flex items-center text-xs text-red-600">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <span>Perlu perhatian</span>
                    </div>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-clock text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: 25%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Borrowings -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-200 bg-gray-50 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-history text-blue-600 mr-2"></i>
                            Peminjaman Terbaru
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">5 transaksi terakhir</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-blue-600"></i>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @php
                    $recentBorrowings = \App\Models\Borrowing::with(['book', 'member'])
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @if ($recentBorrowings->count() > 0)
                    <div class="space-y-4">
                        @foreach ($recentBorrowings as $borrowing)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-book text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $borrowing->book->title }}</p>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-user text-gray-400 mr-1"></i>
                                            {{ $borrowing->member->name }}
                                        </p>
                                    </div>
                                </div>
                                <span
                                    class="px-3 py-1 text-xs font-medium rounded-full 
                                @if ($borrowing->status === 'borrowed') bg-green-100 text-green-800 border border-green-200
                                @elseif($borrowing->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                @elseif($borrowing->status === 'returned') bg-blue-100 text-blue-800 border border-blue-200
                                @else bg-red-100 text-red-800 border border-red-200 @endif">
                                    {{ ucfirst($borrowing->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada peminjaman</p>
                        <p class="text-sm text-gray-400 mt-1">Data peminjaman akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-200 bg-gray-50 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-bolt text-purple-600 mr-2"></i>
                            Quick Actions
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Akses cepat ke fitur utama</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-rocket text-purple-600"></i>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="{{ route('admin.books.create') }}"
                        class="group block w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-3 px-4 rounded-lg hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Tambah Buku Baru</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.members.create') }}"
                        class="group block w-full bg-gradient-to-r from-green-600 to-green-700 text-white text-center py-3 px-4 rounded-lg hover:from-green-700 hover:to-green-800 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Tambah Anggota Baru</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.borrowings.create') }}"
                        class="group block w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white text-center py-3 px-4 rounded-lg hover:from-purple-700 hover:to-purple-800 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-handshake mr-2 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Buat Peminjaman</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.borrowings.index', ['status' => 'pending']) }}"
                        class="group block w-full bg-gradient-to-r from-orange-600 to-orange-700 text-white text-center py-3 px-4 rounded-lg hover:from-orange-700 hover:to-orange-800 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-clock mr-2 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Lihat Permintaan Pending</span>
                            @if ($pendingBorrowings > 0)
                                <span
                                    class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full ml-2">{{ $pendingBorrowings }}</span>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Statistics Bar -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-calendar-check text-blue-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Hari Ini</h4>
                    <p class="text-sm text-gray-600">{{ date('d F Y') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-chart-line text-green-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Status Sistem</h4>
                    <p class="text-sm text-green-600 flex items-center justify-center">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        Aktif & Berjalan Normal
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-purple-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Update Terakhir</h4>
                    <p class="text-sm text-gray-600">{{ date('H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>
@endsection
