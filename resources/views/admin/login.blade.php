<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#08080f] text-white antialiased min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background effects --}}
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-purple-600/10 blur-[150px] -mr-64 -mt-64"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-600/5 blur-[150px] -ml-64 -mb-64"></div>
    </div>

    <div class="relative z-10 w-full max-w-sm mx-4">
        {{-- Login Header --}}
        <div class="mb-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-600 mb-6">
                <i class="fas fa-bolt text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-black tracking-tighter uppercase italic">Control<span class="text-purple-600">Center</span></h1>
            <p class="text-[10px] text-gray-600 uppercase tracking-[0.3em] font-bold mt-2">Authorization Required</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white/[0.03] backdrop-blur-xl border border-white/10 p-10">
            @if($errors->any())
                <div class="mb-8 bg-red-500/5 border-l-2 border-red-500 px-5 py-3 text-red-400 text-[11px] font-bold uppercase tracking-wider">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Master Email</label>
                    <div class="relative group">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="IDENTITY@WORKSPACE" required autofocus
                               class="w-full bg-white/5 border border-white/10 px-5 py-4 text-white placeholder-gray-800 focus:border-purple-600 outline-none transition-all text-sm font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Security Key</label>
                    <div class="relative group">
                        <input type="password" name="password" placeholder="••••••••••••" required
                               class="w-full bg-white/5 border border-white/10 px-5 py-4 text-white placeholder-gray-800 focus:border-purple-600 outline-none transition-all text-sm font-medium">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember" class="peer hidden">
                            <div class="w-4 h-4 border border-white/10 group-hover:border-purple-500/50 peer-checked:bg-purple-600 peer-checked:border-purple-600 transition-all"></div>
                            <i class="fas fa-check absolute inset-0 text-[8px] text-white flex items-center justify-center scale-0 peer-checked:scale-100 transition-all"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">Persist Session</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-purple-600 hover:bg-purple-500 text-white py-5 font-black uppercase tracking-[0.2em] transition-all shadow-[0_0_30px_rgba(147,51,234,0.2)] hover:shadow-purple-600/40 text-[11px]">
                    Initialize System
                </button>
            </form>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('portfolio') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-600 hover:text-purple-500 transition-all flex items-center justify-center gap-3">
                <span class="w-8 h-px bg-white/5"></span>
                Public Gateway
                <span class="w-8 h-px bg-white/5"></span>
            </a>
        </div>
    </div>
</body>
</html>
