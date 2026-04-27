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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#08080f] text-white antialiased has-custom-cursor">
    @yield('content')

    {{-- Custom Cursor Elements --}}
    <div class="cursor-dot" data-cursor-dot></div>
    <div class="cursor-outline" data-cursor-outline></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

            // Smooth animation loop for the outline
            function animateCursor() {
                // Lerp formula for smooth following
                let distX = mouseX - outlineX;
                let distY = mouseY - outlineY;
                
                outlineX = outlineX + (distX * 0.15);
                outlineY = outlineY + (distY * 0.15);
                
                cursorOutline.style.left = `${outlineX}px`;
                cursorOutline.style.top = `${outlineY}px`;
                
                requestAnimationFrame(animateCursor);
            }
            
            // Start the animation loop
            animateCursor();

            // Add hover effect for interactive elements
            const interactables = document.querySelectorAll('a, button, [onclick], input, textarea, select');
            
            interactables.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cursorOutline.classList.add('hover-active');
                });
                
                el.addEventListener('mouseleave', () => {
                    cursorOutline.classList.remove('hover-active');
                });
            });
            
            // Re-bind hover effect when new elements might be added (e.g. modals opening)
            // A simple MutationObserver could be used here if needed, but for now we bind once.
            // A click listener on the body as a fallback to re-check might be useful too.
        });
    </script>
</body>
</html>
