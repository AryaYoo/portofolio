<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#08080f] text-white font-['Inter'] antialiased min-h-screen flex items-center justify-center">
    {{-- Background effects --}}
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-1/3 right-1/3 w-80 h-80 bg-violet-500/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-md mx-4">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-purple-600/20 border border-purple-500/20 mb-4">
                <i class="fas fa-code text-2xl text-purple-400"></i>
            </div>
            <h1 class="text-2xl font-bold">Welcome Back</h1>
            <p class="text-gray-500 text-sm mt-1">Sign in to manage your portfolio</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-2xl p-8">
            @if($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 rounded-xl px-4 py-3 text-red-400 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@portfolio.com" required autofocus
                               class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-sm"></i>
                        <input type="password" name="password" placeholder="••••••••" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-white/5 border-white/20 text-purple-600 focus:ring-purple-500/50">
                        <span class="text-sm text-gray-400">Remember me</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-purple-600 hover:bg-purple-500 text-white py-3.5 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-purple-600/25 text-sm">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-gray-600 text-xs">
            <a href="{{ route('portfolio') }}" class="text-purple-400 hover:text-purple-300 transition-colors">&larr; Back to Portfolio</a>
        </p>
    </div>
</body>
</html>
