@extends('admin.layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Actions -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Peminjaman</h2>
            <p class="text-gray-600 mt-1">Kode: {{ $borrowing->borrow_code }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.borrowings.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            @if($borrowing->status !== 'returned')
            <button onclick="markAsReturned()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-check mr-2"></i>Tandai Dikembalikan
            </button>
            @endif
            <a href="{{ route('admin.borrowings.edit', $borrowing->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit Peminjaman
            </a>
        </div>
    </div>

    <!-- Status Alert -->
    @if($borrowing->status === 'overdue')
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
            <div>
                <h3 class="text-red-800 font-medium">Peminjaman Terlambat!</h3>
                <p class="text-red-700 text-sm mt-1">
                    Buku ini sudah melewati tanggal jatuh tempo sejak {{ \Carbon\Carbon::parse($borrowing->due_date)->diffForHumans() }}.
                </p>
            </div>
        </div>
    </div>
    @elseif($borrowing->status === 'returned')
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
            <div>
                <h3 class="text-green-800 font-medium">Buku Sudah Dikembalikan</h3>
                <p class="text-green-700 text-sm mt-1">
                    Dikembalikan pada {{ \Carbon\Carbon::parse($borrowing->return_date)->format('d/m/Y') }}.
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Book Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Buku</h3>
                
                @if($borrowing->book->cover)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $borrowing->book->cover) }}" alt="{{ $borrowing->book->title }}" 
                             class="w-32 h-40 mx-auto rounded-lg shadow-md object-cover">
                    </div>
                @else
                    <div class="bg-gray-100 rounded-lg p-6 text-center mb-4">
                        <i class="fas fa-book text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500 text-sm">Tidak ada cover</p>
                    </div>
                @endif
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Judul</label>
                        <p class="text-gray-800 font-medium">{{ $borrowing->book->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Penulis</label>
                        <p class="text-gray-800">{{ $borrowing->book->author }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Kategori</label>
                        <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            {{ $borrowing->book->category }}
                        </span>
                    </div>
                    @if($borrowing->book->isbn)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">ISBN</label>
                        <p class="text-gray-800 font-mono text-sm">{{ $borrowing->book->isbn }}</p>
                    </div>
                    @endif
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.books.show', $borrowing->book->id) }}" 
                       class="text-blue-600 hover:text-blue-700 text-sm">
                        <i class="fas fa-external-link-alt mr-1"></i>Lihat Detail Buku
                    </a>
                </div>
            </div>
        </div>

        <!-- Member & Borrowing Information -->
        <div class="lg:col-span-2">
            <!-- Member Info -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Anggota</h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                            <p class="text-gray-800 font-medium">{{ $borrowing->member->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Anggota</label>
                            <p class="text-gray-800 font-mono">{{ $borrowing->member->member_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-gray-800">{{ $borrowing->member->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">No. Telepon</label>
                            <p class="text-gray-800">{{ $borrowing->member->phone ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.members.show', $borrowing->member->id) }}" 
                           class="text-blue-600 hover:text-blue-700 text-sm">
                            <i class="fas fa-external-link-alt mr-1"></i>Lihat Profil Anggota
                        </a>
                    </div>
                </div>
            </div>

            <!-- Borrowing Details -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Detail Peminjaman</h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kode Peminjaman</label>
                            <p class="text-gray-800 font-mono text-lg">{{ $borrowing->borrow_code }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            @if($borrowing->status === 'borrowed')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
                                    <i class="fas fa-clock mr-1"></i>Dipinjam
                                </span>
                            @elseif($borrowing->status === 'returned')
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                    <i class="fas fa-check mr-1"></i>Dikembalikan
                                </span>
                            @elseif($borrowing->status === 'overdue')
                                <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Terlambat
                                </span>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pinjam</label>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}</p>
                            <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->diffForHumans() }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Jatuh Tempo</label>
                            <p class="text-gray-800 {{ $borrowing->status === 'overdue' ? 'text-red-600 font-medium' : '' }}">
                                {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                            </p>
                            <p class="text-gray-500 text-sm">
                                @if($borrowing->status === 'overdue')
                                    <span class="text-red-600">Terlambat {{ \Carbon\Carbon::parse($borrowing->due_date)->diffForHumans() }}</span>
                                @else
                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                        
                        @if($borrowing->return_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Kembali</label>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d/m/Y') }}</p>
                            <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($borrowing->return_date)->diffForHumans() }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Durasi Peminjaman</label>
                            <p class="text-gray-800">
                                {{ \Carbon\Carbon::parse($borrowing->borrow_date)->diffInDays(\Carbon\Carbon::parse($borrowing->return_date)) }} hari
                            </p>
                            @if(\Carbon\Carbon::parse($borrowing->return_date)->gt(\Carbon\Carbon::parse($borrowing->due_date)))
                                <p class="text-red-600 text-sm">
                                    (Terlambat {{ \Carbon\Carbon::parse($borrowing->due_date)->diffInDays(\Carbon\Carbon::parse($borrowing->return_date)) }} hari)
                                </p>
                            @endif
                        </div>
                        @else
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Durasi Pinjam</label>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->diffInDays(now()) }} hari</p>
                            @if(now()->gt(\Carbon\Carbon::parse($borrowing->due_date)))
                                <p class="text-red-600 text-sm">
                                    (Terlambat {{ \Carbon\Carbon::parse($borrowing->due_date)->diffInDays(now()) }} hari)
                                </p>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    @if($borrowing->notes)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Catatan</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $borrowing->notes }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Timeline -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 mb-3">Timeline</label>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm text-gray-800">Peminjaman dibuat</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($borrowing->created_at)->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm text-gray-800">Buku dipinjam</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            
                            @if($borrowing->return_date)
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm text-gray-800">Buku dikembalikan</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @else
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-gray-300 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm text-gray-500">Belum dikembalikan</p>
                                    <p class="text-xs text-gray-400">Jatuh tempo: {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.borrowings.edit', $borrowing->id) }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-edit mr-2"></i>Edit Peminjaman
                    </a>
                    
                    @if($borrowing->status !== 'returned')
                    <button onclick="markAsReturned()" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-check mr-2"></i>Tandai Dikembalikan
                    </button>
                    @endif
                    
                    <button onclick="printBorrowing()" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-print mr-2"></i>Cetak
                    </button>
                    
                    <button onclick="confirmDelete()" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                    
                    <a href="{{ route('admin.borrowings.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-list mr-2"></i>Daftar Peminjaman
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Return Confirmation Modal -->
<div id="returnModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Pengembalian</h3>
                </div>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-700">
                    Tandai buku <strong>"{{ $borrowing->book->title }}"</strong> sebagai dikembalikan?
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeReturnModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <form action="{{ route('admin.borrowings.return', $borrowing->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Ya, Kembalikan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                </div>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-700">
                    Apakah Anda yakin ingin menghapus peminjaman <strong>"{{ $borrowing->borrow_code }}"</strong>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <form action="{{ route('admin.borrowings.destroy', $borrowing->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Hapus Peminjaman
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function markAsReturned() {
        document.getElementById('returnModal').classList.remove('hidden');
    }
    
    function closeReturnModal() {
        document.getElementById('returnModal').classList.add('hidden');
    }
    
    function confirmDelete() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    function printBorrowing() {
        // Open print view in new window
        const url = '{{ route("admin.borrowings.print", $borrowing->id) }}';
        window.open(url, '_blank', 'width=800,height=600');
    }
    
    // Close modals when clicking outside
    document.getElementById('returnModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReturnModal();
        }
    });
    
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeReturnModal();
            closeDeleteModal();
        }
    });
</script>
@endsection