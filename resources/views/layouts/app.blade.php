<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Warunk PC-Station') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Reset & Core Titanium Styling */
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #f5f5f7; /* Apple gray background */
                color: #121212;
                margin: 0;
                display: flex;
                flex-direction: column;
                min-height: 100vh; /* Pastikan tinggi layar minimal 100% */
            }

            /* Layouting Main Content biar Footer nempel bawah */
            #app-wrapper {
                flex: 1; /* Ini kunci biar konten makan sisa ruang */
                display: flex;
                flex-direction: column;
            }

            main {
                flex: 1;
            }

            /* Global Scrollbar Titanium Style */
            ::-webkit-scrollbar {
                width: 10px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            ::-webkit-scrollbar-thumb {
                background: #d1d1d6;
                border-radius: 10px;
                border: 2px solid #f1f1f1;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #ff6b35; /* Titanium Orange */
            }

            /* Navigation Shadow Tweak */
            nav {
                backdrop-filter: blur(15px);
                background: rgba(255, 255, 255, 0.8) !important;
                border-bottom: 1px solid rgba(0,0,0,0.05) !important;
                position: sticky;
                top: 0;
                z-index: 100;
            }

            /* Footer Styling */
            footer {
                background: #121212;
                color: #86868b;
                padding: 40px 0;
                border-top: 1px solid rgba(255,255,255,0.05);
                margin-top: auto; /* Memastikan nempel bawah */
            }

            .footer-content {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .footer-brand {
                font-weight: 800;
                color: white;
                letter-spacing: -1px;
            }

            .footer-brand span {
                color: #ff6b35;
            }

            @media (max-width: 640px) {
                .footer-content {
                    flex-direction: column;
                    gap: 20px;
                    text-align: center;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        
        <div id="app-wrapper">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white/50 backdrop-blur-md border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            <main>
                @yield('content')
            </main>

            <footer>
                <div class="footer-content">
                    <div class="footer-brand">
                        WARUNK <span>PC-STATION.</span>
                    </div>
                    <div style="font-size: 0.85rem; font-weight: 600;">
                        &copy; {{ date('Y') }} — Engineered for High Performance.
                    </div>
                    <div style="display: flex; gap: 20px;">
                        <a href="#" style="color: #aeaeae; text-decoration: none; font-size: 0.8rem; font-weight: 700; transition: 0.3s;" onmouseover="this.style.color='#ff6b35'" onmouseout="this.style.color='#aeaeae'">TERMS</a>
                        <a href="#" style="color: #aeaeae; text-decoration: none; font-size: 0.8rem; font-weight: 700; transition: 0.3s;" onmouseover="this.style.color='#ff6b35'" onmouseout="this.style.color='#aeaeae'">PRIVACY</a>
                    </div>
                </div>
            </footer>
        </div>

    </body>
</html>