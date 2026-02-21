<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartPOS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

<div class="flex min-h-screen">

    {{-- ================= SIDEBAR ================= --}}
    <aside id="sidebar"
        class="fixed top-0 left-0 h-screen bg-white border-r shadow-sm transition-all duration-300 w-64 z-40">

        {{-- Logo + Toggle --}}
        <div class="flex items-center justify-between p-4 border-b">
            <span id="logo" class="text-xl font-bold sidebar-text">
                SmartPOS
            </span>

            <button onclick="toggleSidebar()" class="text-gray-500 hover:text-black">
                ☰
            </button>
        </div>

        {{-- Menu --}}
        <nav class="p-4 space-y-2 text-sm">

            <a href=""
            {{-- <a href="{{ route('dashboard') }}" --}}
               class="block p-2 rounded hover:bg-gray-200 sidebar-text">
                <span>
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M13 12C13 11.4477 13.4477 11 14 11H19C19.5523 11 20 11.4477 20 12V19C20 19.5523 19.5523 20 19 20H14C13.4477 20 13 19.5523 13 19V12Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                <path
                                    d="M4 5C4 4.44772 4.44772 4 5 4H9C9.55228 4 10 4.44772 10 5V12C10 12.5523 9.55228 13 9 13H5C4.44772 13 4 12.5523 4 12V5Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                <path
                                    d="M4 17C4 16.4477 4.44772 16 5 16H9C9.55228 16 10 16.4477 10 17V19C10 19.5523 9.55228 20 9 20H5C4.44772 20 4 19.5523 4 19V17Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                <path
                                    d="M13 5C13 4.44772 13.4477 4 14 4H19C19.5523 4 20 4.44772 20 5V7C20 7.55228 19.5523 8 19 8H14C13.4477 8 13 7.55228 13 7V5Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="sidebar-text">Dashboard</span>
            </a>

            <a href=""
            {{-- <a href="{{ route('users.index') }}" --}}
               class="block p-2 rounded hover:bg-gray-200 sidebar-text">
                Users
            </a>

            <a href=""
            {{-- <a href="{{ route('categories.index') }}" --}}
               class="block p-2 rounded hover:bg-gray-200 sidebar-text">
                Categories
            </a>

            <a href=""
            {{-- <a href="{{ route('sizes.index') }}" --}}
               class="block p-2 rounded hover:bg-gray-200 sidebar-text">
                Sizes
            </a>

            <a href=""
            {{-- <a href="{{ route('products.index') }}" --}}
               class="block p-2 rounded hover:bg-gray-200 sidebar-text">
                Products
            </a>

            <a href=""
            {{-- <a href="{{ route('sales.index') }}" --}}
               class="block p-2 rounded hover:bg-gray-200 sidebar-text">
                Sales
            </a>

            <a href=""
            {{-- <a href="{{ route('reports.index') }}" --}}
               class="block p-2 rounded hover:bg-gray-200 sidebar-text">
                Reports
            </a>

            <a href=""
            {{-- <a href="{{ route('settings.index') }}" --}}
               class="block p-2 rounded hover:bg-gray-200 sidebar-text">
                Settings
            </a>

        </nav>
    </aside>


    {{-- ================= MAIN CONTENT ================= --}}
    <div id="mainContent" class="flex-1 ml-64 transition-all duration-300">

        {{-- HEADER --}}
        <header id="header"
            class="fixed top-0 right-0 h-16 bg-white border-b shadow-sm flex items-center justify-between px-6 transition-all duration-300 ml-64 w-[calc(100%-16rem)] z-30">

            <h1 class="text-lg font-semibold">
                {{ $header ?? 'Dashboard' }}
            </h1>

            {{-- Profile Dropdown --}}
            <div class="relative">
                <button id="userMenu"
                    class="flex items-center gap-2 font-medium">
                    {{ auth()->user()->name }}
                    ▼
                </button>

                <div id="dropdown"
                     class="hidden absolute right-0 mt-2 w-40 bg-white shadow-lg rounded border">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 hover:bg-gray-200">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 hover:bg-gray-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>


        {{-- PAGE CONTENT --}}
        <main class="pt-20 px-6">
            {{ $slot }}
        </main>

    </div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>

    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const header = document.getElementById('header');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');
    const logo = document.getElementById('logo');

    function toggleSidebar() {

        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-20');

        mainContent.classList.toggle('ml-64');
        mainContent.classList.toggle('ml-20');

        header.classList.toggle('ml-64');
        header.classList.toggle('ml-20');

        header.classList.toggle('w-[calc(100%-16rem)]');
        header.classList.toggle('w-[calc(100%-5rem)]');

        sidebarTexts.forEach(text => {
            text.classList.toggle('hidden');
        });

        logo.classList.toggle('hidden');

        localStorage.setItem(
            'sidebarCollapsed',
            sidebar.classList.contains('w-20')
        );
    }

    // Restore state
    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem('sidebarCollapsed') === 'true') {

            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');

            mainContent.classList.remove('ml-64');
            mainContent.classList.add('ml-20');

            header.classList.remove('ml-64','w-[calc(100%-16rem)]');
            header.classList.add('ml-20','w-[calc(100%-5rem)]');

            sidebarTexts.forEach(text => text.classList.add('hidden'));
            logo.classList.add('hidden');
        }
    });

    // Dropdown
    const userMenu = document.getElementById('userMenu');
    const dropdown = document.getElementById('dropdown');

    userMenu.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
        dropdown.classList.add('hidden');
    });

</script>

</body>
</html>