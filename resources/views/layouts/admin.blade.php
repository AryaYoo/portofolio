<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Portfolio Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#08080f] text-white font-['Inter'] antialiased min-h-screen">
    <div class="flex min-h-screen">
        {{-- ═══════ SIDEBAR ═══════ --}}
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 w-64 bg-[#0c0c18] border-r border-white/5 z-40 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full">
            {{-- Logo --}}
            <div class="px-6 py-6 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-purple-600 flex items-center justify-center">
                        <i class="fas fa-code text-sm text-white"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Portfolio</p>
                        <p class="text-[10px] text-gray-500 -mt-0.5">Admin Panel</p>
                    </div>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                <p class="text-[10px] text-gray-600 uppercase tracking-wider font-semibold px-3 mb-3">Main</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600/20 text-purple-400 border border-purple-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-grid-2 w-5 text-center text-xs"></i>
                    <span>Dashboard</span>
                </a>

                <p class="text-[10px] text-gray-600 uppercase tracking-wider font-semibold px-3 mb-3 mt-6">Content</p>

                <a href="{{ route('admin.profile') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.profile') ? 'bg-purple-600/20 text-purple-400 border border-purple-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-user w-5 text-center text-xs"></i>
                    <span>Profile</span>
                </a>

                <a href="{{ route('admin.projects') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.projects*') ? 'bg-purple-600/20 text-purple-400 border border-purple-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-folder w-5 text-center text-xs"></i>
                    <span>Projects</span>
                </a>

                <a href="{{ route('admin.skills') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.skills') ? 'bg-purple-600/20 text-purple-400 border border-purple-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-star w-5 text-center text-xs"></i>
                    <span>Skills</span>
                </a>

                <a href="{{ route('admin.experiences') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.experiences') ? 'bg-purple-600/20 text-purple-400 border border-purple-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-briefcase w-5 text-center text-xs"></i>
                    <span>Experience</span>
                </a>

                <p class="text-[10px] text-gray-600 uppercase tracking-wider font-semibold px-3 mb-3 mt-6">Other</p>

                <a href="{{ route('admin.contacts') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('admin.contacts') ? 'bg-purple-600/20 text-purple-400 border border-purple-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-envelope w-5 text-center text-xs"></i>
                    <span>Messages</span>
                    @php $unreadCount = \App\Models\Contact::where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-purple-600 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount }}</span>
                    @endif
                </a>
            </nav>

            {{-- Bottom --}}
            <div class="px-3 py-4 border-t border-white/5">
                <a href="{{ route('portfolio') }}" target="_blank"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-400 hover:bg-white/5 hover:text-white transition-all duration-200">
                    <i class="fas fa-external-link-alt w-5 text-center text-xs"></i>
                    <span>View Site</span>
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-400 hover:bg-red-500/10 hover:text-red-400 transition-all duration-200">
                        <i class="fas fa-sign-out-alt w-5 text-center text-xs"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ═══════ MAIN CONTENT ═══════ --}}
        <main class="flex-1 lg:ml-64">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 bg-[#08080f]/80 backdrop-blur-xl border-b border-white/5 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="lg:hidden w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-600/20 flex items-center justify-center">
                        <span class="text-purple-400 text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <span class="text-sm text-gray-400 hidden sm:block">{{ Auth::user()->name }}</span>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-6 mt-4 bg-green-500/10 border border-green-500/20 rounded-xl px-5 py-3 text-green-400 text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mx-6 mt-4 bg-red-500/10 border border-red-500/20 rounded-xl px-5 py-3 text-red-400 text-sm">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-center gap-2"><i class="fas fa-exclamation-circle text-xs"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Page Content --}}
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Sidebar overlay for mobile --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="document.getElementById('admin-sidebar').classList.add('-translate-x-full'); this.classList.add('hidden');"></div>
</body>
</html>
