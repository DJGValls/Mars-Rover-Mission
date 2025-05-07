<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

            <style>
                .space-background {
                    background: linear-gradient(to bottom, #000000, #1a1a2e);
                    position: relative;
                    overflow: hidden;
                    min-height: 100vh;
                }
                .star {
                    position: absolute;
                    background: white;
                    border-radius: 50%;
                    animation: twinkle 1s infinite alternate;
                }
                h1 {
                        text-align: center;
                        font-size: 2.5rem;
                        /* margin: 2rem 0; */
                        padding-top: 10rem
                    }
                @keyframes twinkle {
                    from { opacity: 0.2; }
                    to { opacity: 1; }
                }
                .mission-button {
                    transition: all 0.3s ease;
                    transform-origin: center;
                }
                .mission-button:hover {
                    transform: scale(1.1);
                    color: #00BFFF !important;
                }
                @keyframes twinkle {
                    from { opacity: 0.2; }
                    to { opacity: 1; }
                }
            </style>
    </head>
    <body class="antialiased">
        <div class="space-background">
            <div class="flex justify-center items-center h-[calc(100vh-16rem)]">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white mb-8">Mars Rover Mission</h1>
                    <a href="{{ route('rover.index') }}"
                       class="mission-button inline-block px-6 py-3 text-lg font-semibold text-white transition duration-300 ease-in-out transform hover:scale-105">
                        Start Mission
                    </a>
                </div>
            </div>
        </div>
        <script>
            function createStars() {
                const container = document.querySelector('.space-background');
                const starCount = 200;
                for (let i = 0; i < starCount; i++) {
                    const star = document.createElement('div');
                    star.className = 'star';

                    // Random position
                    star.style.left = `${Math.random() * 100}%`;
                    star.style.top = `${Math.random() * 100}%`;

                    // Random size
                    const size = Math.random() * 3;
                    star.style.width = `${size}px`;
                    star.style.height = `${size}px`;

                    // Random animation delay
                    star.style.animationDelay = `${Math.random() * 3}s`;

                    container.appendChild(star);
                }
            }
            document.addEventListener('DOMContentLoaded', createStars);
        </script>
    </body>
</html>
