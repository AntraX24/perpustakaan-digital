@extends('admin.layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Peminjaman</h2>
        <a href="{{ route('admin.borrowings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Buat Peminjaman
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        @php
            $totalBorrowings = \App\Models\Borrowing::count();
            $pendingCount = \App\Models\Borrowing::where('status', 'pending')->count();
            $borrowedCount = \App\Models\Borrowing::where('status', 'borrowed')->count();
            $overdueCount = \App\Models\Borrowing::where('status', 'overdue')->count();
            $returnedCount = \App\Models\Borrowing::where('status', 'returned')->count();
        @endphp
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-800">{{ $totalBorrowings }}</p>
                <p class="text-sm text-gray-600">Total</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</p>
                <p class="text-sm text-gray-600">Pending</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <p class="text-2xl font-bold text-green-600">{{ $borrowedCount }}</p>
                <p class="text-sm text-gray-600">Dipinjam</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <p class="text-2xl font-bold text-red-600">{{ $overdueCount }}</p>
                <p class="text-sm text-gray-600">Terlambat</p>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $returnedCount }}</p>
                <p class="text-sm text-gray-600">Dikembalikan</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" action="{{ route('admin.borrowings.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode, nama anggota, atau judul buku..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="min-w-40">
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            
            @if(request('search') || request('status'))
                <a href="{{ route('admin.borrowings.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Borrowings Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($borrowings as $borrowing)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrow_code }}</div>
                            <div class="text-xs text-gray-500">{{ $borrowing->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="{{ $borrowing->book->cover_url }}" alt="{{ $borrowing->book->title }}" class="w-10 h-12 object-cover rounded mr-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 max-w-48 truncate">{{ $borrowing->book->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $borrowing->book->author }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->member->name }}</div>
                                <div class="text-sm text-gray-500">{{ $borrowing->member->member_number }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div>Pinjam: {{ $borrowing->borrow_date->format('d/m/Y') }}</div>
                            <div class="text-gray-500">Tempo: {{ $borrowing->due_date->format('d/m/Y') }}</div>
                            @if($borrowing->return_date)
                                <div class="text-blue-600">Kembali: {{ $borrowing->return_date->format('d/m/Y') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($borrowing->status === 'pending')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                            @elseif($borrowing->status === 'approved')
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Disetujui</span>
                            @elseif($borrowing->status === 'borrowed')
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Dipinjam</span>
                            @elseif($borrowing->status === 'returned')
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Dikembalikan</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Terlambat</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($borrowing->fine_amount > 0)
                                <span class="text-red-600 font-medium">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($borrowing->status === 'pending')
                                    <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Setujui"
                                                onclick="return confirm('Setujui peminjaman ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Tolak"
                                                onclick="return confirm('Tolak peminjaman ini?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                @if($borrowing->status === 'borrowed')
                                    <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-purple-600 hover:text-purple-900" title="Kembalikan"
                                                onclick="return confirm('Tandai buku sudah dikembalikan?')">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($borrowings->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $borrowings->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection