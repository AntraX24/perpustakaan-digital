@extends('admin.layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Edit Buku: {{ $book->title }}</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.books.update', $book->id) }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Buku *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Author -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Penulis *</label>
                    <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('author') border-red-500 @enderror">
                    @error('author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- ISBN -->
                <div>
                    <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('isbn') border-red-500 @enderror">
                    @error('isbn')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <input type="text" id="category" name="category" value="{{ old('category', $book->category) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror"
                           placeholder="Contoh: Fiksi, Non-Fiksi, Sejarah, dll">
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Publisher -->
                <div>
                    <label for="publisher" class="block text-sm font-medium text-gray-700 mb-2">Penerbit</label>
                    <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('publisher') border-red-500 @enderror">
                    @error('publisher')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Publication Year -->
                <div>
                    <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-2">Tahun Terbit</label>
                    <input type="number" id="publication_year" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}"
                           min="1000" max="{{ date('Y') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('publication_year') border-red-500 @enderror">
                    @error('publication_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok *</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $book->stock) }}" required min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stock') border-red-500 @enderror">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                          placeholder="Deskripsi singkat tentang buku...">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Current Cover Display -->
            @if($book->cover)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cover Saat Ini</label>
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Current Cover" 
                         class="w-32 h-40 object-cover rounded border shadow-sm" id="current-cover">
                </div>
            </div>
            @endif
            
            <!-- Cover Upload -->
            <div>
                <label for="cover" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $book->cover ? 'Ganti Cover Buku' : 'Cover Buku' }}
                </label>
                <input type="file" id="cover" name="cover" accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cover') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">
                    Format: JPG, JPEG, PNG, GIF. Maksimal 2MB. 
                    {{ $book->cover ? 'Kosongkan jika tidak ingin mengubah cover.' : '' }}
                </p>
                @error('cover')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <a href="{{ route('admin.books.show', $book->id) }}" class="px-4 py-2 border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Update Buku
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview cover image
    document.getElementById('cover').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview if doesn't exist
                let preview = document.getElementById('cover-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'cover-preview';
                    preview.className = 'mt-2 w-32 h-40 object-cover rounded border';
                    document.getElementById('cover').parentNode.appendChild(preview);
                }
                preview.src = e.target.result;
                
                // Hide current cover when new one is selected
                const currentCover = document.getElementById('current-cover');
                if (currentCover) {
                    currentCover.style.opacity = '0.5';
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection