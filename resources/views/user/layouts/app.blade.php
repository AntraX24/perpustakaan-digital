<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-blue-600">
                        <i class="fas fa-book-open mr-2"></i>Perpustakaan Digital
                    </h1>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-blue-600 transition {{ request()->routeIs('user.dashboard') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-home mr-1"></i>Dashboard
                    </a>
                    
                    <a href="{{ route('user.catalog') }}" class="text-gray-700 hover:text-blue-600 transition {{ request()->routeIs('user.catalog') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-book mr-1"></i>Katalog Buku
                    </a>
                    
                    <a href="{{ route('user.borrowings') }}" class="text-gray-700 hover:text-blue-600 transition {{ request()->routeIs('user.borrowings') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-history mr-1"></i>Riwayat Pinjam
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:block">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border hidden" id="userDropdown">
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none" id="mobileMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="md:hidden hidden border-t border-gray-200" id="mobileMenu">
            <div class="px-4 py-2 space-y-2">
                <a href="{{ route('user.dashboard') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="{{ route('user.catalog') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-book mr-2"></i>Katalog Buku
                </a>
                <a href="{{ route('user.borrowings') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-history mr-2"></i>Riwayat Pinjam
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Perpustakaan Digital. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // User dropdown toggle
        document.querySelector('[class*="relative"] button').addEventListener('click', function() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        });

        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = document.querySelector('[class*="relative"] button');
            
            if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Auto hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-"], [class*="bg-red-"]');
            alerts.forEach(alert => {
                if (alert.classList.contains('bg-green-100') || alert.classList.contains('bg-red-100')) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            });
        }, 5000);
    </script>
</body>
</html>