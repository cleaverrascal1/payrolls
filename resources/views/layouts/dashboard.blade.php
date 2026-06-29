<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ config('app.name', 'Laravel') }}
        @hasSection('title')
            | @yield('title')
        @endif
    </title>
    @vite('resources/css/app.css')
</head>
<body class="h-screen bg-neutral-50" x-data="{ sidebarOpen: false }">
    <div
        x-show="sidebarOpen"
        x-cloak
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-black/50 md:hidden"
    ></div>

    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 z-40 h-full w-64 flex flex-col border-r border-neutral-200 bg-white transition-transform duration-300 ease-in-out md:translate-x-0"
    >
        <div class="relative inline-block px-6 pt-5 pb-2">
            <button class="flex w-full items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative h-8 w-8">
                        <img src="https://www.digitalpowertalent.com/images/logo.png" alt="Logo" class="w-full h-full">
                    </div>
                    <div class="flex flex-col text-left text-sm leading-tight">
                        <span class="truncate font-medium">Digital Power Talent</span>
                        <span class="truncate text-xs text-gray-500">Enterprise</span>
                    </div>
                </div>
            </button>
        </div>

        <div class="w-full px-4">
            <x-side-links />
        </div>

        <div class="mt-auto p-2">
            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="flex items-center gap-3 w-full px-2 py-1.5 rounded-lg hover:bg-neutral-100 transition-colors cursor-pointer"
                >
                    <div class="w-8 h-8 rounded-lg bg-neutral-700 shrink-0 flex items-center justify-center">
                        <span class="text-sm font-medium text-white uppercase">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div class="text-left flex flex-col min-w-0 gap-0">
                        <span class="text-sm font-medium truncate leading-none text-neutral-800">{{ auth()->user()->name }}</span>
                        <span class="text-xs text-neutral-500 truncate">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevrons-up-down-icon lucide-chevrons-up-down w-4 h-4"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                    </div>
                </button>

                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-2 md:translate-y-0 md:-translate-x-2"
                    x-transition:enter-end="opacity-100 translate-y-0 md:translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0 md:translate-x-0"
                    x-transition:leave-end="opacity-0 translate-y-2 md:translate-y-0 md:-translate-x-2"
                    class="absolute bottom-full mb-2 left-0 md:bottom-0 md:left-full md:ml-2 md:mb-0 w-56 bg-white rounded-lg shadow-lg border border-neutral-300 z-50"
                >
                    <div class="flex flex-col">
                        <div class="p-1">
                            <button
                                class="flex items-center gap-3 w-full px-2 py-1.5 rounded-lg hover:bg-neutral-100 transition-colors cursor-pointer"
                            >
                                <div class="w-8 h-8 rounded-lg bg-neutral-700 shrink-0 flex items-center justify-center">
                                    <span class="text-sm font-medium text-white uppercase">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <div class="text-left flex flex-col min-w-0 gap-0">
                                    <span class="text-sm font-medium truncate leading-none text-neutral-800">{{ auth()->user()->name }}</span>
                                    <span class="text-xs text-neutral-500 truncate">{{ auth()->user()->email }}</span>
                                </div>
                            </button>
                        </div>

                        <div class="h-px w-full bg-neutral-300"></div>

                        <div class="p-1">
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-4 w-full px-4 py-1.5 text-sm rounded-lg hover:bg-neutral-100">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-pen-icon lucide-user-pen w-4 h-4"><path d="M11.5 15H7a4 4 0 0 0-4 4v2"/><path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/><circle cx="10" cy="7" r="4"/></svg>
                                <span>Edit Profil</span>
                            </a>

                            <div class="flex items-center gap-4 w-full px-4 py-1.5 text-sm rounded-lg hover:bg-neutral-100">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings w-4 h-4"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/></svg>
                                <span>Pengaturan</span>
                            </div>

                            <div class="h-px w-full bg-neutral-300 my-1"></div>

                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="flex items-center gap-4 w-full px-4 py-1.5 text-sm rounded-lg hover:bg-neutral-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out w-4 h-4"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex flex-col h-full gap-4 flex-1 ml-0 md:ml-64 p-4 overflow-y-auto">
        <header class="flex w-full items-center justify-between p-2">
            <div class="flex items-center">
                <button class="hidden lg:block text-sm text-neutral-500 hover:text-black transition-colors duration-300 cursor-pointer">
                    Build Your Application
                </button>

                <div class="mx-2 hidden lg:block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right w-4 h-4"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                <button class="text-sm">
                    Data Fetching
                </button>
            </div>

            <button
                @click="sidebarOpen = true"
                class="md:hidden p-1.5 hover:bg-gray-200 rounded-md"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    <script defer src="https://unpkg.com/alpinejs"></script>
</body>
</html>
