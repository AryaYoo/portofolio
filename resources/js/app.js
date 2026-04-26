import './bootstrap';

// ═══════════════════════════════════════════════════════════
// PORTFOLIO INTERACTIONS
// ═══════════════════════════════════════════════════════════

document.addEventListener('DOMContentLoaded', () => {
    // ─── Navigation Dots Active State ──────────────────────
    const sections = document.querySelectorAll('section[id]');
    const navDots = document.querySelectorAll('.nav-dot');

    if (sections.length && navDots.length) {
        const observerOptions = {
            root: null,
            rootMargin: '-30% 0px -30% 0px',
            threshold: 0,
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navDots.forEach(dot => dot.classList.remove('active'));
                    const activeDot = document.querySelector(`.nav-dot[data-section="${entry.target.id}"]`);
                    if (activeDot) activeDot.classList.add('active');
                }
            });
        }, observerOptions);

        sections.forEach(section => observer.observe(section));
    }

    // ─── Project Carousel ─────────────────────────────────
    const carousel = document.getElementById('project-carousel');
    const nextBtn = document.getElementById('carousel-next');

    if (carousel && nextBtn) {
        let scrollPos = 0;
        const cardWidth = 280;

        nextBtn.addEventListener('click', () => {
            scrollPos += cardWidth;
            if (scrollPos >= carousel.scrollWidth - carousel.clientWidth) {
                scrollPos = 0;
            }
            carousel.scrollTo({ left: scrollPos, behavior: 'smooth' });
        });
    }

    // ─── Skill Bars Animation ─────────────────────────────
    const skillBars = document.querySelectorAll('.skill-bar');

    if (skillBars.length) {
        const skillObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    const level = bar.getAttribute('data-level');
                    setTimeout(() => {
                        bar.style.width = level + '%';
                    }, 200);
                    skillObserver.unobserve(bar);
                }
            });
        }, { threshold: 0.3 });

        skillBars.forEach(bar => skillObserver.observe(bar));
    }

    // ─── Fade In Up on Scroll ─────────────────────────────
    const fadeElements = document.querySelectorAll(
        '.project-card, .skill-item, #experience .group, #contact form'
    );

    if (fadeElements.length) {
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                    fadeObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            fadeObserver.observe(el);
        });
    }

    // ─── Smooth Scroll for Anchor Links ───────────────────
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            e.preventDefault();
            const target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ─── Admin Sidebar Toggle ─────────────────────────────
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            if (overlay) overlay.classList.toggle('hidden');
        });
    }
});
