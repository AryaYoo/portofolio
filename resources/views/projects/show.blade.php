@extends('layouts.app')

@section('title', $project->title . ' - Project Overview')

@section('content')
<style>
    :root { --project-theme: {{ $project->theme_color ?? '#4a5d23' }}; }
</style>
<div class="page-wrapper">
    {{-- Background Image & Gradient Overlay --}}
    <div class="absolute inset-0 z-0 pointer-events-none bg-[#08080f]">
        @if($project->screenshot)
            <img src="{{ asset('storage/' . $project->screenshot) }}" alt="Background" class="w-full h-full object-cover opacity-50">
        @endif
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(8, 8, 15, 0.85) 0%, {{ $project->theme_color ?? '#4a5d23' }}80 100%);"></div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         LEFT PANEL — Project Context (Fixed)
         ═══════════════════════════════════════════════════════════ --}}
    <section class="projects-hub">
        <div class="relative z-10 flex flex-col h-full pl-0">
            {{-- Back Button --}}
            <div class="mb-10">
                <a href="{{ route('portfolio') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 transition-all text-xs text-gray-300 hover:text-white border border-white/10 rounded-none">
                    <i class="fas fa-chevron-left text-[10px]"></i>
                    <span>Back</span>
                </a>
            </div>

            {{-- Project Info --}}
            <div class="section-block mb-12">
                <h1 class="text-[28px] font-bold mb-6 tracking-tight leading-tight">
                    {{ $project->title }} Project Overview
                </h1>
                <p class="text-sm leading-relaxed text-gray-300 max-w-sm">
                    {{ $project->subtitle ?? $project->description }}
                </p>
                <div class="w-full max-w-sm h-px bg-white/20 mt-12 hidden lg:block"></div>
            </div>

            {{-- Another Project --}}
            @if($anotherProject)
                <div class="section-block mt-8 recommendation-section">
                    <h2 class="text-xl font-bold mb-6 tracking-tight">Another Project <i>(Recommendation)</i></h2>
                    
                    <a href="{{ route('projects.show', $anotherProject) }}" class="block max-w-[320px] bg-white/5 backdrop-blur-md border border-white/10 hover:border-purple-500/50 transition-all group overflow-hidden">
                        <div class="h-[180px] w-full relative">
                            @if($anotherProject->screenshot)
                                <img src="{{ asset('storage/' . $anotherProject->screenshot) }}" alt="{{ $anotherProject->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-all duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[#08080f]/50">
                                    <i class="fas fa-image text-2xl text-white/20"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 relative z-10 bg-transparent">
                            <h3 class="font-bold text-sm text-white mb-2">{{ $anotherProject->title }}</h3>
                            <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed">{{ Str::limit($anotherProject->subtitle ?? $anotherProject->description, 70) }}</p>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         RIGHT PANEL — Modular Content (Scrollable)
         ═══════════════════════════════════════════════════════════ --}}
    <section class="profile-portal">
        {{-- Scroll Indicator (Right Side) --}}
        <div class="scroll-indicator" id="scroll-hint">
            <div class="mouse">
                <div class="wheel"></div>
            </div>
            <span class="scroll-text">Scroll</span>
        </div>

        <div class="portal-scroll-container px-4 md:px-12 py-20" id="content-scroll">
            
            <div class="max-w-4xl mx-auto space-y-32">
                @forelse($project->sections as $section)
                    <div class="modular-section" data-aos="fade-up">
                        @switch($section->type)
                            @case('hero')
                                <div class="w-full aspect-video shadow-2xl overflow-hidden mb-12">
                                     @if($section->image)
                                        <img src="{{ asset('storage/' . $section->image) }}" class="w-full h-full object-cover">
                                     @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-image text-5xl text-gray-200"></i>
                                        </div>
                                     @endif
                                </div>
                                @break

                            @case('model1') {{-- Text Left, Image Right --}}
                                <div class="grid md:grid-cols-2 gap-12 items-center">
                                    <div>
                                        <h2 class="text-3xl font-black mb-6 modular-header">{{ $section->title }}</h2>
                                        <div class="text-gray-600 leading-relaxed">
                                            {!! nl2br(e($section->content)) !!}
                                        </div>
                                    </div>
                                    <div class="shadow-xl">
                                        @if($section->image)
                                            <img src="{{ asset('storage/' . $section->image) }}" class="w-full h-auto">
                                        @endif
                                    </div>
                                </div>
                                @break

                            @case('model2') {{-- Image Left, Text Right --}}
                                <div class="grid md:grid-cols-2 gap-12 items-center">
                                    <div class="order-2 md:order-1 shadow-xl">
                                        @if($section->image)
                                            <img src="{{ asset('storage/' . $section->image) }}" class="w-full h-auto">
                                        @endif
                                    </div>
                                    <div class="order-1 md:order-2">
                                        <h2 class="text-3xl font-black mb-6 modular-header">{{ $section->title }}</h2>
                                        <div class="text-gray-600 leading-relaxed">
                                            {!! nl2br(e($section->content)) !!}
                                        </div>
                                    </div>
                                </div>
                                @break

                            @case('model3') {{-- Centered Text --}}
                                <div class="text-center max-w-2xl mx-auto">
                                    <h2 class="text-3xl font-black mb-6 modular-header">{{ $section->title }}</h2>
                                    <div class="text-gray-600 leading-relaxed">
                                        {!! nl2br(e($section->content)) !!}
                                    </div>
                                </div>
                                @break

                            @case('demo')
                                <div class="text-center py-20 border-y border-gray-100">
                                    <h2 class="text-2xl font-black mb-8 modular-header">Try Demo Here !</h2>
                                    @if($project->demo_url)
                                        <a href="{{ $project->demo_url }}" target="_blank" class="inline-block px-10 py-4 text-white font-black uppercase tracking-widest transition-all hover:scale-105" style="background-color: var(--project-theme)">
                                            Demo
                                        </a>
                                    @endif
                                </div>
                                @break
                        @endswitch
                    </div>
                @empty
                    <div class="h-[60vh] flex flex-col items-center justify-center text-center">
                        <i class="fas fa-layer-group text-6xl text-gray-100 mb-8"></i>
                        <p class="text-gray-400 font-bold uppercase tracking-widest">No modular sections found</p>
                    </div>
                @endforelse

                {{-- Footer Area --}}
                <div class="mt-40 mb-20 text-center opacity-20 font-black uppercase tracking-[0.5em] text-[10px] w-full block clear-both footer-area">
                    End of Presentation
                </div>
            </div>
        </div>
    </section>

    {{-- Minimap --}}
    @if($project->sections->count() > 0)
        <nav class="overview-minimap" id="overview-minimap">
            @foreach($project->sections as $idx => $sec)
                <button class="minimap-dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}" title="Section {{ $idx + 1 }}">
                    <span class="minimap-square"></span>
                </button>
            @endforeach
        </nav>
    @endif

    {{-- Scroll To Top Button --}}
    <button id="scroll-top" class="fixed bottom-10 right-10 w-12 h-12 flex items-center justify-center text-white shadow-2xl transition-all translate-y-20 opacity-0 z-[100]" style="background-color: var(--project-theme)">
        <i class="fas fa-chevron-up"></i>
    </button>
</div>

<style>
/* Adjusting Split Layout Overrides */
.page-wrapper {
    display: flex;
    height: 100vh;
    overflow: hidden;
}
@media (min-width: 1025px) {
    .projects-hub {
        flex: 0 0 450px;
        height: 100vh;
        padding: 60px;
        z-index: 10;
        position: relative;
        overflow: hidden;
        color: white;
    }
}
@media (max-width: 1024px) {
    .projects-hub {
        width: 100%;
        height: auto;
        padding: 2.5rem 1.5rem;
        position: relative;
        border: none !important;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: auto;
        color: white;
        background: transparent;
    }
}
.profile-portal {
    flex: 1;
    height: 100vh;
    overflow: hidden;
    position: relative;
    /* Iconic Split Notch */
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%, 0 70%, 50px 65%, 50px 35%, 0 30%);
}
.portal-scroll-container {
    height: 100vh;
    overflow-y: auto;
    scroll-behavior: smooth;
    padding-left: 50px; /* offset for clip-path notch */
}
#scroll-top.visible {
    translate: 0;
    opacity: 1;
}
/* ─── Responsive ───────────────────────────────────────── */
@media (max-width: 1024px) {
    html, body {
        overflow: auto;
        height: auto;
    }
    .page-wrapper { flex-direction: column; height: auto; overflow: visible; }
    .projects-hub { 
        flex: none; 
        width: 100%; 
        padding: 3rem 1.5rem; 
        min-height: auto;
        height: auto;
        justify-content: flex-start;
    }
    .recommendation-section { display: none; }
    .scroll-indicator { display: none; }
    .footer-area { margin-top: 2rem !important; margin-bottom: 1rem !important; }
    .profile-portal { 
        flex: none; 
        width: 100%; 
        height: auto; 
        clip-path: none;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    .portal-scroll-container { 
        height: auto; 
        overflow: visible; 
        padding: 4rem 1.5rem;
    }
}
@media (max-width: 640px) {
    .projects-hub { padding: 2.5rem 1.25rem; }
    .portal-scroll-container { padding: 3rem 1.25rem; }
    .section-block { margin-bottom: 2.5rem; }
    #scroll-top { bottom: 1.5rem; right: 1.5rem; }
}

/* ─── Reveal Animations ───────────────────────────────── */
.modular-section {
    opacity: 0;
    transform: translateY(40px);
    transition: all 1s cubic-bezier(0.2, 0.8, 0.2, 1);
    will-change: transform, opacity;
}
.modular-section.revealed {
    opacity: 1;
    transform: translateY(0);
}

/* ─── Overview Minimap ────────────────────────────────── */
.overview-minimap {
    position: fixed;
    right: 60px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    z-index: 50;
}
.minimap-dot {
    background: transparent;
    border: none;
    padding: 0.375rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    outline: none;
}
.minimap-square {
    width: 0.625rem;
    height: 0.625rem;
    background: #cbd5e1;
    transition: all 0.3s;
}
.minimap-dot:hover .minimap-square {
    background: #94a3b8;
    transform: scale(1.2);
}
.minimap-dot.active .minimap-square {
    background: var(--project-theme, #9333ea);
    transform: scale(1.4);
    box-shadow: 0 0 8px rgba(147, 51, 234, 0.4);
}
@media (max-width: 1024px) {
    .overview-minimap { display: none; }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scrollContainer = document.querySelector('.portal-scroll-container');
        const scrollBtn = document.getElementById('scroll-top');

        scrollContainer.addEventListener('scroll', () => {
            if (scrollContainer.scrollTop > 50) {
                scrollBtn.classList.add('visible');
                document.getElementById('scroll-hint').style.opacity = '0';
                document.getElementById('scroll-hint').style.pointerEvents = 'none';
            } else {
                scrollBtn.classList.remove('visible');
                document.getElementById('scroll-hint').style.opacity = '0.3';
            }
        });

        // ─── Reveal on Scroll ────────────────────────────────
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        }, { 
            threshold: 0.15,
            root: scrollContainer
        });

        document.querySelectorAll('.modular-section').forEach(section => {
            revealObserver.observe(section);
        });

        // ─── Minimap Navigation ──────────────────────────────
        const sections = document.querySelectorAll('.modular-section');
        const minimapDots = document.querySelectorAll('.minimap-dot');

        // Click to scroll
        minimapDots.forEach(dot => {
            dot.addEventListener('click', () => {
                const idx = parseInt(dot.dataset.index);
                if (sections[idx]) {
                    sections[idx].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });

        // Track active section on scroll
        const minimapObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const idx = Array.from(sections).indexOf(entry.target);
                    minimapDots.forEach((d, i) => {
                        d.classList.toggle('active', i === idx);
                    });
                }
            });
        }, {
            threshold: 0.4,
            root: scrollContainer
        });

        sections.forEach(section => {
            minimapObserver.observe(section);
        });

        scrollBtn.addEventListener('click', () => {
            scrollContainer.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection
