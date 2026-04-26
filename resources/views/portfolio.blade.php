@extends('layouts.app')

@section('content')
{{-- ═══════════════════════════════════════════════════════════════
     NAVIGATION DOTS (Fixed Right Side)
     ═══════════════════════════════════════════════════════════════ --}}
<nav id="nav-dots" class="fixed right-6 top-1/2 -translate-y-1/2 z-50 flex flex-col gap-3">
    <a href="#hero" class="nav-dot active" data-section="hero" aria-label="Hero">
        <span class="w-3 h-3 rounded-full bg-white/30 block transition-all duration-300"></span>
    </a>
    <a href="#projects" class="nav-dot" data-section="projects" aria-label="Projects">
        <span class="w-3 h-3 rounded-full bg-white/30 block transition-all duration-300"></span>
    </a>
    <a href="#skills" class="nav-dot" data-section="skills" aria-label="Skills">
        <span class="w-3 h-3 rounded-full bg-white/30 block transition-all duration-300"></span>
    </a>
    <a href="#experience" class="nav-dot" data-section="experience" aria-label="Experience">
        <span class="w-3 h-3 rounded-full bg-white/30 block transition-all duration-300"></span>
    </a>
    <a href="#contact" class="nav-dot" data-section="contact" aria-label="Contact">
        <span class="w-3 h-3 rounded-full bg-white/30 block transition-all duration-300"></span>
    </a>
</nav>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 1: HERO
     ═══════════════════════════════════════════════════════════════ --}}
<section id="hero" class="relative min-h-screen flex items-center overflow-hidden">
    {{-- Animated Background --}}
    <div class="absolute inset-0 hero-bg">
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-purple-600/20 rounded-full blur-[128px] animate-pulse-slow"></div>
        <div class="absolute bottom-1/4 right-0 w-80 h-80 bg-violet-500/15 rounded-full blur-[100px] animate-pulse-slow" style="animation-delay: 2s"></div>
        <div class="absolute top-0 left-1/2 w-64 h-64 bg-indigo-600/10 rounded-full blur-[80px] animate-float"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-8 w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-5 py-2 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-sm text-gray-300">Available for work</span>
                </div>

                <div>
                    <p class="text-lg text-purple-400 font-medium mb-3 tracking-wide">Hello, I'm</p>
                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                        <span class="text-white">{{ $profile->short_name ?? 'Yohanes' }}</span>
                    </h1>
                    <p class="text-2xl lg:text-3xl text-gray-400 mt-3 font-light">{{ $profile->title ?? 'UI/UX Designer' }}</p>
                </div>

                <p class="text-gray-400 text-lg leading-relaxed max-w-lg">
                    A tech-savvy designer who believes that
                    <em class="text-purple-400 font-medium not-italic">great design is the result of empathy executed with clear purpose.</em>
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#projects" class="group inline-flex items-center gap-3 bg-purple-600 hover:bg-purple-500 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-purple-600/25 hover:-translate-y-0.5">
                        <span>View Projects</span>
                        <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
                    </a>
                    <a href="#contact" class="inline-flex items-center gap-3 border border-white/20 hover:border-purple-500/50 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:bg-white/5">
                        <span>Get In Touch</span>
                    </a>
                </div>

                {{-- Social Links --}}
                <div class="flex gap-4 pt-4">
                    @if($profile && $profile->social_links)
                        @foreach($profile->social_links as $platform => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener"
                               class="w-11 h-11 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-purple-400 hover:border-purple-500/50 hover:bg-purple-500/10 transition-all duration-300">
                                <i class="fab fa-{{ $platform }}"></i>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Hero Visual --}}
            <div class="hidden lg:flex justify-center items-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/30 to-violet-600/30 rounded-full blur-[60px]"></div>
                    <div class="relative w-80 h-80 rounded-full overflow-hidden border-4 border-purple-500/30 shadow-2xl shadow-purple-500/20">
                        @if($profile && $profile->photo)
                            <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $profile->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-600 to-violet-700 flex items-center justify-center">
                                <span class="text-7xl font-bold text-white/80">{{ substr($profile->short_name ?? 'Y', 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    {{-- Decorative orbiting dots --}}
                    <div class="absolute -top-4 -right-4 w-8 h-8 bg-purple-500 rounded-full animate-float opacity-60"></div>
                    <div class="absolute -bottom-2 -left-6 w-5 h-5 bg-cyan-400 rounded-full animate-float opacity-50" style="animation-delay: 1.5s"></div>
                    <div class="absolute top-1/2 -right-8 w-4 h-4 bg-violet-400 rounded-full animate-float opacity-40" style="animation-delay: 3s"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce-slow">
        <span class="text-xs text-gray-500 tracking-widest uppercase">Scroll</span>
        <div class="w-6 h-10 border-2 border-white/20 rounded-full flex justify-center pt-2">
            <div class="w-1.5 h-3 bg-purple-500 rounded-full animate-scroll-dot"></div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 2: PROJECTS + ABOUT (Split Layout as in Design)
     ═══════════════════════════════════════════════════════════════ --}}
<section id="projects" class="relative min-h-screen py-20">
    {{-- Purple gradient bg - left side --}}
    <div class="absolute inset-y-0 left-0 w-2/3 bg-gradient-to-br from-purple-950/40 via-[#0d0b1a] to-transparent"></div>
    <div class="absolute top-0 left-0 w-1/2 h-full bg-gradient-to-r from-purple-900/20 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-8">
        <div class="grid lg:grid-cols-5 gap-12">
            {{-- Left Column: Projects (3/5 width) --}}
            <div class="lg:col-span-3 space-y-16">
                {{-- Best Projects --}}
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-xl">⚡</span>
                        <h2 class="text-2xl font-bold font-['Playfair_Display']">Best Project</h2>
                    </div>
                    <p class="text-gray-400 text-sm mb-8">Showcasing projects where UI aesthetics meet user needs and measurable effectiveness.</p>

                    {{-- Project Carousel --}}
                    <div class="relative">
                        <div id="project-carousel" class="flex gap-5 overflow-x-auto snap-x snap-mandatory scrollbar-hide pb-4" style="scroll-behavior: smooth;">
                            @forelse($bestProjects as $project)
                                <div class="project-card flex-none w-[260px] snap-start bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden group hover:border-purple-500/30 transition-all duration-500 hover:-translate-y-1">
                                    <div class="h-40 overflow-hidden bg-gradient-to-br from-gray-800 to-gray-900 relative">
                                        @if($project->screenshot)
                                            <img src="{{ asset('storage/' . $project->screenshot) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-900/50 to-violet-900/50">
                                                <span class="text-4xl">{{ $project->icon ?? '🚀' }}</span>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                    <div class="p-5">
                                        <h3 class="font-bold text-white text-lg mb-1">{{ $project->title }}</h3>
                                        <p class="text-gray-400 text-sm leading-relaxed line-clamp-2">{{ $project->subtitle }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No projects yet.</p>
                            @endforelse
                        </div>

                        {{-- Carousel Arrow --}}
                        @if($bestProjects->count() > 2)
                            <button id="carousel-next" class="absolute -right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white hover:bg-purple-600 hover:border-purple-500 transition-all duration-300 z-10">
                                <i class="fas fa-chevron-right text-sm"></i>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Another Projects --}}
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-xl">⚙️</span>
                        <h2 class="text-2xl font-bold font-['Playfair_Display']">Another Project</h2>
                    </div>
                    <p class="text-gray-400 text-sm mb-6">A collection of stories, experiments, and lessons learned.</p>

                    <div class="flex flex-wrap gap-3">
                        @forelse($otherProjects as $project)
                            <a href="{{ $project->demo_url ?? '#' }}"
                               class="inline-flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-sm text-white hover:bg-purple-600/20 hover:border-purple-500/30 transition-all duration-300 group"
                               style="--icon-color: {{ $project->icon_color ?? '#8b5cf6' }}">
                                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-base" style="background: {{ $project->icon_color ?? '#8b5cf6' }}20;">
                                    {{ $project->icon ?? '📁' }}
                                </span>
                                <span class="font-medium">{{ $project->title }}</span>
                            </a>
                        @empty
                            <p class="text-gray-500">No projects yet.</p>
                        @endforelse

                        <a href="#" class="inline-flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-sm text-white hover:bg-purple-600/20 hover:border-purple-500/30 transition-all duration-300">
                            <span class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                                <i class="fas fa-th text-purple-400 text-xs"></i>
                            </span>
                            <span class="font-medium">More</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Column: About (2/5 width) --}}
            <div class="lg:col-span-2">
                <div class="sticky top-20">
                    <h2 class="text-2xl font-bold font-['Playfair_Display'] mb-8">
                        About <span class="text-purple-400">{{ $profile->short_name ?? 'Yohanes' }}</span>
                    </h2>

                    {{-- Profile Photo --}}
                    <div class="flex justify-center mb-8">
                        <div class="relative">
                            <div class="w-52 h-52 rounded-2xl overflow-hidden border-2 border-cyan-400/40 shadow-xl shadow-cyan-500/10 rotate-1 hover:rotate-0 transition-transform duration-500">
                                @if($profile && $profile->photo)
                                    <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $profile->name }}" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-purple-600 to-violet-700 flex items-center justify-center">
                                        <span class="text-6xl font-bold text-white/80">{{ substr($profile->short_name ?? 'Y', 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            {{-- Decorative corner dots --}}
                            <div class="absolute -top-2 -right-2 w-4 h-4 bg-purple-500 rounded-full"></div>
                            <div class="absolute -bottom-2 -left-2 w-3 h-3 bg-cyan-400 rounded-full"></div>
                        </div>
                    </div>

                    {{-- Bio --}}
                    <div class="text-center space-y-4">
                        @if($profile && $profile->bio)
                            @foreach(explode("\n\n", $profile->bio) as $i => $paragraph)
                                <p class="text-gray-300 text-sm leading-relaxed">
                                    @if($i === 0 && $profile->quote)
                                        {!! str_replace(
                                            $profile->quote,
                                            '<em class="text-purple-400 italic font-medium">' . $profile->quote . '</em>',
                                            e($paragraph)
                                        ) !!}
                                    @else
                                        {{ $paragraph }}
                                    @endif
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 3: SKILLS
     ═══════════════════════════════════════════════════════════════ --}}
<section id="skills" class="relative py-24 overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600/10 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-violet-500/10 rounded-full blur-[100px]"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 text-purple-400 text-sm font-medium tracking-widest uppercase mb-4">
                <span class="w-8 h-px bg-purple-500"></span>
                What I Do
                <span class="w-8 h-px bg-purple-500"></span>
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold font-['Playfair_Display']">Skills & Expertise</h2>
        </div>

        @php
            $skillCategories = $skills->groupBy('category');
        @endphp

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($skillCategories as $category => $categorySkills)
                <div class="bg-white/[0.03] backdrop-blur-sm border border-white/10 rounded-2xl p-8 hover:border-purple-500/30 transition-all duration-500 group">
                    <h3 class="text-lg font-semibold text-purple-400 mb-6">{{ $category }}</h3>
                    <div class="space-y-5">
                        @foreach($categorySkills as $skill)
                            <div class="skill-item">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-base">{{ $skill->icon }}</span>
                                        <span class="text-sm text-gray-300 font-medium">{{ $skill->name }}</span>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $skill->level }}%</span>
                                </div>
                                <div class="h-1.5 bg-white/5 rounded-full overflow-hidden">
                                    <div class="skill-bar h-full bg-gradient-to-r from-purple-600 to-violet-500 rounded-full transition-all duration-1000 ease-out" data-level="{{ $skill->level }}" style="width: 0%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 4: EXPERIENCE
     ═══════════════════════════════════════════════════════════════ --}}
<section id="experience" class="relative py-24">
    <div class="relative z-10 max-w-4xl mx-auto px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 text-purple-400 text-sm font-medium tracking-widest uppercase mb-4">
                <span class="w-8 h-px bg-purple-500"></span>
                Journey
                <span class="w-8 h-px bg-purple-500"></span>
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold font-['Playfair_Display']">Experience</h2>
        </div>

        {{-- Timeline --}}
        <div class="relative">
            <div class="absolute left-8 top-0 bottom-0 w-px bg-gradient-to-b from-purple-600 via-purple-500/50 to-transparent"></div>

            <div class="space-y-12">
                @forelse($experiences as $exp)
                    <div class="relative pl-20 group">
                        {{-- Timeline dot --}}
                        <div class="absolute left-6 top-1 w-5 h-5 rounded-full bg-[#08080f] border-2 border-purple-500 group-hover:bg-purple-500 transition-all duration-300">
                            <div class="absolute inset-0 rounded-full bg-purple-500/30 animate-ping opacity-0 group-hover:opacity-100"></div>
                        </div>

                        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6 hover:border-purple-500/30 transition-all duration-500 hover:-translate-y-0.5">
                            <span class="text-xs text-purple-400 font-medium tracking-wider uppercase">{{ $exp->period }}</span>
                            <h3 class="text-xl font-bold mt-2">{{ $exp->title }}</h3>
                            <p class="text-gray-400 text-sm mt-1">{{ $exp->company }} @if($exp->location)· {{ $exp->location }}@endif</p>
                            @if($exp->description)
                                <p class="text-gray-500 text-sm mt-3 leading-relaxed">{{ $exp->description }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">No experience added yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 5: CONTACT
     ═══════════════════════════════════════════════════════════════ --}}
<section id="contact" class="relative py-24 overflow-hidden">
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-purple-600/10 rounded-full blur-[150px]"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-8">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 text-purple-400 text-sm font-medium tracking-widest uppercase mb-4">
                <span class="w-8 h-px bg-purple-500"></span>
                Say Hello
                <span class="w-8 h-px bg-purple-500"></span>
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold font-['Playfair_Display']">Get In Touch</h2>
            <p class="text-gray-400 mt-4 max-w-lg mx-auto">Have a project in mind or want to collaborate? Feel free to reach out!</p>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-500/10 border border-green-500/30 rounded-xl px-6 py-4 text-green-400 text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-5 gap-10">
            {{-- Contact Info --}}
            <div class="md:col-span-2 space-y-6">
                @if($profile && $profile->email)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center flex-none">
                            <i class="fas fa-envelope text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Email</p>
                            <p class="text-gray-300 mt-1">{{ $profile->email }}</p>
                        </div>
                    </div>
                @endif

                @if($profile && $profile->phone)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center flex-none">
                            <i class="fas fa-phone text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Phone</p>
                            <p class="text-gray-300 mt-1">{{ $profile->phone }}</p>
                        </div>
                    </div>
                @endif

                @if($profile && $profile->location)
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center flex-none">
                            <i class="fas fa-map-marker-alt text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Location</p>
                            <p class="text-gray-300 mt-1">{{ $profile->location }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Contact Form --}}
            <form action="{{ route('contact.send') }}" method="POST" class="md:col-span-3 space-y-5">
                @csrf
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <input type="text" name="name" placeholder="Your Name" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Your Email" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <input type="text" name="subject" placeholder="Subject"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm">
                </div>
                <div>
                    <textarea name="message" placeholder="Your Message" rows="5" required
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-white placeholder-gray-500 focus:border-purple-500 focus:ring-1 focus:ring-purple-500/50 outline-none transition-all duration-300 text-sm resize-none"></textarea>
                    @error('message') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                        class="w-full bg-purple-600 hover:bg-purple-500 text-white py-4 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-purple-600/25 hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <span>Send Message</span>
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     FOOTER
     ═══════════════════════════════════════════════════════════════ --}}
<footer class="border-t border-white/5 py-8 text-center">
    <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} {{ $profile->short_name ?? 'Yohanes' }}. All rights reserved.</p>
</footer>
@endsection
