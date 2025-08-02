@extends('user.layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Katalog Buku</h1>
    <p class="text-gray-600">Temukan dan pinjam buku favorit Anda</p>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <form method="GET" action="{{ route('user.catalog') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari judul buku, penulis, atau ISBN..." 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="md:w-48">
            <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
            <i class="fas fa-search mr-2"></i>Cari
        </button>
        
        @if(request('search') || request('category'))
            <a href="{{ route('user.catalog') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition flex items-center justify-center">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
        @endif
    </form>
</div>

<!-- Results Info -->
@if(request('search') || request('category'))
    <div class="mb-6">
        <p class="text-gray-600">
            Ditemukan {{ $books->total() }} buku
            @if(request('search'))
                untuk pencarian "<strong>{{ request('search') }}</strong>"
            @endif
            @if(request('category'))
                dalam kategori "<strong>{{ request('category') }}</strong>"
            @endif
        </p>
    </div>
@endif

<!-- Books Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($books as $book)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <!-- Book Cover -->
            <div class="relative">
                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-64 object-cover">
                
                <!-- Stock Badge -->
                <div class="absolute top-2 right-2">
                    @if($book->available > 0)
                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                            {{ $book->available }} tersedia
                        </span>
                    @else
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">
                            Tidak tersedia
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Book Info -->
            <div class="p-4">
                <div class="mb-3">
                    <h3 class="font-semibold text-gray-800 text-lg mb-1 line-clamp-2">{{ $book->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $book->author }}</p>
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-2">
                        {{ $book->category }}
                    </span>
                </div>
                
                @if($book->description)
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $book->description }}</p>
                @endif
                
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        @if($book->publication_year)
                            <span><i class="fas fa-calendar mr-1"></i>{{ $book->publication_year }}</span>
                        @endif
                        @if($book->publisher)
                            <br><span><i class="fas fa-building mr-1"></i>{{ $book->publisher }}</span>
                        @endif
                    </div>
                    
                    <div class="flex space-x-2">
                        <!-- View Details Button -->
                        <button onclick="showBookDetail({{ json_encode($book) }})" 
                                class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                            <i class="fas fa-eye"></i>
                        </button>
                        
                        <!-- Borrow Button -->
                        @if($book->available > 0)
                            <form method="POST" action="{{ route('user.borrow.request') }}" class="inline">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin meminjam buku ini?')">
                                    <i class="fas fa-hand-paper mr-1"></i>Pinjam
                                </button>
                            </form>
                        @else
                            <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed text-sm">
                                <i class="fas fa-times mr-1"></i>Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <i class="fas fa-book text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-500 mb-2">Tidak ada buku ditemukan</h3>
                <p class="text-gray-400">Coba ubah kata kunci pencarian atau filter kategori</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($books->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $books->appends(request()->query())->links() }}
    </div>
@endif

<!-- Book Detail Modal -->
<div id="bookModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 id="modalTitle" class="text-2xl font-bold text-gray-800"></h2>
                    <button onclick="closeBookModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <img id="modalCover" src="" alt="" class="w-full rounded-lg shadow-md">
                    </div>
                    
                    <div class="md:col-span-2">
                        <div class="space-y-3">
                            <div>
                                <span class="font-semibold text-gray-700">Penulis:</span>
                                <span id="modalAuthor" class="text-gray-600"></span>
                            </div>
                            
                            <div>
                                <span class="font-semibold text-gray-700">Kategori:</span>
                                <span id="modalCategory" class="inline-block bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded-full ml-2"></span>
                            </div>
                            
                            <div id="modalISBN" class="hidden">
                                <span class="font-semibold text-gray-700">ISBN:</span>
                                <span class="text-gray-600"></span>
                            </div>
                            
                            <div id="modalPublisher" class="hidden">
                                <span class="font-semibold text-gray-700">Penerbit:</span>
                                <span class="text-gray-600"></span>
                            </div>
                            
                            <div id="modalYear" class="hidden">
                                <span class="font-semibold text-gray-700">Tahun Terbit:</span>
                                <span class="text-gray-600"></span>
                            </div>
                            
                            <div>
                                <span class="font-semibold text-gray-700">Ketersediaan:</span>
                                <span id="modalStock" class="text-gray-600"></span>
                            </div>
                            
                            <div id="modalDescription" class="hidden">
                                <span class="font-semibold text-gray-700">Deskripsi:</span>
                                <p class="text-gray-600 mt-2"></p>
                            </div>
                        </div>
                        
                        <div id="modalBorrowButton" class="mt-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showBookDetail(book) {
        document.getElementById('modalTitle').textContent = book.title;
        document.getElementById('modalCover').src = book.cover_url;
        document.getElementById('modalCover').alt = book.title;
        document.getElementById('modalAuthor').textContent = book.author;
        document.getElementById('modalCategory').textContent = book.category;
        
        // ISBN
        const isbnDiv = document.getElementById('modalISBN');
        if (book.isbn) {
            isbnDiv.querySelector('span:last-child').textContent = book.isbn;
            isbnDiv.classList.remove('hidden');
        } else {
            isbnDiv.classList.add('hidden');
        }
        
        // Publisher
        const publisherDiv = document.getElementById('modalPublisher');
        if (book.publisher) {
            publisherDiv.querySelector('span:last-child').textContent = book.publisher;
            publisherDiv.classList.remove('hidden');
        } else {
            publisherDiv.classList.add('hidden');
        }
        
        // Publication Year
        const yearDiv = document.getElementById('modalYear');
        if (book.publication_year) {
            yearDiv.querySelector('span:last-child').textContent = book.publication_year;
            yearDiv.classList.remove('hidden');
        } else {
            yearDiv.classList.add('hidden');
        }
        
        // Stock
        document.getElementById('modalStock').textContent = book.available > 0 ? 
            `${book.available} dari ${book.stock} tersedia` : 'Tidak tersedia';
        
        // Description
        const descDiv = document.getElementById('modalDescription');
        if (book.description) {
            descDiv.querySelector('p').textContent = book.description;
            descDiv.classList.remove('hidden');
        } else {
            descDiv.classList.add('hidden');
        }
        
        // Borrow Button
        const borrowButtonDiv = document.getElementById('modalBorrowButton');
        if (book.available > 0) {
            borrowButtonDiv.innerHTML = `
                <form method="POST" action="{{ route('user.borrow.request') }}" class="inline">
                    @csrf
                    <input type="hidden" name="book_id" value="${book.id}">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
                            onclick="return confirm('Apakah Anda yakin ingin meminjam buku ini?')">
                        <i class="fas fa-hand-paper mr-2"></i>Pinjam Buku
                    </button>
                </form>
            `;
        } else {
            borrowButtonDiv.innerHTML = `
                <button disabled class="bg-gray-300 text-gray-500 px-6 py-2 rounded-lg cursor-not-allowed">
                    <i class="fas fa-times mr-2"></i>Tidak Tersedia
                </button>
            `;
        }
        
        document.getElementById('bookModal').classList.remove('hidden');
    }
    
    function closeBookModal() {
        document.getElementById('bookModal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    document.getElementById('bookModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBookModal();
        }
    });
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection