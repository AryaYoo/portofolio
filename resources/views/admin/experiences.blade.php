@extends('layouts.admin')
@section('title', 'Experience')

@section('content')
<p class="text-gray-500 text-sm mb-6">Manage your professional experience and education</p>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Add Experience Form --}}
    <div class="lg:col-span-1">
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6 sticky top-24">
            <h3 class="text-sm font-semibold text-gray-300 mb-4">Add New Experience</h3>
            <form action="{{ route('admin.experiences.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Title *</label>
                    <input type="text" name="title" required placeholder="e.g. UI/UX Designer"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Company *</label>
                    <input type="text" name="company" required placeholder="e.g. Company Name"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Location</label>
                    <input type="text" name="location" placeholder="e.g. Indonesia"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Period *</label>
                    <input type="text" name="period" required placeholder="e.g. 2023 - Present"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Description</label>
                    <textarea name="description" rows="3" placeholder="Brief description..."
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Sort Order</label>
                    <input type="number" name="sort_order" value="0"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white py-2.5 rounded-xl font-medium transition-all duration-300 text-sm">
                    Add Experience
                </button>
            </form>
        </div>
    </div>

    {{-- Experience List --}}
    <div class="lg:col-span-2 space-y-4">
        @forelse($experiences as $exp)
            <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6 hover:border-white/20 transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-xs bg-purple-500/20 text-purple-400 px-2.5 py-1 rounded-lg font-medium">{{ $exp->period }}</span>
                        </div>
                        <h3 class="text-lg font-semibold">{{ $exp->title }}</h3>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $exp->company }} @if($exp->location)· {{ $exp->location }}@endif</p>
                        @if($exp->description)
                            <p class="text-gray-500 text-sm mt-3 leading-relaxed">{{ $exp->description }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity ml-4 flex-none">
                        <form action="{{ route('admin.experiences.delete', $exp) }}" method="POST" onsubmit="return confirm('Delete this experience?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-12 text-center text-gray-600">
                <i class="fas fa-briefcase text-3xl mb-3 block"></i>
                <p>No experience added yet</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
