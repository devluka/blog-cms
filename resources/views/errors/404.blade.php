<!DOCTYPE html>
<html lang="en" class="h-full overflow-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found - Vertex.</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Merriweather', serif; }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-full w-full relative selection:bg-blue-500 selection:text-white">

    {{-- 1. THE BACKGROUND LAYER (Massive 404) --}}
    <div class="fixed inset-0 flex items-center justify-center z-0 pointer-events-none select-none overflow-hidden">
        <h1 class="font-black text-[40vw] leading-none text-gray-50 dark:text-gray-800/50 tracking-tighter opacity-80 animate-pulse">
            404
        </h1>
    </div>

    {{-- 2. THE FOREGROUND LAYER (Content) --}}
    <div class="relative z-10 h-full flex flex-col justify-between">
        
        {{-- Navbar --}}
        <nav class="w-full px-8 py-8 flex justify-between items-center">
            <a href="/" class="text-xl font-bold tracking-tighter text-black dark:text-white hover:opacity-70 transition-opacity">
                Vertex<span class="text-blue-600">.</span>
            </a>
            <a href="https://deployte.com" class="hidden md:block text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-colors">
                Deployte Studio
            </a>
        </nav>

        {{-- Main Message --}}
        <main class="w-full max-w-2xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-serif text-gray-900 dark:text-white mb-6">
                Lost in the void.
            </h2>
            <p class="text-lg text-gray-500 dark:text-gray-400 mb-10 leading-relaxed">
                The page you are looking for has been moved, deleted, or never existed. 
            </p>

            {{-- Glass Search Bar --}}
            <form action="{{ route('blog.index') }}" method="GET" class="relative group max-w-lg mx-auto">
                <div class="absolute inset-0 bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-full shadow-lg border border-gray-100 dark:border-gray-700 transition-colors group-focus-within:border-blue-500"></div>
                <div class="relative flex items-center">
                    <input type="text" name="search" placeholder="Search for an article..." 
                           class="w-full bg-transparent py-4 pl-6 pr-12 text-gray-900 dark:text-white placeholder-gray-500 outline-none rounded-full" autocomplete="off">
                    <button type="submit" class="absolute right-2 p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>

            <div class="mt-12">
                <a href="/blog" class="text-sm font-semibold text-gray-400 hover:text-black dark:hover:text-white transition-colors border-b border-transparent hover:border-gray-900 dark:hover:border-white pb-1">
                    Back to Home
                </a>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="w-full py-8 text-center">
            <p class="text-xs font-medium text-gray-300 dark:text-gray-700 uppercase tracking-widest">
                Error Code: Not_Found
            </p>
        </footer>

    </div>

</body>
</html>