@extends('layouts.app')

@section('content')
@php $wallpaper = $profile->wallpaper ?? null; @endphp
<div class="page-wrapper {{ $wallpaper ? 'has-wallpaper' : '' }}" @if($wallpaper) style="background-image: url('{{ asset('storage/' . $wallpaper) }}')" @endif>
    {{-- ═══════════════════════════════════════════════════════════
         LEFT PANEL — Projects Hub (Fixed)
         ═══════════════════════════════════════════════════════════ --}}
    <section class="projects-hub">
        {{-- ─── Top: Project Highlight Carousel ─────────────────── --}}
        <div class="section-block best-projects-section">
            <div class="section-header">
                <span class="section-icon"><i class="fas fa-bolt" style="color: white;"></i></span>
                <h2 class="section-title">Best Project</h2>
            </div>
            <p class="section-subtitle">Showcasing projects where UI aesthetics meet user needs and measurable effectiveness.</p>

            <div class="highlight-carousel-wrap">
                <div id="highlight-carousel" class="highlight-carousel">
                    @forelse($bestProjects as $project)
                        <a href="{{ $project->demo_url ?? '#' }}" class="highlight-card" target="_blank" rel="noopener">
                            <div class="highlight-card-img">
                                @if($project->screenshot)
                                    <img src="{{ asset('storage/' . $project->screenshot) }}" alt="{{ $project->title }}">
                                @else
                                    <div class="highlight-card-placeholder">
                                        <span>{{ $project->icon ?? '🚀' }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="highlight-card-info">
                                <h3>{{ $project->title }}</h3>
                                <p>{{ $project->subtitle }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state">No projects yet.</div>
                    @endforelse
                </div>
                @if($bestProjects->count() > 2)
                    <button id="carousel-next" class="carousel-arrow" aria-label="Next project">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>

        {{-- ─── Bottom: Another Project ─────────────────────────── --}}
        <div class="section-block">
            <div class="section-header">
                <span class="section-icon"><i class="fas fa-cube" style="color: white;"></i></span>
                <h2 class="section-title">Another Project</h2>
            </div>
            <p class="section-subtitle">A collection of stories, experiments, and lessons learned.</p>

            <div class="other-projects-grid">
                @forelse($otherProjects->take(4) as $project)
                    <a href="{{ $project->demo_url ?? '#' }}"
                       class="other-project-pill"
                       target="_blank" rel="noopener">
                        <span class="pill-icon" style="background: {{ $project->icon_color ?? '#8b5cf6' }}20;">
                            {{ $project->icon ?? '📁' }}
                        </span>
                        <span>{{ $project->title }}</span>
                    </a>
                @empty
                    <div class="empty-state">No projects yet.</div>
                @endforelse

                @if($otherProjects->count() > 4)
                    <a href="{{ route('projects.all') }}" class="other-project-pill">
                        <span class="pill-icon" style="background: rgba(139,92,246,0.2); border-radius: 0;">
                            <i class="fas fa-th" style="color: white; font-size: 0.75rem;"></i>
                        </span>
                        <span>More</span>
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         RIGHT PANEL — Profile Portal (Scrollable)
         ═══════════════════════════════════════════════════════════ --}}
    <section class="profile-portal">
        <div class="portal-scroll-container" id="portal-scroll">
            
            {{-- 1. Profil --}}
            <div class="portal-section" id="section-0">
                <h2 class="portal-title">Hello, I'm <span class="text-accent">{{ $profile->short_name ?? 'Yohanes' }}</span></h2>
                
                <div class="profile-photo-wrap">
                    @if($profile && $profile->photo)
                        <img src="{{ asset('storage/' . $profile->photo) }}" alt="{{ $profile->name }}">
                    @else
                        <div class="profile-photo-fallback">
                            <span>{{ substr($profile->short_name ?? 'Y', 0, 1) }}</span>
                        </div>
                    @endif
                </div>

                <div class="bio-text">
                    @if($profile && $profile->bio)
                        @foreach(explode("\n\n", $profile->bio) as $i => $paragraph)
                            <p>
                                @if($i === 0 && $profile->quote)
                                    {!! str_replace(
                                        $profile->quote,
                                        '<em class="bio-quote">' . $profile->quote . '</em>',
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

            {{-- 2. Company yang telah berkolaborasi --}}
            <div class="portal-section" id="section-1">
                <h2 class="portal-title">Collaborations</h2>
                <p class="text-gray-500 mb-8">Selected organizations and partners I've had the privilege to work with.</p>
                
                <div class="collab-grid">
                    @forelse($experiences as $exp)
                        <button class="collab-logo-card" onclick='openExpModal({!! json_encode($exp) !!})' aria-label="View {{ $exp->company }} details">
                            @if($exp->logo)
                                <img src="{{ asset('storage/' . $exp->logo) }}" alt="{{ $exp->company }}">
                            @else
                                <div class="collab-logo-placeholder">
                                    <span>{{ substr($exp->company, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="collab-logo-hover">
                                <i class="fas fa-expand-alt"></i>
                            </div>
                        </button>
                    @empty
                        <div class="text-gray-400 italic">No collaborations added yet.</div>
                    @endforelse
                </div>
            </div>

            {{-- 3. Skills & Sertifikasi --}}
            <div class="portal-section" id="section-2">
                <h2 class="portal-title">Skills & Certifications</h2>

                @php $skillCategories = $skills->groupBy('category'); @endphp
                <div class="skills-wrapper">
                    @foreach($skillCategories as $category => $categorySkills)
                        <div class="skill-group">
                            <h4>{{ $category }}</h4>
                            @foreach($categorySkills as $skill)
                                <div class="skill-bar-container">
                                    <div class="skill-label">
                                        <span>{{ $skill->icon }} {{ $skill->name }}</span>
                                        <span>{{ $skill->level }}%</span>
                                    </div>
                                    <div class="skill-track">
                                        <div class="skill-fill" data-level="{{ $skill->level }}"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 4. Contact --}}
            <div class="portal-section" id="section-3">
                <h2 class="portal-title">Contact Information</h2>
                <p class="text-gray-600 mb-6">Have a project in mind or want to collaborate? Feel free to reach out!</p>

                <div class="mb-8">
                    @if($profile && $profile->email)
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="contact-label">Email</div>
                                <div class="contact-value">{{ $profile->email }}</div>
                            </div>
                        </div>
                    @endif
                    @if($profile && $profile->phone)
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-phone"></i></div>
                            <div>
                                <div class="contact-label">Phone</div>
                                <div class="contact-value">{{ $profile->phone }}</div>
                            </div>
                        </div>
                    @endif
                    @if($profile && $profile->location)
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <div class="contact-label">Location</div>
                                <div class="contact-value">{{ $profile->location }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($profile && $profile->email)
                    <a href="mailto:{{ $profile->email }}" class="contact-btn">
                        <span>Send an Email</span>
                        <i class="fas fa-paper-plane"></i>
                    </a>
                @endif
            </div>

        </div>

        {{-- ─── Mini Map ────────────────────────────────────────── --}}
        <nav class="mini-map">
            <button class="map-dot active" data-target="0">
                <span class="dot-indicator"></span>
            </button>
            <button class="map-dot" data-target="1">
                <span class="dot-indicator"></span>
            </button>
            <button class="map-dot" data-target="2">
                <span class="dot-indicator"></span>
            </button>
            <button class="map-dot" data-target="3">
                <span class="dot-indicator"></span>
            </button>
        </nav>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         EXP MODAL
         ═══════════════════════════════════════════════════════════ --}}
    <div id="exp-modal" class="exp-modal-overlay hidden" onclick="closeExpModal()">
        <div class="exp-modal-content" onclick="event.stopPropagation()">
            <button class="exp-modal-close" onclick="closeExpModal()"><i class="fas fa-times"></i></button>
            <div class="exp-modal-body">
                <div class="exp-modal-header">
                    <div class="exp-modal-logo" id="modal-logo-wrap"></div>
                    <div>
                        <h3 id="modal-title" class="text-xl font-bold text-gray-900"></h3>
                        <p id="modal-company" class="text-accent font-bold uppercase tracking-widest text-xs mt-1"></p>
                    </div>
                </div>
                <div class="exp-modal-meta">
                    <div class="meta-item"><i class="fas fa-calendar-alt"></i> <span id="modal-period"></span></div>
                    <div class="meta-item"><i class="fas fa-map-marker-alt"></i> <span id="modal-location"></span></div>
                </div>
                <div class="exp-modal-desc" id="modal-desc"></div>
            </div>
        </div>
    </div>

    <script>
        function openExpModal(exp) {
            const modal = document.getElementById('exp-modal');
            document.getElementById('modal-title').innerText = exp.title;
            document.getElementById('modal-company').innerText = exp.company;
            document.getElementById('modal-period').innerText = exp.period;
            document.getElementById('modal-location').innerText = exp.location || 'Remote';
            document.getElementById('modal-desc').innerText = exp.description || 'No additional details available.';
            
            const logoWrap = document.getElementById('modal-logo-wrap');
            if (exp.logo) {
                logoWrap.innerHTML = `<img src="/storage/${exp.logo}" alt="${exp.company}" class="w-full h-full object-contain p-2">`;
            } else {
                logoWrap.innerHTML = `<div class="w-full h-full bg-accent/10 flex items-center justify-center text-accent text-2xl font-bold">${exp.company[0]}</div>`;
            }

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeExpModal() {
            document.getElementById('exp-modal').classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>
</div>
@endsection
