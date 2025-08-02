@extends('admin.layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Edit Peminjaman: {{ $borrowing->borrow_code }}</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.borrowings.update', $borrowing->id) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Current Status Info -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium text-gray-800">Status Peminjaman Saat Ini</h4>
                        <p class="text-sm text-gray-600">Kode: {{ $borrowing->borrow_code }}</p>
                    </div>
                    <div>
                        @if($borrowing->status === 'borrowed')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">Dipinjam</span>
                        @elseif($borrowing->status === 'returned')
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Dikembalikan</span>
                        @elseif($borrowing->status === 'overdue')
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">Terlambat</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Book Selection -->
                <div class="md:col-span-2">
                    <label for="book_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Buku *</label>
                    <select id="book_id" name="book_id" required onchange="updateBookInfo()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('book_id') border-red-500 @enderror">
                        <option value="">-- Pilih Buku --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" 
                                    data-available="{{ $book->available }}" 
                                    data-title="{{ $book->title }}" 
                                    data-author="{{ $book->author }}" 
                                    {{ (old('book_id', $borrowing->book_id) == $book->id) ? 'selected' : '' }}>
                                {{ $book->title }} - {{ $book->author }} (Tersedia: {{ $book->available }})
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Book Info Display -->
                    <div id="bookInfo" class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg hidden">
                        <h4 class="font-medium text-blue-800">Informasi Buku:</h4>
                        <p id="bookTitle" class="text-blue-700"></p>
                        <p id="bookAuthor" class="text-blue-600 text-sm"></p>
                        <p id="bookAvailable" class="text-blue-600 text-sm"></p>
                    </div>
                </div>
                
                <!-- Member Selection -->
                <div class="md:col-span-2">
                    <label for="member_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Anggota *</label>
                    <select id="member_id" name="member_id" required onchange="updateMemberInfo()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('member_id') border-red-500 @enderror">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" 
                                    data-name="{{ $member->name }}" 
                                    data-number="{{ $member->member_number }}" 
                                    data-email="{{ $member->email }}" 
                                    {{ (old('member_id', $borrowing->member_id) == $member->id) ? 'selected' : '' }}>
                                {{ $member->name }} ({{ $member->member_number }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Member Info Display -->
                    <div id="memberInfo" class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg hidden">
                        <h4 class="font-medium text-green-800">Informasi Anggota:</h4>
                        <p id="memberName" class="text-green-700"></p>
                        <p id="memberNumber" class="text-green-600 text-sm"></p>
                        <p id="memberEmail" class="text-green-600 text-sm"></p>
                    </div>
                </div>
                
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select id="status" name="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                        <option value="borrowed" {{ old('status', $borrowing->status) === 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="returned" {{ old('status', $borrowing->status) === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="overdue" {{ old('status', $borrowing->status) === 'overdue' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Borrow Date -->
                <div>
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pinjam *</label>
                    <input type="date" id="borrow_date" name="borrow_date" value="{{ old('borrow_date', $borrowing->borrow_date) }}" required onchange="updateDueDate()"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('borrow_date') border-red-500 @enderror">
                    @error('borrow_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Jatuh Tempo *</label>
                    <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $borrowing->due_date) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('due_date') border-red-500 @enderror">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Return Date (if status is returned) -->
                <div id="returnDateDiv" class="{{ $borrowing->status === 'returned' ? '' : 'hidden' }}">
                    <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kembali</label>
                    <input type="date" id="return_date" name="return_date" value="{{ old('return_date', $borrowing->return_date) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('return_date') border-red-500 @enderror">
                    @error('return_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea id="notes" name="notes" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror"
                          placeholder="Catatan tambahan untuk peminjaman ini...">{{ old('notes', $borrowing->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Info -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-info-circle text-yellow-500 mt-0.5 mr-2"></i>
                    <div class="text-sm text-yellow-700">
                        <p class="font-medium">Informasi:</p>
                        <ul class="mt-1 list-disc list-inside">
                            <li>Mengubah status ke "Dikembalikan" akan menambah stok buku</li>
                            <li>Mengubah status dari "Dikembalikan" akan mengurangi stok buku</li>
                            <li>Tanggal kembali otomatis terisi jika status diubah ke "Dikembalikan"</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.borrowings.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <a href="{{ route('admin.borrowings.show', $borrowing->id) }}" class="px-4 py-2 border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Update Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateBookInfo() {
        const select = document.getElementById('book_id');
        const info = document.getElementById('bookInfo');
        const title = document.getElementById('bookTitle');
        const author = document.getElementById('bookAuthor');
        const available = document.getElementById('bookAvailable');
        
        if (select.value) {
            const option = select.options[select.selectedIndex];
            title.textContent = 'Judul: ' + option.dataset.title;
            author.textContent = 'Penulis: ' + option.dataset.author;
            available.textContent = 'Tersedia: ' + option.dataset.available + ' eksemplar';
            info.classList.remove('hidden');
        } else {
            info.classList.add('hidden');
        }
    }
    
    function updateMemberInfo() {
        const select = document.getElementById('member_id');
        const info = document.getElementById('memberInfo');
        const name = document.getElementById('memberName');
        const number = document.getElementById('memberNumber');
        const email = document.getElementById('memberEmail');
        
        if (select.value) {
            const option = select.options[select.selectedIndex];
            name.textContent = 'Nama: ' + option.dataset.name;
            number.textContent = 'No. Anggota: ' + option.dataset.number;
            email.textContent = 'Email: ' + option.dataset.email;
            info.classList.remove('hidden');
        } else {
            info.classList.add('hidden');
        }
    }
    
    function updateDueDate() {
        const borrowDate = document.getElementById('borrow_date');
        const dueDate = document.getElementById('due_date');
        
        if (borrowDate.value && !dueDate.value) {
            const borrow = new Date(borrowDate.value);
            const due = new Date(borrow);
            due.setDate(due.getDate() + 14); // Add 14 days
            
            const year = due.getFullYear();
            const month = String(due.getMonth() + 1).padStart(2, '0');
            const day = String(due.getDate()).padStart(2, '0');
            
            dueDate.value = `${year}-${month}-${day}`;
        }
    }
    
    // Handle status change
    document.getElementById('status').addEventListener('change', function() {
        const returnDateDiv = document.getElementById('returnDateDiv');
        const returnDateInput = document.getElementById('return_date');
        
        if (this.value === 'returned') {
            returnDateDiv.classList.remove('hidden');
            if (!returnDateInput.value) {
                returnDateInput.value = new Date().toISOString().split('T')[0];
            }
        } else {
            returnDateDiv.classList.add('hidden');
            returnDateInput.value = '';
        }
    });
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateBookInfo();
        updateMemberInfo();
        
        // Show return date field if status is returned
        const status = document.getElementById('status').value;
        const returnDateDiv = document.getElementById('returnDateDiv');
        if (status === 'returned') {
            returnDateDiv.classList.remove('hidden');
        }
    });
</script>
@endsection