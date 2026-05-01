<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Portfolio Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @php $globalProfile = \App\Models\Profile::first(); @endphp
    @if($globalProfile && $globalProfile->favicon)
        <link rel="icon" href="{{ asset('storage/' . $globalProfile->favicon) }}">
    @endif
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            overflow-x: hidden;
            overflow-y: auto;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #08080f;
        }
        ::-webkit-scrollbar-thumb {
            background: #1a1a2e;
            border-radius: 0;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9333ea;
        }
        .admin-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0;
            transition: all 0.3s ease;
        }
        .admin-card:hover {
            border-color: rgba(147, 51, 234, 0.3);
            background: rgba(255, 255, 255, 0.05);
        }
        .admin-btn-primary {
            background: #9333ea;
            border-radius: 0;
            transition: all 0.3s;
        }
        .admin-btn-primary:hover {
            background: #7e22ce;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.3);
        }
        .admin-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0;
            transition: all 0.3s;
        }
        .admin-input:focus {
            border-color: #9333ea;
            outline: none;
            box-shadow: 0 0 0 1px rgba(147, 51, 234, 0.5);
        }
    </style>
</head>
<body class="bg-[#08080f] text-white antialiased min-h-screen">
    <div class="flex min-h-screen">
        {{-- ═══════ SIDEBAR ═══════ --}}
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-64 bg-[#05050a] border-r border-white/5 z-40 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full">
            {{-- Logo --}}
            <div class="px-6 py-8 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-600 flex items-center justify-center">
                        <i class="fas fa-bolt text-white"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-sm tracking-tight">ADMIN<span class="text-purple-500">PORT</span></p>
                        <p class="text-[9px] text-gray-500 uppercase tracking-widest font-bold">Workspace</p>
                    </div>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-4 py-8 space-y-1.5 overflow-y-auto">
                <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold px-3 mb-4">Navigation</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.4)]' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-chart-line w-5 text-center"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold px-3 mb-4 mt-8">Collections</p>

                <a href="{{ route('admin.profile') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm transition-all duration-200 {{ request()->routeIs('admin.profile') ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.4)]' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-user-circle w-5 text-center"></i>
                    <span class="font-medium">Profile</span>
                </a>

                <a href="{{ route('admin.projects') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm transition-all duration-200 {{ request()->routeIs('admin.projects*') ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.4)]' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-rocket w-5 text-center"></i>
                    <span class="font-medium">Projects</span>
                </a>

                <a href="{{ route('admin.skills') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm transition-all duration-200 {{ request()->routeIs('admin.skills') ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.4)]' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-brain w-5 text-center"></i>
                    <span class="font-medium">Expertise</span>
                </a>

                <a href="{{ route('admin.experiences') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm transition-all duration-200 {{ request()->routeIs('admin.experiences') ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.4)]' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-history w-5 text-center"></i>
                    <span class="font-medium">History</span>
                </a>

                <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold px-3 mb-4 mt-8">System</p>

                <a href="{{ route('admin.contacts') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm transition-all duration-200 {{ request()->routeIs('admin.contacts') ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.4)]' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-inbox w-5 text-center"></i>
                    <span class="font-medium">Inbox</span>
                    @php $unreadCount = \App\Models\Contact::where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-white text-purple-600 text-[10px] font-black w-5 h-5 flex items-center justify-center">{{ $unreadCount }}</span>
                    @endif
                </a>
            </nav>

            {{-- Bottom --}}
            <div class="px-4 py-6 border-t border-white/5 space-y-2">
                <a href="{{ route('portfolio') }}" target="_blank"
                   class="flex items-center gap-3 px-4 py-2 text-xs text-gray-500 hover:text-white transition-all duration-200">
                    <i class="fas fa-eye w-4 text-center"></i>
                    <span>Preview Site</span>
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-xs text-red-500/60 hover:text-red-400 transition-all duration-200">
                        <i class="fas fa-power-off w-4 text-center"></i>
                        <span>Logout System</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ═══════ MAIN CONTENT ═══════ --}}
        <main class="flex-1 lg:ml-64 bg-[#08080f] min-h-screen flex flex-col">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 bg-[#08080f]/70 backdrop-blur-md border-b border-white/5 px-8 py-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="lg:hidden w-10 h-10 bg-white/5 flex items-center justify-center text-gray-400 hover:text-white transition-colors" onclick="document.getElementById('admin-sidebar').classList.toggle('-translate-x-full');">
                        <i class="fas fa-bars-staggered text-sm"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">@yield('title', 'Dashboard')</h1>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mt-0.5">Control Center</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] text-gray-500 uppercase tracking-wider">Super Administrator</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-600/10 border border-purple-500/20 flex items-center justify-center">
                        <span class="text-purple-400 text-xs font-black">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-8 mt-6 bg-green-500/5 border border-green-500/20 px-6 py-4 text-green-400 text-sm flex items-center gap-3">
                    <i class="fas fa-circle-check"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mx-8 mt-6 bg-red-500/5 border border-red-500/20 px-6 py-4 text-red-400 text-sm">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-center gap-3"><i class="fas fa-circle-exclamation text-xs"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Page Content --}}
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Sidebar overlay for mobile --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/80 z-30 hidden lg:hidden" onclick="document.getElementById('admin-sidebar').classList.add('-translate-x-full'); this.classList.add('hidden');"></div>
    
    @stack('scripts')
</body>
</html>
