<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>

            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 256px; /* w-64 */
                z-index: 40;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            #overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 30;
            }            
            @media (min-width: 1024px) {
                #sidebar {
                    transform: translateX(0) !important;
                }
                #overlay {
                    display: none !important;
                }
                #main-content {
                    margin-left: 256px;
                }
            }            
            #sidebar.open {
                transform: translateX(0);
            }

            #overlay.open {
                display: block;
            }

            #main-content {
                display: flex;
                flex-direction: column;
                flex: 1;
                height: 100vh;
                overflow: hidden;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">

        <div class="flex h-screen overflow-hidden">

            @include('layouts.sidebar')            
            <div id="overlay" onclick="closeSidebar()"></div>            
            <div id="main-content">
                @include('layouts.navigation')
                <main class="flex-1 overflow-auto p-6 lg:p-8 bg-gray-50">
                    {{ $slot }}
                </main>
            </div>

        </div>

        <script>
            function openSidebar() {
                document.getElementById('sidebar').classList.add('open');
                document.getElementById('overlay').classList.add('open');
            }

            function closeSidebar() {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('overlay').classList.remove('open');
            }

            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }
        </script>

        <script>
            @if(session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#3b82f6',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
            @if(session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            @endif
        </script>
    </body>
</html>