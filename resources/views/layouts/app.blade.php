<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-blue-800 text-white w-64 min-h-screen p-4">
            <div class="mb-8">
                <h2 class="text-xl font-bold">Admin Panel</h2>
                <p class="text-blue-200 text-sm">Perpustakaan Digital</p>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-blue-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.books.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-blue-700 {{ request()->routeIs('admin.books.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Kelola Buku</span>
                </a>
                
                <a href="{{ route('admin.members.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-blue-700 {{ request()->routeIs('admin.members.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Kelola Anggota</span>
                </a>
                
                <a href="{{ route('admin.borrowings.index') }}" class="flex items-center space-x-2 p-2 rounded hover:bg-blue-700 {{ request()->routeIs('admin.borrowings.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Peminjaman</span>
                </a>
            </nav>
            
            <div class="mt-8 pt-8 border-t border-blue-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 p-2 rounded hover:bg-blue-700 w-full text-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b p-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ Auth::user()->name }}</span>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Auto hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert, [class*="bg-green-"], [class*="bg-red-"]');
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