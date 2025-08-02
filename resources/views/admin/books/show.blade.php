@extends('admin.layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Actions -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Buku</h2>
            <p class="text-gray-600 mt-1">Informasi lengkap tentang buku</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.books.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.books.edit', $book->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit Buku
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Book Cover -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Cover Buku</h3>
                @if($book->cover)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" 
                             class="w-full max-w-xs mx-auto rounded-lg shadow-md">
                    </div>
                @else
                    <div class="bg-gray-100 rounded-lg p-8 text-center">
                        <i class="fas fa-book text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Tidak ada cover</p>
                    </div>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status Stok:</span>
                        @if($book->stock > 0)
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                Tersedia ({{ $book->stock }})
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 text-sm rounded-full">
                                Habis
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Ditambahkan:</span>
                        <span class="text-gray-800">{{ $book->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Terakhir Update:</span>
                        <span class="text-gray-800">{{ $book->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Buku</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Judul Buku</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $book->title }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Penulis</label>
                            <p class="text-gray-800">{{ $book->author }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kategori</label>
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                {{ $book->category }}
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Jumlah Stok</label>
                            <p class="text-gray-800 font-medium">{{ $book->stock }} eksemplar</p>
                        </div>
                        
                        @if($book->isbn)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">ISBN</label>
                            <p class="text-gray-800 font-mono">{{ $book->isbn }}</p>
                        </div>
                        @endif
                        
                        @if($book->publisher)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Penerbit</label>
                            <p class="text-gray-800">{{ $book->publisher }}</p>
                        </div>
                        @endif
                        
                        @if($book->publication_year)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tahun Terbit</label>
                            <p class="text-gray-800">{{ $book->publication_year }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    @if($book->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Deskripsi</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.books.edit', $book->id) }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-edit mr-2"></i>Edit Buku
                    </a>
                    
                    <button onclick="duplicateBook()" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-copy mr-2"></i>Duplikat Buku
                    </button>
                    
                    <button onclick="confirmDelete()" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Hapus Buku
                    </button>
                    
                    <a href="{{ route('admin.books.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-list mr-2"></i>Daftar Buku
                    </a>
                </div>
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
                    Apakah Anda yakin ingin menghapus buku <strong>"{{ $book->title }}"</strong>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Hapus Buku
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    function duplicateBook() {
        // Redirect to create form with pre-filled data
        const url = new URL('{{ route("admin.books.create") }}');
        url.searchParams.append('duplicate', '{{ $book->id }}');
        window.location.href = url.toString();
    }
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection