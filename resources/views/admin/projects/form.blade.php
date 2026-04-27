@extends('layouts.admin')
@section('title', $project->exists ? 'Edit Project' : 'New Project')

@section('content')
<div class="mb-10">
    <a href="{{ route('admin.projects') }}" class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 hover:text-purple-500 transition-all mb-8">
        <i class="fas fa-long-arrow-alt-left"></i>
        <span>Return to Collections</span>
    </a>
    <h2 class="text-2xl font-black tracking-tight uppercase">{{ $project->exists ? 'Edit Asset' : 'New Collection' }}</h2>
    <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Configure project specifications and resources</p>
</div>

<div class="max-w-4xl">
    <div class="admin-card p-10">
        <form action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @if($project->exists) @method('PUT') @endif

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Project Identifier</label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}" required placeholder="e.g. Quantum Interface"
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Classification</label>
                    <select name="category" required
                            class="admin-input w-full px-6 py-4 text-sm text-white focus:bg-white/[0.07] appearance-none cursor-pointer">
                        <option value="best" {{ old('category', $project->category) === 'best' ? 'selected' : '' }} class="bg-[#08080f]">Best Project (Highlight)</option>
                        <option value="other" {{ old('category', $project->category) === 'other' ? 'selected' : '' }} class="bg-[#08080f]">Other Project (Archive)</option>
                    </select>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Project Metadata (Subtitle)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $project->subtitle) }}" placeholder="e.g. Next.js / Tailwind / Framer"
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Overview Theme Color (HEX)</label>
                    <div class="flex gap-4">
                        <input type="text" name="theme_color" value="{{ old('theme_color', $project->theme_color ?? '#4a5d23') }}" placeholder="#4a5d23"
                               class="admin-input flex-1 px-6 py-4 text-sm text-white placeholder-gray-800">
                        <input type="color" value="{{ old('theme_color', $project->theme_color ?? '#4a5d23') }}" 
                               oninput="this.previousElementSibling.value = this.value"
                               class="w-14 h-14 bg-white/5 border border-white/10 cursor-pointer p-1">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Project Narrative</label>
                <textarea name="description" rows="6" placeholder="Document the project scope and achievements..."
                          class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800 resize-none leading-relaxed">{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="grid md:grid-cols-2 gap-10 pb-10 border-b border-white/5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-4">Visual Screenshot</label>
                    <div id="preview-container" class="{{ $project->screenshot ? '' : 'hidden' }} mb-6 relative group inline-block overflow-hidden">
                        <img src="{{ $project->screenshot ? asset('storage/' . $project->screenshot) : '' }}" 
                             id="screenshot-preview" 
                             alt="Preview" 
                             class="h-32 border border-white/10 opacity-80 group-hover:opacity-100 transition-all">
                    </div>
                    <div class="relative">
                        <input type="file" name="screenshot" accept="image/*" id="screenshot-input" class="hidden" onchange="previewScreenshot(this)">
                        <label for="screenshot-input" class="inline-flex items-center gap-3 bg-white/5 border border-white/10 hover:border-purple-500/50 px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-white cursor-pointer transition-all">
                            <i class="fas fa-camera"></i>
                            <span>Upload Capture</span>
                        </label>
                    </div>
                </div>
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Display Priority</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}"
                               class="admin-input w-full px-5 py-4 text-sm text-white placeholder-gray-800">
                        <p class="text-[9px] text-gray-700 mt-2">Higher numbers appear first</p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Live Environment (Demo)</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url', $project->demo_url) }}" placeholder="https://demo.example.com"
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Source Repository</label>
                    <input type="url" name="repo_url" value="{{ old('repo_url', $project->repo_url) }}" placeholder="https://github.com/..."
                           class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                </div>
            </div>

            <div class="flex items-center gap-4 py-4">
                <div class="relative inline-flex items-center cursor-pointer group">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }}
                           class="peer hidden">
                    <div class="w-5 h-5 border border-white/10 group-hover:border-purple-500/50 peer-checked:bg-purple-600 peer-checked:border-purple-600 transition-all"></div>
                    <i class="fas fa-check absolute inset-0 text-[10px] text-white flex items-center justify-center scale-0 peer-checked:scale-100 transition-all"></i>
                    <label for="is_active" class="ml-4 text-[10px] font-bold text-gray-600 uppercase tracking-widest cursor-pointer peer-checked:text-white transition-all">Public Accessibility</label>
                </div>
            </div>

            <div class="flex items-center gap-6 pt-10 border-t border-white/5">
                <button type="submit" class="admin-btn-primary px-12 py-5 text-[10px] font-black uppercase tracking-[0.2em]">
                    {{ $project->exists ? 'Synchronize Record' : 'Initialize Asset' }}
                </button>
                <a href="{{ route('admin.projects') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-600 hover:text-white transition-all">Abort Action</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewScreenshot(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('screenshot-preview');
            const container = document.getElementById('preview-container');
            
            preview.src = e.target.result;
            container.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
