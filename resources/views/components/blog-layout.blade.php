<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ $metaTitle ?? 'Vertex.' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Perspectives on technology and code.' }}">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Dark Mode FOUC Prevention --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased flex flex-col min-h-screen font-sans selection:bg-blue-600 selection:text-white"
      x-data="{ 
          searchOpen: false, 
          menuOpen: false,
          theme: localStorage.getItem('theme') || 'system',
          
          updateTheme(val) {
              this.theme = val;
              localStorage.setItem('theme', val);
              
              if (val === 'dark' || (val === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          },
          
          init() {
              this.updateTheme(this.theme);
              // Listen for OS system preference changes
              window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                  if (this.theme === 'system') {
                      this.updateTheme('system');
                  }
              });
          }
      }"
>

    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-gray-950/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            
            <a href="{{ route('blog.index') }}" class="text-xl font-bold tracking-tighter z-50 group">
                Vertex<span class="text-blue-600 group-hover:text-blue-500 transition-colors">.</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <div class="flex items-center gap-6 text-sm font-medium text-gray-500 dark:text-gray-400">
                    @foreach($categories->take(4) as $cat)
                        <a href="{{ route('blog.category', $cat->slug) }}" class="hover:text-black dark:hover:text-white transition-colors">{{ $cat->name }}</a>
                    @endforeach
                </div>

                {{-- Divider --}}
                <div class="h-4 w-px bg-gray-200 dark:bg-gray-800"></div>

                <div class="flex items-center gap-4">
                    <button @click="searchOpen = !searchOpen" class="text-gray-400 hover:text-black dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    
<button @click="theme === 'system' ? updateTheme('light') : (theme === 'light' ? updateTheme('dark') : updateTheme('system'))" 
        :title="`Current theme: ${theme.charAt(0).toUpperCase() + theme.slice(1)}`"
        class="text-gray-400 hover:text-black dark:hover:text-white transition-colors">
    
    <svg x-show="theme === 'light'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"></path>
    </svg>

    <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"></path>
    </svg>
    
    <svg x-show="theme === 'system'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"></path>
    </svg>
</button>
                </div>
            </div>

            {{-- Mobile Trigger --}}
            <button @click="menuOpen = !menuOpen" class="md:hidden text-gray-900 dark:text-white z-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="menuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Search Overlay --}}
        <div x-show="searchOpen" x-cloak x-transition.opacity @click.outside="searchOpen = false" class="absolute top-20 inset-x-0 bg-white dark:bg-gray-950 border-b border-gray-100 dark:border-gray-800 p-8 shadow-xl z-40">
            <form action="{{ route('blog.index') }}" method="GET" class="max-w-3xl mx-auto relative">
                <input type="text" name="search" placeholder="Search for articles..." class="w-full text-3xl font-light bg-transparent border-0 border-b border-gray-200 dark:border-gray-800 focus:border-blue-600 focus:ring-0 px-0 py-4 text-gray-900 dark:text-white placeholder-gray-300 dark:placeholder-gray-700">
                <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 text-sm font-bold uppercase tracking-widest text-blue-600">Search</button>
            </form>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="menuOpen" x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden absolute top-20 left-0 w-full h-[calc(100vh-5rem)] bg-white dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 z-40 overflow-y-auto"
        >
            <div class="p-6 flex flex-col gap-8 pb-20">
                
                {{-- 1. Mobile Search --}}
                <form action="{{ route('blog.index') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search articles..." 
                           class="w-full bg-gray-50 dark:bg-gray-900 border-transparent focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:ring-0 rounded-xl py-3 pl-4 pr-10 text-gray-900 dark:text-white placeholder-gray-400 transition-colors">
                    <button type="submit" class="absolute right-3 top-3 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>

                {{-- 2. Navigation Links --}}
                <div class="space-y-4">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Categories</span>
                    <div class="grid grid-cols-1 gap-2">
                        <a href="{{ route('blog.index') }}" class="block text-2xl font-bold tracking-tight text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            All Posts
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('blog.category', $cat->slug) }}" class="block text-2xl font-bold tracking-tight text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 3. Mobile Theme Switcher --}}
                <div class="mt-auto border-t border-gray-100 dark:border-gray-800 pt-8">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-4">Appearance</span>
<div class="grid grid-cols-3 gap-3">
    <button @click="updateTheme('light')" 
            class="flex items-center justify-center gap-2 py-2.5 rounded-lg text-sm font-medium transition-colors"
            :class="theme === 'light' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400'">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        Light
    </button>
    <button @click="updateTheme('dark')" 
            class="flex items-center justify-center gap-2 py-2.5 rounded-lg text-sm font-medium transition-colors"
            :class="theme === 'dark' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400'">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
        Dark
    </button>
    <button @click="updateTheme('system')" 
            class="flex items-center justify-center gap-2 py-2.5 rounded-lg text-sm font-medium transition-colors"
            :class="theme === 'system' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400'">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        System
    </button>
</div>
                </div>

            </div>
        </div>
    </nav>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-950/50 pt-16 pb-12 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} Vertex. Crafted with care.
        </div>
    </footer>
</body>
</html>