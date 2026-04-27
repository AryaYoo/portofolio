import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // ─── Right Portal Scrolling & Mini Map ───────────────────
    const portalScroll = document.getElementById('portal-scroll');
    const sections = document.querySelectorAll('.portal-section');
    const dots = document.querySelectorAll('.map-dot');
    
    if (portalScroll && sections.length && dots.length) {
        
        // 1. Sync dots when scrolling
        portalScroll.addEventListener('scroll', () => {
            let currentSectionIndex = 0;
            const scrollPos = portalScroll.scrollTop;
            
            // Find which section is currently mostly in view
            sections.forEach((section, index) => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                if (scrollPos >= sectionTop - (sectionHeight / 2)) {
                    currentSectionIndex = index;
                }
            });

            // Update active dot
            dots.forEach(dot => dot.classList.remove('active'));
            if (dots[currentSectionIndex]) {
                dots[currentSectionIndex].classList.add('active');
            }

            // Animate skills if Section 2 (Skills) is active
            if (currentSectionIndex === 2) {
                animateSkillBars();
            }
        });

        // 2. Click dot to scroll to section
        dots.forEach((dot) => {
            dot.addEventListener('click', () => {
                const targetIndex = parseInt(dot.getAttribute('data-target'));
                const targetSection = document.getElementById(`section-${targetIndex}`);
                
                if (targetSection) {
                    portalScroll.scrollTo({
                        top: targetSection.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // 3. Optional: Keyboard Up/Down navigation
        // To use keyboard effectively, we listen for keys and scroll manually 
        // to snap to the exact next/prev section.
        document.addEventListener('keydown', (e) => {
            // Ignore if typing in an input
            if (e.target.tagName.toLowerCase() === 'input' || e.target.tagName.toLowerCase() === 'textarea') {
                return;
            }

            let currentIndex = 0;
            const scrollPos = portalScroll.scrollTop;
            sections.forEach((section, index) => {
                if (scrollPos >= section.offsetTop - 50) {
                    currentIndex = index;
                }
            });

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextIndex = Math.min(currentIndex + 1, sections.length - 1);
                portalScroll.scrollTo({
                    top: document.getElementById(`section-${nextIndex}`).offsetTop,
                    behavior: 'smooth'
                });
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevIndex = Math.max(currentIndex - 1, 0);
                portalScroll.scrollTo({
                    top: document.getElementById(`section-${prevIndex}`).offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    }

    // ─── Highlight Carousel Logic ────────────────────────────
    const carousel = document.getElementById('highlight-carousel');
    const nextBtn = document.getElementById('carousel-next');

    if (carousel && nextBtn) {
        nextBtn.addEventListener('click', () => {
            const scrollWidth = carousel.scrollWidth;
            const clientWidth = carousel.clientWidth;
            const maxScroll = scrollWidth - clientWidth;
            
            let nextScrollPos = carousel.scrollLeft + 300; // rough width of one card + gap
            
            if (carousel.scrollLeft >= maxScroll - 10) { 
                // Return to start if at the end
                carousel.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                carousel.scrollTo({ left: nextScrollPos, behavior: 'smooth' });
            }
        });
    }

    // ─── Skill Bars Animation ────────────────────────────────
    let skillsAnimated = false;
    function animateSkillBars() {
        if (skillsAnimated) return;
        
        const skillFills = document.querySelectorAll('.skill-fill');
        skillFills.forEach(fill => {
            const level = fill.getAttribute('data-level');
            // Slight delay to allow CSS transitions to trigger visually
            setTimeout(() => {
                fill.style.width = level + '%';
            }, 100);
        });
        
        skillsAnimated = true;
    }
});
