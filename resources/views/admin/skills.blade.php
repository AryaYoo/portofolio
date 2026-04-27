@extends('layouts.admin')
@section('title', 'Skills')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black tracking-tight uppercase">Skill Matrix</h2>
    <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Configure your technological stack and proficiency levels</p>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Add Skill Form --}}
    <div class="lg:col-span-1">
        <div class="admin-card p-8 sticky top-28">
            <h3 class="text-xs font-black text-gray-300 uppercase tracking-widest mb-6">New Expertise</h3>
            <form action="{{ route('admin.skills.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Skill Name</label>
                    <input type="text" name="name" required placeholder="e.g. React.js"
                           class="admin-input w-full px-5 py-3 text-sm text-white placeholder-gray-800">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Symbol</label>
                        <input type="text" name="icon" placeholder="🎨"
                               class="admin-input w-full px-5 py-3 text-sm text-white placeholder-gray-800">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Priority</label>
                        <input type="number" name="sort_order" value="0"
                               class="admin-input w-full px-5 py-3 text-sm text-white placeholder-gray-800">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Classification</label>
                    <input type="text" name="category" placeholder="e.g. Frontend"
                           class="admin-input w-full px-5 py-3 text-sm text-white placeholder-gray-800">
                </div>
                <div>
                    <div class="flex justify-between mb-3">
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest">Mastery Level</label>
                        <span id="level-val" class="text-[10px] font-black text-purple-500 uppercase">50%</span>
                    </div>
                    <input type="range" name="level" min="0" max="100" step="5" value="50"
                           class="w-full accent-purple-600 bg-white/5 h-1.5 appearance-none cursor-pointer"
                           oninput="document.getElementById('level-val').innerText = this.value + '%'">
                </div>
                <button type="submit" class="admin-btn-primary w-full py-4 text-[10px] font-bold uppercase tracking-widest text-white">
                    Register Skill
                </button>
            </form>
        </div>
    </div>

    {{-- Skills List --}}
    <div class="lg:col-span-2">
        <div class="admin-card overflow-hidden">
            @php $groupedSkills = $skills->groupBy('category'); @endphp
            @forelse($groupedSkills as $category => $categorySkills)
                <div class="border-b border-white/5 last:border-b-0">
                    <div class="px-8 py-4 bg-white/[0.01] flex items-center justify-between">
                        <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest">{{ $category ?: 'General' }}</p>
                        <span class="text-[9px] font-bold text-gray-700">{{ $categorySkills->count() }} Items</span>
                    </div>
                    <div class="divide-y divide-white/5">
                        @foreach($categorySkills as $skill)
                            <div class="px-8 py-5 hover:bg-white/[0.02] transition-colors group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4 flex-1">
                                        <div class="w-10 h-10 bg-white/5 border border-white/5 flex items-center justify-center text-lg">
                                            {{ $skill->icon }}
                                        </div>
                                        <div class="flex-1 max-w-md">
                                            <div class="flex justify-between mb-2">
                                                <p class="text-sm font-bold text-gray-300">{{ $skill->name }}</p>
                                                <span class="text-[10px] font-black text-purple-600 uppercase">{{ $skill->level }}%</span>
                                            </div>
                                            <div class="w-full h-1 bg-white/5 overflow-hidden">
                                                <div class="h-full bg-purple-600 transition-all duration-1000" style="width: {{ $skill->level }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        <form action="{{ route('admin.skills.delete', $skill) }}" method="POST" onsubmit="return confirm('Erase this skill?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-9 h-9 bg-white/5 flex items-center justify-center text-gray-500 hover:text-white hover:bg-red-600 transition-all">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="px-8 py-20 text-center opacity-20">
                    <i class="fas fa-star-half-stroke text-5xl mb-4 block"></i>
                    <p class="text-[10px] font-black uppercase tracking-widest">No Expertise Cataloged</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
