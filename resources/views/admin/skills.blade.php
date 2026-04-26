@extends('layouts.admin')
@section('title', 'Skills')

@section('content')
<p class="text-gray-500 text-sm mb-6">Manage your skills and expertise</p>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Add Skill Form --}}
    <div class="lg:col-span-1">
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6 sticky top-24">
            <h3 class="text-sm font-semibold text-gray-300 mb-4">Add New Skill</h3>
            <form action="{{ route('admin.skills.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Figma"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Icon (emoji)</label>
                    <input type="text" name="icon" placeholder="🎨"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Category</label>
                    <input type="text" name="category" placeholder="e.g. Design"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Level (0-100) *</label>
                    <input type="number" name="level" min="0" max="100" required value="50"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-1.5 font-medium">Sort Order</label>
                    <input type="number" name="sort_order" value="0"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white py-2.5 rounded-xl font-medium transition-all duration-300 text-sm">
                    Add Skill
                </button>
            </form>
        </div>
    </div>

    {{-- Skills List --}}
    <div class="lg:col-span-2">
        <div class="bg-white/[0.03] border border-white/10 rounded-2xl overflow-hidden">
            @php $groupedSkills = $skills->groupBy('category'); @endphp
            @forelse($groupedSkills as $category => $categorySkills)
                <div class="border-b border-white/5 last:border-b-0">
                    <div class="px-6 py-3 bg-white/[0.02]">
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">{{ $category ?: 'Uncategorized' }}</p>
                    </div>
                    @foreach($categorySkills as $skill)
                        <div class="px-6 py-4 border-b border-white/5 last:border-b-0 hover:bg-white/[0.02] transition-colors group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-lg">{{ $skill->icon }}</span>
                                    <div>
                                        <p class="text-sm font-medium">{{ $skill->name }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="w-24 h-1 bg-white/5 rounded-full overflow-hidden">
                                                <div class="h-full bg-purple-500 rounded-full" style="width: {{ $skill->level }}%"></div>
                                            </div>
                                            <span class="text-[10px] text-gray-500">{{ $skill->level }}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form action="{{ route('admin.skills.delete', $skill) }}" method="POST" onsubmit="return confirm('Delete this skill?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-white/5 flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200">
                                            <i class="fas fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-600">
                    <i class="fas fa-star text-3xl mb-3 block"></i>
                    <p>No skills added yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
