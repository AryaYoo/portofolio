@extends('layouts.app')

@section('content')
<style>
    :root { --project-theme: {{ $profile->theme_color ?? '#a855f7' }}; }
</style>
<div class="page-wrapper">
    {{-- Dynamic Background Layers --}}
    <div class="wallpapers-container">
        @for($i = 1; $i <= 4; $i++)
            @php $fieldName = "wallpaper_$i"; $wall = $profile->$fieldName ?? null; @endphp
            <div id="bg-layer-{{ $i }}" 
                 class="wallpaper-layer {{ $i == 1 ? 'active' : '' }}" 
                 @if($wall) style="background-image: url('{{ asset('storage/' . $wall) }}')" @endif>
            </div>
        @endfor
        <div class="wallpaper-overlay"></div>
    </div>
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
                        <a href="{{ route('projects.show', $project) }}" class="highlight-card">
                            <div class="highlight-card-img">
                                @if($project->screenshot)
                                    <img src="{{ asset('storage/' . $project->screenshot) }}" alt="{{ $project->title }}">
                                @else
                                    <div class="highlight-card-placeholder">
                                        <i class="fas fa-image text-3xl opacity-20"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="highlight-card-info">
                                <h3>{{ $project->title }}</h3>
                                <p>{{ $project->subtitle }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state"></div>
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
                    <a href="{{ route('projects.show', $project) }}"
                       class="other-project-pill">
                        <span class="pill-icon">
                            <i class="fas fa-folder"></i>
                        </span>
                        <span>{{ $project->title }}</span>
                    </a>
                @empty
                    <div class="empty-state"></div>
                @endforelse

                @if($otherProjects->count() > 4)
                    <a href="{{ route('projects.all') }}" class="other-project-pill">
                        <span class="pill-icon" style="background: rgba(139,92,246,0.2); border-radius: 0;">
                            <i class="fas fa-th-large" style="color: white; font-size: 0.75rem;"></i>
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
        {{-- Floating Mobile Swipe Hint --}}
        <div class="mobile-swipe-hint" id="mobile-swipe-hint">
            <div class="swipe-hand">
                <i class="fas fa-chevron-right"></i>
            </div>
            <span>Swipe Profile</span>
        </div>

        {{-- Mini Map --}}
        <div class="mini-map">
        </div>

        {{-- Mobile Horizontal Dots (Top) --}}
        <div class="mobile-dots-nav" id="mobile-dots">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>

        {{-- Scroll Indicator (Right Side) --}}
        <div class="scroll-indicator" id="scroll-hint">
            <div class="mouse">
                <div class="wheel"></div>
            </div>
            <span class="scroll-text">Scroll</span>
        </div>

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
                <h2 class="portal-title">Experience</h2>
                <p class="text-gray-500 mb-8">Companies that have collaborated with me.</p>
                
                @if($experiences->isNotEmpty())
                    <div class="collab-grid">
                        @foreach($experiences as $exp)
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
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-handshake-slash opacity-20 text-4xl mb-4 block"></i>
                        <p class="text-gray-400 italic">No collaborations added yet.</p>
                    </div>
                @endif
            </div>

            {{-- 3. Skills & Certifications --}}
            <div class="portal-section" id="section-2">
                <h2 class="portal-title">Skills & Certifications</h2>
                <p class="text-gray-500 mb-8">Verified expertise and professional certifications.</p>

                @if($skills->isNotEmpty())
                    <div class="cert-grid">
                        @foreach($skills as $skill)
                            <button class="cert-card" onclick='openCertModal({!! json_encode($skill) !!})' aria-label="View {{ $skill->name }} details">
                                @if($skill->image)
                                    <img src="{{ asset('storage/' . $skill->image) }}" alt="{{ $skill->name }}">
                                @else
                                    <div class="cert-card-placeholder">
                                        <span>{{ $skill->icon ?? '📜' }}</span>
                                    </div>
                                @endif
                                <div class="cert-card-hover">
                                    <i class="fas fa-expand-alt"></i>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-certificate opacity-20 text-4xl mb-4 block"></i>
                        <p class="text-gray-400 italic">No certifications added yet.</p>
                    </div>
                @endif
            </div>

            {{-- 4. Contact --}}
            <div class="portal-section" id="section-3">
                <h2 class="portal-title">Contact & Information</h2>
                <p class="text-gray-500 mb-10">Have a project in mind? Reach out via message or follow my digital journey.</p>

                {{-- Contact Form --}}
                <form action="{{ route('contact.send') }}" method="POST" class="contact-form w-full max-w-md mx-auto mb-12">
                    @csrf
                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-4 mb-6 text-sm font-bold uppercase tracking-widest border-l-4 border-green-500">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="space-y-4">
                        <input type="text" name="name" placeholder="YOUR NAME" required class="contact-input">
                        <input type="email" name="email" placeholder="YOUR EMAIL" required class="contact-input">
                        <textarea name="message" rows="4" placeholder="HOW CAN I HELP?" required class="contact-input resize-none"></textarea>
                        <button type="submit" class="contact-submit-btn">
                            SEND MESSAGE
                        </button>
                    </div>
                </form>

                {{-- Social Media --}}
                <div class="social-wrapper">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Digital Ecosystem</p>
                    <div class="social-box-grid">
                        @php $socials = $profile->social_links ?? []; @endphp
                        @foreach(['github', 'linkedin', 'dribbble', 'instagram', 'twitter'] as $platform)
                            @if(!empty($socials[$platform]))
                                <a href="{{ $socials[$platform] }}" target="_blank" rel="noopener" class="social-icon-box" title="{{ ucfirst($platform) }}">
                                    <i class="fab fa-{{ $platform }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
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
                        <p id="modal-company" class="text-purple-600 font-bold uppercase tracking-widest text-xs mt-1"></p>
                    </div>
                </div>
                <div class="exp-modal-meta">
                    <div class="meta-item"><i class="fas fa-calendar-alt"></i> <span id="modal-period"></span></div>
                    <div class="meta-item"><i class="fas fa-map-marker-alt"></i> <span id="modal-location"></span></div>
                </div>
                <div class="exp-modal-desc text-gray-600" id="modal-desc" style="white-space: pre-line;"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         CERT MODAL
         ═══════════════════════════════════════════════════════════ --}}
    <div id="cert-modal" class="exp-modal-overlay hidden" onclick="closeCertModal()">
        <div class="exp-modal-content" style="max-width: 520px;" onclick="event.stopPropagation()">
            <button class="exp-modal-close" onclick="closeCertModal()"><i class="fas fa-times"></i></button>
            <div id="cert-modal-img" class="cert-modal-image"></div>
            <div class="exp-modal-body">
                <h3 id="cert-modal-title" class="text-xl font-bold text-gray-900 mb-1"></h3>
                <p id="cert-modal-category" class="text-xs font-bold text-purple-600 uppercase tracking-widest mb-4"></p>
                <p id="cert-modal-desc" class="text-gray-500 text-sm leading-relaxed mb-5"></p>
                <div id="cert-modal-tags" class="flex flex-wrap gap-2"></div>
            </div>
        </div>
    </div>

    <script>
        // ─── Slider Dots & Minimap ────────────────────────
        const portalScroll = document.getElementById('portal-scroll');
        const mobileDots = document.querySelectorAll('#mobile-dots .dot');
        const desktopDots = document.querySelectorAll('.mini-map .map-dot');
        const swipeHint = document.getElementById('mobile-swipe-hint');
        const scrollHint = document.getElementById('scroll-hint');

        if (portalScroll) {
            const handleScroll = () => {
                const isMobile = window.innerWidth <= 1024;
                const verticalScroll = window.scrollY;
                const horizontalScroll = isMobile ? portalScroll.scrollLeft : portalScroll.scrollTop;
                const width = portalScroll.offsetWidth || window.innerWidth;
                const height = portalScroll.offsetHeight || window.innerHeight;
                
                // Calculate active index
                const activeIdx = isMobile ? Math.round(horizontalScroll / width) : Math.round(horizontalScroll / height);

                // ─── Dynamic Drift ───
                const driftX = Math.sin(verticalScroll * 0.001 + horizontalScroll * 0.002) * 45;
                const driftY = Math.cos(verticalScroll * 0.0008 + horizontalScroll * 0.0005) * 35;

                document.querySelectorAll('.wallpaper-layer').forEach((layer, idx) => {
                    layer.classList.toggle('active', idx === activeIdx);
                    const depth = 0.5 + (idx * 0.15);
                    layer.style.transform = `scale(1.15) translate(${driftX * depth}px, ${driftY * depth}px)`;
                });

                // Update All Dots (Mobile & Desktop)
                mobileDots.forEach((dot, idx) => dot.classList.toggle('active', idx === activeIdx));
                desktopDots.forEach((dot, idx) => dot.classList.toggle('active', idx === activeIdx));

                if (isMobile) {
                    // Toggle Hints Dynamically
                    const isAtTop = window.scrollY < 50;
                    if (activeIdx < 2) {
                        if (swipeHint) {
                            swipeHint.style.opacity = isAtTop ? '1' : '0';
                            swipeHint.style.pointerEvents = isAtTop ? 'auto' : 'none';
                        }
                        if (scrollHint) {
                            scrollHint.style.opacity = '0';
                            scrollHint.style.pointerEvents = 'none';
                        }
                    } else {
                        if (swipeHint) {
                            swipeHint.style.opacity = '0';
                            swipeHint.style.pointerEvents = 'none';
                        }
                        if (scrollHint) {
                            scrollHint.style.opacity = isAtTop ? '0.4' : '0';
                            scrollHint.style.pointerEvents = isAtTop ? 'auto' : 'none';
                        }
                    }
                } else {
                    if (scrollHint) {
                        scrollHint.style.opacity = portalScroll.scrollTop > 50 ? '0' : '0.3';
                    }
                }
            };

            portalScroll.addEventListener('scroll', handleScroll, { passive: true });
            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();

            // Make All Dots Clickable
            [...mobileDots, ...desktopDots].forEach((dot, idx) => {
                dot.addEventListener('click', () => {
                    const realIdx = idx % 4; // Since we have 4 sections
                    const isMobile = window.innerWidth <= 1024;
                    if (isMobile) {
                        const width = portalScroll.offsetWidth || window.innerWidth;
                        portalScroll.scrollTo({ left: realIdx * width, behavior: 'smooth' });
                    } else {
                        const height = portalScroll.offsetHeight || window.innerHeight;
                        portalScroll.scrollTo({ top: realIdx * height, behavior: 'smooth' });
                    }
                });
            });
        }

        // ─── Experience Modal ────────────────────────────────
        function openExpModal(exp) {
            const modal = document.getElementById('exp-modal');
            document.getElementById('modal-title').innerText = exp.title || 'Unknown Position';
            document.getElementById('modal-company').innerText = exp.company || 'Unknown Company';
            document.getElementById('modal-period').innerText = exp.period || 'Unknown Period';
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

        // ─── Certificate Modal ────────────────────────────────
        function openCertModal(cert) {
            const modal = document.getElementById('cert-modal');
            document.getElementById('cert-modal-title').innerText = cert.name;
            document.getElementById('cert-modal-category').innerText = cert.category || '';
            document.getElementById('cert-modal-desc').innerText = cert.description || 'No description available.';

            // Image
            const imgWrap = document.getElementById('cert-modal-img');
            if (cert.image) {
                imgWrap.innerHTML = `<img src="/storage/${cert.image}" alt="${cert.name}" class="w-full h-full object-cover">`;
                imgWrap.style.display = 'block';
            } else {
                imgWrap.style.display = 'none';
            }

            // Tags
            const tagsWrap = document.getElementById('cert-modal-tags');
            tagsWrap.innerHTML = '';
            if (cert.tags && cert.tags.length > 0) {
                cert.tags.forEach(tag => {
                    const span = document.createElement('span');
                    span.className = 'cert-tag';
                    span.innerText = tag;
                    tagsWrap.appendChild(span);
                });
            }

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCertModal() {
            document.getElementById('cert-modal').classList.remove('active');
            document.body.style.overflow = '';
        }


    </script>
</div>
@endsection
