@extends('admin.layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Member Header -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Detail Anggota</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.members.edit', $member) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.members.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Member Info -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Anggota</label>
                        <p class="mt-1 text-lg font-mono text-blue-600">{{ $member->member_number }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <p class="mt-1 text-lg text-gray-900">{{ $member->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-gray-900">{{ $member->email }}</p>
                    </div>
                    
                    @if($member->phone)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <p class="mt-1 text-gray-900">{{ $member->phone }}</p>
                    </div>
                    @endif
                </div>
                
                <!-- Status & Dates -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            @if($member->status === 'active')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                        <p class="mt-1 text-gray-900">{{ $member->join_date->format('d F Y') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Member Since</label>
                        <p class="mt-1 text-gray-600">{{ $member->join_date->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            
            @if($member->address)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <p class="mt-1 text-gray-900">{{ $member->address }}</p>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Total Peminjaman</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $member->borrowings()->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Sedang Dipinjam</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $member->activeBorrowings()->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Sudah Dikembalikan</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $member->borrowings()->where('status', 'returned')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation text-red-600"></i>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Terlambat</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $member->borrowings()->where('status', 'overdue')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Borrowing History -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-800">Riwayat Peminjaman</h4>
        </div>
        
        <div class="overflow-x-auto">
            @if($member->borrowings->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($member->borrowings->sortByDesc('created_at') as $borrowing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrow_code }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img src="{{ $borrowing->book->cover_url }}" alt="{{ $borrowing->book->title }}" class="w-10 h-12 object-cover rounded mr-3">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $borrowing->book->author }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrowing->borrow_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrowing->due_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrowing->return_date ? $borrowing->return_date->format('d/m/Y') : '-' }}
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($borrowing->fine_amount > 0)
                                        <span class="text-red-600 font-medium">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-book text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">Belum ada riwayat peminjaman</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection