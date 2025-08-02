<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom scrollbar untuk sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar - Fixed Position -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-800 text-white">
        <div class="flex flex-col h-full">
            <!-- Sidebar Header -->
            <div class="flex-shrink-0 p-4 border-b border-blue-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-book-open text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Admin Panel</h2>
                        <p class="text-blue-200 text-xs">Perpustakaan Digital</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation - Scrollable -->
            <nav class="flex-1 px-4 py-4 overflow-y-auto sidebar-scroll">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 shadow-lg' : '' }}">
                        <i class="fas fa-home w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.books.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-blue-700 shadow-lg' : '' }}">
                        <i class="fas fa-book w-5"></i>
                        <span class="font-medium">Kelola Buku</span>
                    </a>
                    
                    <a href="{{ route('admin.members.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.members.*') ? 'bg-blue-700 shadow-lg' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="font-medium">Kelola Anggota</span>
                    </a>
                    
                    <a href="{{ route('admin.borrowings.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.borrowings.*') ? 'bg-blue-700 shadow-lg' : '' }}">
                        <i class="fas fa-exchange-alt w-5"></i>
                        <span class="font-medium">Peminjaman</span>
                    </a>
                </div>
                
                <!-- Quick Stats in Sidebar -->
                <div class="mt-6 pt-6 border-t border-blue-700">
                    <h3 class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-3">Quick Stats</h3>
                    <div class="space-y-2">
                        <div class="bg-blue-700 bg-opacity-50 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-blue-200">Total Buku</span>
                                <span class="text-sm font-bold">{{ isset($totalBooks) ? $totalBooks : '0' }}</span>
                            </div>
                        </div>
                        <div class="bg-blue-700 bg-opacity-50 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-blue-200">Anggota</span>
                                <span class="text-sm font-bold">{{ isset($totalMembers) ? $totalMembers : '0' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="flex-shrink-0 p-4 border-t border-blue-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg hover:bg-red-600 hover:bg-opacity-20 transition-colors duration-200 w-full text-left group">
                        <i class="fas fa-sign-out-alt w-5 group-hover:text-red-300"></i>
                        <span class="font-medium group-hover:text-red-300">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="ml-64 min-h-screen flex flex-col">
        <!-- Header - Fixed Top -->
        <header class="sticky top-0 z-40 bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-600 mt-1">{{ now()->format('l, d F Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Notification Bell -->
                        <div class="relative">
                            <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <i class="fas fa-bell"></i>
                            </button>
                            @if(isset($pendingBorrowings) && $pendingBorrowings > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $pendingBorrowings }}</span>
                            @endif
                        </div>
                        
                        <!-- User Info -->
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area - Scrollable -->
        <main class="flex-1 p-6 overflow-y-auto">
            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-600"></i>
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg relative flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-600 hover:text-red-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle mr-3 text-red-600 mt-0.5"></i>
                        <div class="flex-1">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- Mobile Sidebar Overlay (untuk responsive design) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <script>
        // Auto hide alerts dengan animasi yang lebih smooth
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'all 0.5s ease-out';
                alert.style.transform = 'translateX(100%)';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>