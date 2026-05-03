@extends('layouts.app')

@section('content')
<div class="page-wrapper min-h-screen relative overflow-y-auto">
    {{-- Static Background Layer (Consistent with Main Page Slide 1) --}}
    <div class="wallpapers-container fixed inset-0 z-0">
        @php $wall = $profile->wallpaper_1 ?? null; @endphp
        <div class="wallpaper-layer active" 
             @if($wall) style="background-image: url('{{ asset('storage/' . $wall) }}'); opacity: 0.5;" @endif>
        </div>
        <div class="wallpaper-overlay"></div>
    </div>

    {{-- Floating Navbar --}}
    <nav class="allprojects-navbar">
        <a href="{{ route('portfolio') }}" class="navbar-back" title="Back to Portfolio">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="navbar-title">All Projects</h1>
        <div class="navbar-search">
            <i class="fas fa-search navbar-search-icon"></i>
            <input type="text" id="project-search" placeholder="Search projects..." autocomplete="off">
        </div>
    </nav>

    {{-- Content --}}
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6" style="padding-top: 7rem; padding-bottom: 4rem;">
        {{-- Projects Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="projects-grid">
            @forelse($projects as $project)
                <a href="{{ route('projects.show', $project) }}" class="highlight-card h-full flex flex-col project-item" data-title="{{ strtolower($project->title) }}" data-subtitle="{{ strtolower($project->subtitle ?? '') }}">
                    <div class="highlight-card-img h-48">
                        @if($project->screenshot)
                            <img src="{{ asset('storage/' . $project->screenshot) }}" alt="{{ $project->title }}">
                        @else
                            <div class="highlight-card-placeholder">
                                <i class="fas fa-image text-3xl opacity-20"></i>
                            </div>
                        @endif
                    </div>
                    <div class="highlight-card-info flex-1">
                        <h3>{{ $project->title }}</h3>
                        <p>{{ $project->subtitle }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center">
                    <i class="fas fa-cube text-4xl text-gray-700 mb-4 block"></i>
                    <p class="text-gray-500 italic">No projects found.</p>
                </div>
            @endforelse
        </div>

        {{-- Empty search result --}}
        <div id="no-results" class="hidden py-20 text-center">
            <i class="fas fa-search text-4xl text-gray-700 mb-4 block"></i>
            <p class="text-gray-400 italic">No projects match your search.</p>
        </div>
    </div>
</div>

<style>
    /* Allow scrolling on this specific page */
    html, body {
        overflow: auto !important;
        height: auto !important;
    }
    .page-wrapper {
        display: block !important;
        height: auto !important;
        min-height: 100vh;
    }

    /* ─── Floating Navbar ─────────────────────────────────── */
    .allprojects-navbar {
        position: fixed;
        top: 1.5rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 100;
        width: calc(100% - 3rem);
        max-width: 1280px;
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.875rem 1.5rem;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar-back {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        flex-shrink: 0;
        color: white;
        font-size: 0.875rem;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
        text-decoration: none;
    }
    .navbar-back:hover {
        background: rgba(147, 51, 234, 0.3);
        border-color: rgba(168, 85, 247, 0.4);
    }

    .navbar-title {
        font-size: 1.125rem;
        font-weight: 800;
        color: white;
        white-space: nowrap;
        letter-spacing: 0.05em;
        font-family: 'Oswald', sans-serif;
        text-transform: uppercase;
    }

    .navbar-search {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.625rem;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 0 1rem;
        height: 2.5rem;
        margin-left: auto;
        transition: border-color 0.3s;
    }
    .navbar-search:focus-within {
        border-color: rgba(168, 85, 247, 0.5);
        background: rgba(255, 255, 255, 0.08);
    }
    .navbar-search-icon {
        color: rgba(255, 255, 255, 0.35);
        font-size: 0.8rem;
        flex-shrink: 0;
    }
    .navbar-search input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        color: white;
        font-size: 0.825rem;
        font-weight: 500;
        font-family: inherit;
    }
    .navbar-search input::placeholder {
        color: rgba(255, 255, 255, 0.3);
        font-weight: 500;
    }

    /* ─── Responsive ──────────────────────────────────────── */
    @media (max-width: 768px) {
        .allprojects-navbar {
            top: 1rem;
            width: calc(100% - 2rem);
            padding: 0.625rem;
            gap: 0.5rem;
            height: auto;
            flex-wrap: wrap;
        }
        .navbar-title {
            font-size: 0.875rem;
            order: 1;
        }
        .navbar-back {
            order: 0;
        }
        .navbar-search {
            order: 2;
            width: 100%;
            margin-left: 0;
            height: 2.25rem;
        }
    }
</style>

<script>
    document.getElementById('project-search').addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        const items = document.querySelectorAll('.project-item');
        const grid = document.getElementById('projects-grid');
        const noResults = document.getElementById('no-results');
        let visibleCount = 0;

        items.forEach(function (item) {
            const title = item.dataset.title || '';
            const subtitle = item.dataset.subtitle || '';
            const match = title.includes(query) || subtitle.includes(query);
            item.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        grid.style.display = visibleCount === 0 && query.length > 0 ? 'none' : '';
        noResults.classList.toggle('hidden', visibleCount > 0 || query.length === 0);
    });
</script>
@endsection
