@extends('layouts.admin')
@section('title', 'Profile')

@section('content')
<div class="mb-10">
    <h2 class="text-2xl font-black tracking-tight uppercase">Master Identity Control</h2>
    <p class="text-[10px] text-gray-600 uppercase tracking-widest font-bold mt-1">Configure your global presence across all platforms</p>
</div>

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    
    <div class="grid lg:grid-cols-12 gap-8 items-start">
        {{-- Column 1: Visual Assets (Left) --}}
        <div class="lg:col-span-3 space-y-8">
            <div class="admin-card p-8">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">Display Portrait</h4>
                <div class="aspect-square bg-white/5 border border-white/10 relative group mb-6 overflow-hidden">
                    @if($profile && $profile->photo)
                        <img src="{{ asset('storage/' . $profile->photo) }}" id="photo-preview" alt="" class="w-full h-full object-cover">
                    @else
                        <div id="photo-preview-placeholder" class="w-full h-full flex items-center justify-center">
                            <span class="text-5xl font-black text-gray-800">{{ substr($profile->short_name ?? 'Y', 0, 1) }}</span>
                        </div>
                        <img id="photo-preview" src="" alt="" class="w-full h-full object-cover hidden">
                    @endif
                </div>
                <input type="file" name="photo" accept="image/*" id="photo-input" class="hidden" onchange="previewImage(this, 'photo-preview', 'photo-preview-placeholder')">
                <label for="photo-input" class="admin-btn-primary w-full inline-flex items-center justify-center gap-2 px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white cursor-pointer transition-all">
                    <i class="fas fa-upload"></i>
                    <span>Select Portrait</span>
                </label>
            </div>

            <div class="admin-card p-8">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">Workspace Wallpaper</h4>
                <div id="wallpaper-preview-container" class="{{ $profile && $profile->wallpaper ? '' : 'hidden' }} aspect-video relative group mb-6 overflow-hidden">
                    <img src="{{ $profile && $profile->wallpaper ? asset('storage/' . $profile->wallpaper) : '' }}" id="wallpaper-preview" alt="Wallpaper" class="w-full h-full object-cover border border-white/10 opacity-60">
                </div>
                <input type="file" name="wallpaper" accept="image/*" id="wallpaper-input" class="hidden" onchange="previewWallpaper(this)">
                <label for="wallpaper-input" class="inline-flex w-full items-center justify-center gap-2 bg-white/5 border border-white/10 hover:border-purple-500/50 px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-white cursor-pointer transition-all">
                    <i class="fas fa-image"></i>
                    <span>Set Wallpaper</span>
                </label>
            </div>
        </div>

        {{-- Column 2: Core Information (Center) --}}
        <div class="lg:col-span-5 space-y-8">
            <div class="admin-card p-10">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-8">Personal Specifications</h4>
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Full Legal Name</label>
                        <input type="text" name="name" value="{{ old('name', $profile->name ?? '') }}" required
                               class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Short Name</label>
                            <input type="text" name="short_name" value="{{ old('short_name', $profile->short_name ?? '') }}" required
                                   class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Title</label>
                            <input type="text" name="title" value="{{ old('title', $profile->title ?? '') }}" required
                                   class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Location</label>
                        <input type="text" name="location" value="{{ old('location', $profile->location ?? '') }}"
                               class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Professional Bio</label>
                        <textarea name="bio" rows="12" required
                                  class="admin-input w-full px-6 py-4 text-sm text-white placeholder-gray-800 resize-none leading-relaxed">{{ old('bio', $profile->bio ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Column 3: Connections & Action (Right) --}}
        <div class="lg:col-span-4 space-y-8">
            <div class="admin-card p-8">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-8">Contact Nodes</h4>
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Primary Email</label>
                        <input type="email" name="email" value="{{ old('email', $profile->email ?? '') }}"
                               class="admin-input w-full px-5 py-4 text-sm text-white placeholder-gray-800">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Phone Line</label>
                        <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}"
                               class="admin-input w-full px-5 py-4 text-sm text-white placeholder-gray-800">
                    </div>
                </div>
            </div>

            <div class="admin-card p-8">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-8">Digital Footprint</h4>
                <div class="grid grid-cols-1 gap-4">
                    @php $socialLinks = $profile->social_links ?? []; @endphp
                    @foreach(['linkedin', 'github', 'dribbble', 'instagram', 'twitter'] as $platform)
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/5 flex items-center justify-center border-y border-l border-white/10">
                                <i class="fab fa-{{ $platform }} text-gray-600 text-xs"></i>
                            </div>
                            <input type="url" name="social_links[{{ $platform }}]" value="{{ $socialLinks[$platform] ?? '' }}" 
                                   placeholder="{{ $platform }} URL"
                                   class="admin-input flex-1 px-4 py-3.5 text-[10px] text-white placeholder-gray-800">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="admin-card p-8 bg-purple-600/5 border-purple-500/20">
                <h4 class="text-[10px] font-bold text-purple-400 uppercase tracking-widest mb-4">Finalize Configuration</h4>
                <p class="text-[10px] text-gray-600 mb-8 leading-relaxed italic">Changes will be synchronized across all public gateway modules immediately after deployment.</p>
                <button type="submit" class="admin-btn-primary w-full py-5 text-[10px] font-black uppercase tracking-[0.2em] shadow-[0_0_30px_rgba(147,51,234,0.3)]">
                    Synchronize Master Node
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewImage(input, previewId, placeholderId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function previewWallpaper(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('wallpaper-preview');
            const container = document.getElementById('wallpaper-preview-container');
            
            preview.src = e.target.result;
            container.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
