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
                <span id="logo" class="text-xl font-bold">
                    SmartPOS
                </span>

                <button onclick="toggleSidebar()" class="text-gray-500 hover:text-black">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g id="Menu / Menu_Alt_03">
                                <path id="Vector" d="M5 17H13M5 12H19M5 7H13" stroke="#000000" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </g>
                    </svg>
                </button>
            </div>

            {{-- Menu --}}
            <nav class="p-4 space-y-2 text-sm">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'hover:bg-gray-200' }}">
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
                </>

                <a href="{{ route('users.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('users.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'hover:bg-gray-200' }}">
                    <span>
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M4 21C4 17.4735 6.60771 14.5561 10 14.0709M19.8726 15.2038C19.8044 15.2079 19.7357 15.21 19.6667 15.21C18.6422 15.21 17.7077 14.7524 17 14C16.2923 14.7524 15.3578 15.2099 14.3333 15.2099C14.2643 15.2099 14.1956 15.2078 14.1274 15.2037C14.0442 15.5853 14 15.9855 14 16.3979C14 18.6121 15.2748 20.4725 17 21C18.7252 20.4725 20 18.6121 20 16.3979C20 15.9855 19.9558 15.5853 19.8726 15.2038ZM15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </g>
                        </svg>
                    </span>
                    <span class="sidebar-text">User</span>
                </a>

                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('categories.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'hover:bg-gray-200' }}">
                    <span>
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M17 10H19C21 10 22 9 22 7V5C22 3 21 2 19 2H17C15 2 14 3 14 5V7C14 9 15 10 17 10Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M5 22H7C9 22 10 21 10 19V17C10 15 9 14 7 14H5C3 14 2 15 2 17V19C2 21 3 22 5 22Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M6 10C8.20914 10 10 8.20914 10 6C10 3.79086 8.20914 2 6 2C3.79086 2 2 3.79086 2 6C2 8.20914 3.79086 10 6 10Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M18 22C20.2091 22 22 20.2091 22 18C22 15.7909 20.2091 14 18 14C15.7909 14 14 15.7909 14 18C14 20.2091 15.7909 22 18 22Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="sidebar-text">Categories</span>
                </a>

                <a href="{{ route('sizes.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('sizes.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'hover:bg-gray-200' }}">
                    <span>
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M16.97 12.25V16.75C16.97 20.5 15.47 22 11.72 22H7.22C3.47 22 1.97 20.5 1.97 16.75V12.25C1.97 8.5 3.47 7 7.22 7H11.72C15.47 7 16.97 8.5 16.97 12.25Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M21.97 5.85V9.15C21.97 11.9 20.87 13 18.12 13H16.97V12.25C16.97 8.5 15.47 7 11.72 7H10.97V5.85C10.97 3.1 12.07 2 14.82 2H18.12C20.87 2 21.97 3.1 21.97 5.85Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="sidebar-text">Sizes</span>
                </a>

                <a href="{{ route('products.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('products.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'hover:bg-gray-200' }}">
                    <span>
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M23 18C23 18.75 22.79 19.46 22.42 20.06C22.21 20.42 21.94 20.74 21.63 21C20.93 21.63 20.01 22 19 22C17.78 22 16.69 21.45 15.97 20.59C15.95 20.56 15.92 20.54 15.9 20.51C15.78 20.37 15.67 20.22 15.58 20.06C15.21 19.46 15 18.75 15 18C15 16.74 15.58 15.61 16.5 14.88C17.19 14.33 18.06 14 19 14C20 14 20.9 14.36 21.6 14.97C21.72 15.06 21.83 15.17 21.93 15.28C22.59 16 23 16.95 23 18Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M20.49 17.98H17.51" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 16.52V19.51" stroke="currentColor" stroke-width="1.5"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M3.17004 7.43994L12 12.5499L20.7701 7.46991" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M12 21.6099V12.5399" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M21.61 9.17V14.83C21.61 14.88 21.61 14.92 21.6 14.97C20.9 14.36 20 14 19 14C18.06 14 17.19 14.33 16.5 14.88C15.58 15.61 15 16.74 15 18C15 18.75 15.21 19.46 15.58 20.06C15.67 20.22 15.78 20.37 15.9 20.51L14.07 21.52C12.93 22.16 11.07 22.16 9.93001 21.52L4.59001 18.56C3.38001 17.89 2.39001 16.21 2.39001 14.83V9.17C2.39001 7.79 3.38001 6.11002 4.59001 5.44002L9.93001 2.48C11.07 1.84 12.93 1.84 14.07 2.48L19.41 5.44002C20.62 6.11002 21.61 7.79 21.61 9.17Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </g>
                        </svg>
                    </span>
                    <span class="sidebar-text">Products</span>
                </a>

                <a href="{{ route('sales.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('sales.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'hover:bg-gray-200' }}">
                    <span>
                        <svg class="w-6 h-6" viewBox="-0.5 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M18.5996 21.57C19.7042 21.57 20.5996 20.6746 20.5996 19.57C20.5996 18.4654 19.7042 17.57 18.5996 17.57C17.495 17.57 16.5996 18.4654 16.5996 19.57C16.5996 20.6746 17.495 21.57 18.5996 21.57Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M8.59961 21.57C9.70418 21.57 10.5996 20.6746 10.5996 19.57C10.5996 18.4654 9.70418 17.57 8.59961 17.57C7.49504 17.57 6.59961 18.4654 6.59961 19.57C6.59961 20.6746 7.49504 21.57 8.59961 21.57Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M2 3.55997C2 3.55997 6.64 3.49997 6 7.55997L5.31006 11.62C5.20774 12.1068 5.21778 12.6105 5.33954 13.0929C5.46129 13.5752 5.69152 14.0234 6.01263 14.4034C6.33375 14.7833 6.73733 15.0849 7.19263 15.2854C7.64793 15.4858 8.14294 15.5797 8.64001 15.56H16.64C17.7479 15.5271 18.8119 15.1196 19.6583 14.404C20.5046 13.6884 21.0834 12.7069 21.3 11.62L21.9901 7.50998C22.0993 7.0177 22.0939 6.50689 21.9744 6.017C21.8548 5.52712 21.6242 5.07126 21.3005 4.68467C20.9767 4.29807 20.5684 3.99107 20.1071 3.78739C19.6458 3.58371 19.1438 3.48881 18.64 3.50998H9.94"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="sidebar-text">Sales</span>
                </a>

                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 p-2 rounded {{ request()->routeIs('reports.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'hover:bg-gray-200' }}">
                    <span>
                        <svg class="w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            mirror-in-rtl="true" fill="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill="currentColor"
                                    d="M19 0H5C3.9 0 3 .9 3 2v20c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V2c0-1.1-.9-2-2-2zm0 21.5c0 .28-.22.5-.5.5h-13c-.28 0-.5-.22-.5-.5v-19c0-.28.22-.5.5-.5h13c.28 0 .5.22.5.5v19z">
                                </path>
                                <path fill="currentColor"
                                    d="M12 20c-.553 0-1-.445-1-.994v-6.01c0-.55.447-.996 1-.996s1 .445 1 .994v6.01c0 .55-.447.996-1 .996zM8 20c-.553 0-1-.44-1-.983v-3.033C7 15.44 7.447 15 8 15s1 .44 1 .983v3.033C9 19.56 8.553 20 8 20zM16 20c-.553 0-1-.447-1-1V6c0-.552.447-1 1-1s1 .448 1 1v13c0 .553-.447 1-1 1zM7 7.5C7 8.88 8.12 10 9.5 10S12 8.88 12 7.5H9.5V5C8.12 5 7 6.12 7 7.5z">
                                </path>
                                <path fill="currentColor" d="M13 6.5h-2.5V4C11.88 4 13 5.12 13 6.5z"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="sidebar-text">Reports</span>
                </a>

                <a {{-- <a href="{{ route('settings.index') }}" --}} class="flex items-center gap-3 p-2 rounded ">
                    <span>
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <circle cx="12" cy="12" r="3" stroke="#000000" stroke-width="1.5">
                                </circle>
                                <path
                                    d="M3.66122 10.6392C4.13377 10.9361 4.43782 11.4419 4.43782 11.9999C4.43781 12.558 4.13376 13.0638 3.66122 13.3607C3.33966 13.5627 3.13248 13.7242 2.98508 13.9163C2.66217 14.3372 2.51966 14.869 2.5889 15.3949C2.64082 15.7893 2.87379 16.1928 3.33973 16.9999C3.80568 17.8069 4.03865 18.2104 4.35426 18.4526C4.77508 18.7755 5.30694 18.918 5.83284 18.8488C6.07287 18.8172 6.31628 18.7185 6.65196 18.5411C7.14544 18.2803 7.73558 18.2699 8.21895 18.549C8.70227 18.8281 8.98827 19.3443 9.00912 19.902C9.02332 20.2815 9.05958 20.5417 9.15224 20.7654C9.35523 21.2554 9.74458 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8478 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.9021C15.0117 19.3443 15.2977 18.8281 15.7811 18.549C16.2644 18.27 16.8545 18.2804 17.3479 18.5412C17.6837 18.7186 17.9271 18.8173 18.1671 18.8489C18.693 18.9182 19.2249 18.7756 19.6457 18.4527C19.9613 18.2106 20.1943 17.807 20.6603 17C20.8677 16.6407 21.029 16.3614 21.1486 16.1272M20.3387 13.3608C19.8662 13.0639 19.5622 12.5581 19.5621 12.0001C19.5621 11.442 19.8662 10.9361 20.3387 10.6392C20.6603 10.4372 20.8674 10.2757 21.0148 10.0836C21.3377 9.66278 21.4802 9.13092 21.411 8.60502C21.3591 8.2106 21.1261 7.80708 20.6601 7.00005C20.1942 6.19301 19.9612 5.7895 19.6456 5.54732C19.2248 5.22441 18.6929 5.0819 18.167 5.15113C17.927 5.18274 17.6836 5.2814 17.3479 5.45883C16.8544 5.71964 16.2643 5.73004 15.781 5.45096C15.2977 5.1719 15.0117 4.6557 14.9909 4.09803C14.9767 3.71852 14.9404 3.45835 14.8478 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74458 2.35523 9.35523 2.74458 9.15224 3.23463C9.05958 3.45833 9.02332 3.71848 9.00912 4.09794C8.98826 4.65566 8.70225 5.17191 8.21891 5.45096C7.73557 5.73002 7.14548 5.71959 6.65205 5.4588C6.31633 5.28136 6.0729 5.18269 5.83285 5.15108C5.30695 5.08185 4.77509 5.22436 4.35427 5.54727C4.03866 5.78945 3.80569 6.19297 3.33974 7C3.13231 7.35929 2.97105 7.63859 2.85138 7.87273"
                                    stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path>
                            </g>
                        </svg>
                    </span>
                    <span class="sidebar-text">Settings</span>
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
                    <button id="userMenu" class="flex items-center gap-2 font-medium">
                        {{ auth()->user()->name }}
                        ▼
                    </button>

                    <div id="dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-lg rounded border">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-200">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200">
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

            logo.classList.toggle('hidden');

            sidebarTexts.forEach(text => {
                text.classList.toggle('hidden');
            });


            localStorage.setItem(
                'sidebarCollapsed',
                sidebar.classList.contains('w-20')
            );
        }

        // Restore state
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {

                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');

                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-20');

                header.classList.remove('ml-64', 'w-[calc(100%-16rem)]');
                header.classList.add('ml-20', 'w-[calc(100%-5rem)]');

                sidebarTexts.forEach(text => text.classList.add('hidden'));
                logo.classList.add('hidden');
            }
        });

        // Dropdown
        const userMenu = document.getElementById('userMenu');
        const dropdown = document.getElementById('dropdown');

        userMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function() {
            dropdown.classList.add('hidden');
        });
    </script>

</body>

</html>
