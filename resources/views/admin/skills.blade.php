@extends('layouts.admin')
@section('title', 'Skills & Certifications')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black tracking-tight uppercase">Certifications</h2>
    <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Upload certificate images with skill tags and descriptions</p>
</div>

<div class="grid lg:grid-cols-12 gap-10">
    {{-- Add Certificate Form --}}
    <div class="lg:col-span-4">
        <div class="admin-card p-10 sticky top-28">
            <h3 class="text-xs font-black text-gray-300 uppercase tracking-widest mb-8">New Certificate</h3>
            <form action="{{ route('admin.skills.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Certificate Title *</label>
                    <input type="text" name="name" required placeholder="e.g. Google UX Design"
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Certificate Image</label>
                    <div class="relative">
                        <input type="file" name="image" accept="image/*" id="cert-image-input" class="hidden">
                        <label for="cert-image-input" class="inline-flex w-full items-center justify-center gap-3 bg-white/5 border border-white/10 hover:border-purple-500/50 px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-white cursor-pointer transition-all">
                            <i class="fas fa-image"></i>
                            <span>Upload Certificate Image</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Description</label>
                    <textarea name="description" rows="3" placeholder="Certificate details, issuing organization..."
                              class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800 resize-none leading-relaxed"></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Skill Tags</label>
                    <input type="text" name="tags" placeholder="e.g. UI/UX, Figma, Prototyping"
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                    <p class="text-[9px] text-gray-700 mt-2">Separate tags with commas</p>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Category</label>
                        <input type="text" name="category" placeholder="e.g. Design"
                               class="admin-input w-full px-5 py-4 text-sm text-white placeholder-gray-800">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Priority</label>
                        <input type="number" name="sort_order" value="0"
                               class="admin-input w-full px-5 py-4 text-sm text-white placeholder-gray-800">
                    </div>
                </div>

                <input type="hidden" name="level" value="0">

                <button type="submit" class="admin-btn-primary w-full py-5 text-[10px] font-black uppercase tracking-[0.2em] text-white">
                    Register Certificate
                </button>
            </form>
        </div>
    </div>

    {{-- Certificates List --}}
    <div class="lg:col-span-8 space-y-6">
        @forelse($skills as $skill)
            <div class="admin-card p-8 group relative overflow-hidden">
                <div class="flex items-start gap-8">
                    {{-- Certificate Thumbnail --}}
                    <div class="flex-none w-28 h-20 bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden">
                        @if($skill->image)
                            <img src="{{ asset('storage/' . $skill->image) }}" alt="{{ $skill->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-certificate text-2xl text-gray-800"></i>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            @if($skill->category)
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-purple-600 text-white px-3 py-1">{{ $skill->category }}</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-black tracking-tight text-gray-200 uppercase">{{ $skill->name }}</h3>
                        @if($skill->description)
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">{{ $skill->description }}</p>
                        @endif
                        @if($skill->tags && count($skill->tags))
                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @foreach($skill->tags as $tag)
                                    <span class="text-[9px] font-bold text-purple-400 bg-purple-500/10 px-2 py-0.5 uppercase tracking-wider">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <form action="{{ route('admin.skills.delete', $skill) }}" method="POST" onsubmit="return confirm('Delete this certificate?')">
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
                <i class="fas fa-certificate text-6xl mb-6 block"></i>
                <p class="text-[10px] font-black uppercase tracking-[0.3em]">No Certificates Registered</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
