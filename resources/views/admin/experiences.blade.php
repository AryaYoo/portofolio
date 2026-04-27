@extends('layouts.admin')
@section('title', 'Experience')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black tracking-tight uppercase">Professional History</h2>
    <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Chronological record of your career and education</p>
</div>

<div class="grid lg:grid-cols-12 gap-10">
    {{-- Add Experience Form --}}
    <div class="lg:col-span-4">
        <div class="admin-card p-10 sticky top-28">
            <h3 class="text-xs font-black text-gray-300 uppercase tracking-widest mb-8">Register Experience</h3>
            <form action="{{ route('admin.experiences.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Position Title</label>
                    <input type="text" name="title" required placeholder="e.g. Lead Developer"
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Organization</label>
                    <input type="text" name="company" required placeholder="e.g. Google Corp"
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Organization Logo</label>
                    <div class="relative">
                        <input type="file" name="logo" accept="image/*" id="logo-input" class="hidden">
                        <label for="logo-input" class="inline-flex w-full items-center justify-center gap-3 bg-white/5 border border-white/10 hover:border-purple-500/50 px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-white cursor-pointer transition-all">
                            <i class="fas fa-camera"></i>
                            <span>Select Logo Asset</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Location</label>
                        <input type="text" name="location" placeholder="e.g. Remote"
                               class="admin-input w-full px-5 py-4 text-sm text-white placeholder-gray-800">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Priority</label>
                        <input type="number" name="sort_order" value="0"
                               class="admin-input w-full px-5 py-4 text-sm text-white placeholder-gray-800">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Time Period</label>
                    <input type="text" name="period" required placeholder="e.g. 2024 - Present"
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Key Responsibilities</label>
                    <textarea name="description" rows="5" placeholder="Summary of achievements..."
                              class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800 resize-none leading-relaxed"></textarea>
                </div>
                <button type="submit" class="admin-btn-primary w-full py-5 text-[10px] font-black uppercase tracking-[0.2em] text-white">
                    Synchronize Master History
                </button>
            </form>
        </div>
    </div>

    {{-- Experience List --}}
    <div class="lg:col-span-8 space-y-6">
        @forelse($experiences as $exp)
            <div class="admin-card p-10 group relative overflow-hidden">
                <div class="flex items-start gap-8">
                    {{-- Logo --}}
                    <div class="flex-none w-24 h-24 bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden">
                        @if($exp->logo)
                            <img src="{{ asset('storage/' . $exp->logo) }}" alt="{{ $exp->company }}" class="w-full h-full object-contain p-2">
                        @else
                            <i class="fas fa-building text-3xl text-gray-800"></i>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-purple-600 text-white px-3 py-1.5 shadow-[0_0_15px_rgba(147,51,234,0.3)]">{{ $exp->period }}</span>
                        </div>
                        <h3 class="text-xl font-black tracking-tight text-gray-200 uppercase">{{ $exp->title }}</h3>
                        <p class="text-[10px] font-bold text-purple-500 uppercase tracking-[0.2em] mt-1">
                            {{ $exp->company }} @if($exp->location) <span class="text-gray-700 mx-2">/</span> {{ $exp->location }} @endif
                        </p>
                        @if($exp->description)
                            <p class="text-sm text-gray-500 mt-8 leading-relaxed max-w-2xl border-l-2 border-white/5 pl-6 italic">{{ $exp->description }}</p>
                        @endif
                    </div>

                    <div class="flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all ml-6">
                        <form action="{{ route('admin.experiences.delete', $exp) }}" method="POST" onsubmit="return confirm('Erase this transmission record?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-12 h-12 bg-white/5 flex items-center justify-center text-gray-500 hover:text-white hover:bg-red-600 transition-all">
                                <i class="fas fa-trash-alt text-[10px]"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="admin-card p-24 text-center opacity-10">
                <i class="fas fa-history text-6xl mb-6 block"></i>
                <p class="text-[10px] font-black uppercase tracking-[0.3em]">Temporal Records Vacant</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
