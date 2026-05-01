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
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">Website Favicon</h4>
                <div class="w-16 h-16 bg-white/5 border border-white/10 relative group mb-6 overflow-hidden mx-auto">
                    @if($profile && $profile->favicon)
                        <img src="{{ asset('storage/' . $profile->favicon) }}" id="favicon-preview" alt="Favicon" class="w-full h-full object-contain p-2">
                    @else
                        <div id="favicon-preview-placeholder" class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-globe text-2xl text-gray-800"></i>
                        </div>
                        <img id="favicon-preview" src="" alt="Favicon" class="w-full h-full object-contain p-2 hidden">
                    @endif
                </div>
                <input type="file" name="favicon" accept=".ico,.png,.svg,.jpg,.jpeg,.webp" id="favicon-input" class="hidden" onchange="previewImage(this, 'favicon-preview', 'favicon-preview-placeholder')">
                <label for="favicon-input" class="admin-btn-primary w-full inline-flex items-center justify-center gap-2 px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white cursor-pointer transition-all">
                    <i class="fas fa-upload"></i>
                    <span>Select Favicon</span>
                </label>
            </div>

            <div class="admin-card p-8">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-10">Dynamic Section Wallpapers</h4>
                
                <div class="space-y-10">
                    @for($i = 1; $i <= 4; $i++)
                    @php $fieldName = "wallpaper_$i"; @endphp
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Section {{ $i }}</label>
                            <span class="text-[8px] font-bold text-purple-600 px-2 py-0.5 bg-purple-500/10 uppercase tracking-tighter">
                                @if($i == 1) Profile @elseif($i == 2) Collab @elseif($i == 3) Certified @else Contact @endif
                            </span>
                        </div>
                        <div id="preview-container-{{ $i }}" class="aspect-video bg-white/5 border border-white/10 relative group mb-3 overflow-hidden">
                            <img src="{{ $profile && $profile->$fieldName ? asset('storage/' . $profile->$fieldName) : '' }}" 
                                 id="preview-{{ $i }}" 
                                 alt="Wallpaper {{ $i }}" 
                                 class="{{ $profile && $profile->$fieldName ? '' : 'hidden' }} w-full h-full object-cover opacity-60">
                            @if(!$profile || !$profile->$fieldName)
                                <div id="placeholder-{{ $i }}" class="absolute inset-0 flex items-center justify-center opacity-20">
                                    <i class="fas fa-image text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="wallpaper_{{ $i }}" accept="image/*" id="wallpaper-{{ $i }}-input" class="hidden" onchange="previewMultiWallpaper(this, {{ $i }})">
                        <label for="wallpaper-{{ $i }}-input" class="inline-flex w-full items-center justify-center gap-2 bg-white/5 border border-white/5 hover:border-purple-500/50 px-4 py-3 text-[9px] font-bold uppercase tracking-widest text-gray-500 hover:text-white cursor-pointer transition-all">
                            <i class="fas fa-plus"></i>
                            <span>Wallpaper {{ $i }}</span>
                        </label>
                    </div>
                    @endfor
                </div>
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

function previewMultiWallpaper(input, index) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-' + index);
            const placeholder = document.getElementById('placeholder-' + index);
            
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
