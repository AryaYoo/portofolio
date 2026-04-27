@extends('layouts.admin')
@section('title', 'Project modular Page - ' . $project->title)

@section('content')
<div class="mb-10 flex items-center justify-between">
    <div>
        <a href="{{ route('admin.projects') }}" class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 hover:text-purple-500 transition-all mb-8">
            <i class="fas fa-long-arrow-alt-left"></i>
            <span>Return to Collections</span>
        </a>
        <h2 class="text-2xl font-black tracking-tight uppercase">Modular Blueprint: {{ $project->title }}</h2>
        <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Construct and sequence visual and narrative components</p>
    </div>
    
    <div class="flex gap-4">
        <a href="{{ route('projects.show', $project) }}" target="_blank" class="admin-btn-secondary px-8 py-4 text-[10px] font-bold uppercase tracking-widest flex items-center gap-3">
            <i class="fas fa-external-link-alt"></i>
            <span>Live Preview</span>
        </a>
    </div>
</div>

<div class="grid lg:grid-cols-12 gap-10 items-start">
    {{-- Add New Section --}}
    <div class="lg:col-span-4 space-y-8">
        <div class="admin-card p-8">
            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-8">Assemble New Component</h4>
            <form action="{{ route('admin.projects.sections.store', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Component Type</label>
                    <select name="type" required class="admin-input w-full px-5 py-4 text-xs text-white appearance-none cursor-pointer">
                        <option value="hero" class="bg-[#08080f]">Hero Banner Section</option>
                        <option value="model1" class="bg-[#08080f]">Section Model 1 (Text Left, Image Right)</option>
                        <option value="model2" class="bg-[#08080f]">Section Model 2 (Image Left, Text Right)</option>
                        <option value="model3" class="bg-[#08080f]">Section Model 3 (Centered Text)</option>
                        <option value="demo" class="bg-[#08080f]">Try Demo Section</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Label / Title</label>
                    <input type="text" name="title" placeholder="Component identifier" class="admin-input w-full px-5 py-4 text-xs text-white">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Narrative / Content</label>
                    <textarea name="content" rows="6" placeholder="Document the core narrative..." class="admin-input w-full px-5 py-4 text-xs text-white resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-4">Visual Asset</label>
                    <input type="file" name="image" id="img-input" class="hidden">
                    <label for="img-input" class="inline-flex w-full items-center justify-center gap-3 bg-white/5 border border-white/5 hover:border-purple-500/30 px-6 py-4 text-[9px] font-bold uppercase tracking-widest text-gray-500 hover:text-white cursor-pointer transition-all">
                        <i class="fas fa-upload"></i>
                        <span>Upload Capture</span>
                    </label>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Assembly Order</label>
                    <input type="number" name="sort_order" value="0" class="admin-input w-full px-5 py-4 text-xs text-white">
                </div>
                <button type="submit" class="admin-btn-primary w-full py-5 text-[10px] font-black uppercase tracking-[0.2em] mt-4">
                    Inject Component
                </button>
            </form>
        </div>
    </div>

    {{-- Section List --}}
    <div class="lg:col-span-8">
        <div class="space-y-4">
            @forelse($project->sections as $section)
                <div class="admin-card p-6 flex items-center gap-6 group hover:border-purple-500/30 transition-all">
                    <div class="w-12 h-12 bg-white/5 flex items-center justify-center border border-white/5 text-[10px] font-bold text-gray-600">
                        {{ $section->sort_order }}
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            <span class="text-[9px] font-black uppercase tracking-tighter text-purple-500 bg-purple-500/10 px-2 py-0.5">
                                {{ strtoupper($section->type) }}
                            </span>
                            <h5 class="text-sm font-bold text-white">{{ $section->title ?? 'Untitled Component' }}</h5>
                        </div>
                        <p class="text-[10px] text-gray-500 line-clamp-1 italic">{{ Str::limit($section->content, 100) }}</p>
                    </div>

                    @if($section->image)
                        <div class="h-12 w-20 overflow-hidden border border-white/10">
                            <img src="{{ asset('storage/' . $section->image) }}" class="w-full h-full object-cover opacity-60">
                        </div>
                    @endif

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.projects.sections.edit', $section) }}" 
                           class="w-10 h-10 flex items-center justify-center bg-white/5 border border-white/5 hover:border-blue-500/50 text-blue-500 transition-all"
                           title="Refine Component Contents">
                            <i class="fas fa-pen-nib"></i>
                        </a>
                        
                        <form action="{{ route('admin.projects.sections.delete', $section) }}" method="POST" class="inline" onsubmit="return confirm('Decommission this component?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-white/5 border border-white/5 hover:border-red-500/50 text-red-500 transition-all">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="admin-card p-20 text-center border-dashed border-2">
                    <i class="fas fa-layer-group text-4xl text-gray-800 mb-6 block"></i>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-widest">No modular components found in this sequence</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
