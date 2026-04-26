@extends('layouts.admin')
@section('title', $project->exists ? 'Edit Project' : 'New Project')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.projects') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors mb-6">
        <i class="fas fa-arrow-left text-xs"></i>
        <span>Back to Projects</span>
    </a>

    <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-8">
        <form action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($project->exists) @method('PUT') @endif

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Category *</label>
                    <select name="category" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                        <option value="best" {{ old('category', $project->category) === 'best' ? 'selected' : '' }}>Best Project</option>
                        <option value="other" {{ old('category', $project->category) === 'other' ? 'selected' : '' }}>Other Project</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $project->subtitle) }}"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Description</label>
                <textarea name="description" rows="4"
                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm resize-none">{{ old('description', $project->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Screenshot</label>
                @if($project->screenshot)
                    <div class="mb-3 relative inline-block">
                        <img src="{{ asset('storage/' . $project->screenshot) }}" alt="" class="h-24 rounded-lg border border-white/10">
                    </div>
                @endif
                <input type="file" name="screenshot" accept="image/*"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-purple-600 file:text-white file:text-xs file:font-medium text-sm">
            </div>

            <div class="grid sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Icon (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $project->icon) }}" placeholder="🚀"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Icon Color</label>
                    <input type="text" name="icon_color" value="{{ old('icon_color', $project->icon_color) }}" placeholder="#8b5cf6"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Demo URL</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url', $project->demo_url) }}" placeholder="https://"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Repo URL</label>
                    <input type="url" name="repo_url" value="{{ old('repo_url', $project->repo_url) }}" placeholder="https://"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded bg-white/5 border-white/20 text-purple-600 focus:ring-purple-500/50">
                    <span class="text-sm text-gray-400">Active</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-white/5">
                <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-xl font-medium transition-all duration-300 text-sm">
                    {{ $project->exists ? 'Update Project' : 'Create Project' }}
                </button>
                <a href="{{ route('admin.projects') }}" class="text-gray-400 hover:text-white px-4 py-3 text-sm transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
