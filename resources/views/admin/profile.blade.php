@extends('layouts.admin')
@section('title', 'Profile')

@section('content')
<div class="max-w-2xl">
    <p class="text-gray-500 text-sm mb-6">Manage your portfolio profile information</p>

    <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-8">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            {{-- Photo --}}
            <div class="flex items-center gap-6 pb-6 border-b border-white/5">
                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-purple-500/10 flex items-center justify-center flex-none border border-white/10">
                    @if($profile && $profile->photo)
                        <img src="{{ asset('storage/' . $profile->photo) }}" alt="" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl">{{ substr($profile->short_name ?? 'Y', 0, 1) }}</span>
                    @endif
                </div>
                <div>
                    <input type="file" name="photo" accept="image/*" id="photo-input" class="hidden">
                    <label for="photo-input" class="inline-flex items-center gap-2 bg-white/5 border border-white/10 hover:border-purple-500/30 px-4 py-2 rounded-xl text-sm text-gray-400 cursor-pointer transition-all duration-200">
                        <i class="fas fa-camera text-xs"></i>
                        <span>Change Photo</span>
                    </label>
                    <p class="text-[10px] text-gray-600 mt-1">JPG, PNG or WEBP. Max 2MB.</p>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $profile->name ?? '') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Short Name *</label>
                    <input type="text" name="short_name" value="{{ old('short_name', $profile->short_name ?? '') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Title *</label>
                <input type="text" name="title" value="{{ old('title', $profile->title ?? '') }}" required placeholder="e.g. UI/UX Designer"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Bio *</label>
                <textarea name="bio" rows="5" required
                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm resize-none">{{ old('bio', $profile->bio ?? '') }}</textarea>
                <p class="text-[10px] text-gray-600 mt-1">Separate paragraphs with empty lines.</p>
            </div>

            <div>
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Quote</label>
                <input type="text" name="quote" value="{{ old('quote', $profile->quote ?? '') }}" placeholder="A highlighted quote from your bio"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
            </div>

            <div class="grid sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email', $profile->email ?? '') }}"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase tracking-wider mb-2 font-medium">Location</label>
                    <input type="text" name="location" value="{{ old('location', $profile->location ?? '') }}"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
            </div>

            {{-- Social Links --}}
            <div>
                <label class="block text-xs text-gray-500 uppercase tracking-wider mb-3 font-medium">Social Links</label>
                <div class="space-y-3">
                    @php $socialLinks = $profile->social_links ?? []; @endphp
                    @foreach(['linkedin', 'github', 'dribbble', 'instagram', 'twitter'] as $platform)
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center flex-none">
                                <i class="fab fa-{{ $platform }} text-gray-500 text-sm"></i>
                            </div>
                            <input type="url" name="social_links[{{ $platform }}]" value="{{ $socialLinks[$platform] ?? '' }}" placeholder="https://{{ $platform }}.com/..."
                                   class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-gray-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 border-t border-white/5">
                <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-xl font-medium transition-all duration-300 text-sm">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
