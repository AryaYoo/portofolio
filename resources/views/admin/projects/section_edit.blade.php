@extends('layouts.admin')
@section('title', 'Refine Component - ' . $section->project->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.projects.sections', $section->project_id) }}" class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 hover:text-purple-500 transition-all mb-8">
                <i class="fas fa-long-arrow-alt-left"></i>
                <span>Return to Blueprint</span>
            </a>
            <h2 class="text-2xl font-black tracking-tight uppercase">Refine Component</h2>
            <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Calibrating: {{ strtoupper($section->type) }}</p>
        </div>
    </div>

    <div class="admin-card p-10">
        <form action="{{ route('admin.projects.sections.update', $section) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid md:grid-cols-2 gap-10">
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Label / Title</label>
                        <input type="text" name="title" value="{{ old('title', $section->title) }}" placeholder="Component identifier" class="admin-input w-full px-5 py-4 text-xs text-white">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Narrative / Content</label>
                        <textarea name="content" rows="10" placeholder="Document the core narrative..." class="admin-input w-full px-5 py-4 text-xs text-white resize-none">{{ old('content', $section->content) }}</textarea>
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-4">Visual Asset</label>
                        @if($section->image)
                            <div class="mb-6 relative group inline-block overflow-hidden">
                                <img src="{{ asset('storage/' . $section->image) }}" alt="" class="h-32 border border-white/10 opacity-80 group-hover:opacity-100 transition-all">
                            </div>
                        @endif
                        <div class="relative">
                            <input type="file" name="image" id="img-input" class="hidden" onchange="previewImage(this)">
                            <label for="img-input" class="inline-flex w-full items-center justify-center gap-3 bg-white/5 border border-white/5 hover:border-purple-500/30 px-6 py-4 text-[9px] font-bold uppercase tracking-widest text-gray-500 hover:text-white cursor-pointer transition-all">
                                <i class="fas fa-camera"></i>
                                <span>Swap Visual Data</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Priority</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" class="admin-input w-full px-5 py-4 text-xs text-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Visibility</label>
                            <select name="is_active" class="admin-input w-full px-5 py-4 text-xs text-white appearance-none">
                                <option value="1" {{ $section->is_active ? 'selected' : '' }} class="bg-[#08080f]">On Transmission</option>
                                <option value="0" {{ !$section->is_active ? 'selected' : '' }} class="bg-[#08080f]">Encrypted (Hidden)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-10 border-t border-white/5 flex items-center gap-6">
                <button type="submit" class="admin-btn-primary px-12 py-5 text-[10px] font-black uppercase tracking-[0.2em]">
                    Synchronize Changes
                </button>
                <a href="{{ route('admin.projects.sections', $section->project_id) }}" class="text-[10px] font-black uppercase tracking-widest text-gray-600 hover:text-white transition-all">Abort Action</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        alert("New visual data detected. Sychronize record to apply.");
    }
}
</script>
@endsection
