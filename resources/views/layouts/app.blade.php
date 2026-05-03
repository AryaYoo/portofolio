<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Yohanes Mahardika Arya Putra Cahyana - UI/UX Designer Portfolio. A tech-savvy designer who believes great design is the result of empathy executed with clear purpose.">
    <meta name="keywords" content="UI/UX Designer, Portfolio, Yohanes, Design, Web Developer">
    <title>Yohanes - UI/UX Designer Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @php $globalProfile = \App\Models\Profile::first(); @endphp
    @if($globalProfile && $globalProfile->favicon)
        <link rel="icon" href="{{ asset('storage/' . $globalProfile->favicon) }}">
    @endif
</head>
<body class="bg-[#08080f] text-white antialiased has-custom-cursor">
    {{-- Theme Toggle (Square Slide) --}}
    <div class="theme-switch-container">
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="slider square">
                <div class="knob">
                    <i class="fas fa-moon moon-icon"></i>
                    <i class="fas fa-sun sun-icon"></i>
                </div>
            </div>
        </label>
    </div>

    @yield('content')

    {{-- Custom Cursor Elements --}}
    <div class="cursor-dot" data-cursor-dot></div>
    <div class="cursor-outline" data-cursor-outline></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ─── Theme Toggle Logic ─────────────────────────────
            const checkbox = document.getElementById('checkbox');
            
            // Check for saved theme preference
            const savedTheme = localStorage.getItem('theme') || 'dark';
            if (savedTheme === 'light') {
                document.body.classList.add('light-theme');
                checkbox.checked = true;
            }

            checkbox.addEventListener('change', (e) => {
                if(e.target.checked) {
                    document.body.classList.add('light-theme');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.body.classList.remove('light-theme');
                    localStorage.setItem('theme', 'dark');
                }
            });

            // ─── Custom Cursor Logic ────────────────────────────
            const cursorDot = document.querySelector("[data-cursor-dot]");
            const cursorOutline = document.querySelector("[data-cursor-outline]");

            let mouseX = 0;
            let mouseY = 0;
            let outlineX = 0;
            let outlineY = 0;

            window.addEventListener("mousemove", function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
                
                // Instantly move the dot
                cursorDot.style.left = `${mouseX}px`;
                cursorDot.style.top = `${mouseY}px`;
            });

            window.addEventListener("mousedown", function() {
                cursorOutline.classList.add("click-active");
                cursorDot.style.transform = "translate(-50%, -50%) scale(0.5)";
            });

            window.addEventListener("mouseup", function() {
                cursorOutline.classList.remove("click-active");
                cursorDot.style.transform = "translate(-50%, -50%) scale(1)";
            });

            // Smooth animation loop for the outline
            function animateCursor() {
                // Lerp formula for smooth following
                let distX = mouseX - outlineX;
                let distY = mouseY - outlineY;
                
                outlineX = outlineX + (distX * 0.2); // Sightly faster follow
                outlineY = outlineY + (distY * 0.2);
                
                cursorOutline.style.left = `${outlineX}px`;
                cursorOutline.style.top = `${outlineY}px`;
                
                requestAnimationFrame(animateCursor);
            }
            
            // Start the animation loop
            animateCursor();

            // Better hover detection
            const updateInteractables = () => {
                const interactables = document.querySelectorAll('a, button, [onclick], input, textarea, select, .minimap-dot, .map-dot');
                interactables.forEach(el => {
                    el.addEventListener('mouseenter', () => cursorOutline.classList.add('hover-active'));
                    el.addEventListener('mouseleave', () => cursorOutline.classList.remove('hover-active'));
                });
            };
            
            updateInteractables();
            
            // Re-run detection when DOM changes (modals, etc)
            const observer = new MutationObserver(updateInteractables);
            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>
</body>
</html>
