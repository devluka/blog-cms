<x-blog-layout :categories="$categories">
    
    <div class="max-w-7xl mx-auto px-6 py-12 md:py-20">
        
        {{-- Logic to determine if we show the Hero section --}}
        @php
            $showHero = $posts->currentPage() === 1 && !request('search') && !isset($tag) && !isset($category);
            $featured = $showHero ? $posts->first() : null;
            $gridPosts = $showHero ? $posts->skip(1) : $posts;
        @endphp

        {{-- HERO SECTION --}}
        @if($featured)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mb-24">
                
                <div class="lg:col-span-7 group cursor-pointer relative aspect-video">
                    <a href="{{ route('blog.show', $featured->slug) }}" class="block w-full h-full overflow-hidden rounded-2xl shadow-sm relative">
                        
                        @if ($featured->featured_image)
                            {{-- Real Image --}}
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors z-10"></div>
                            <img src="{{ asset('storage/' . $featured->featured_image) }}" 
                                 alt="{{ $featured->title }}" 
                                 class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                        @else
                            {{-- Hero Fallback: Large Gradient --}}
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center group-hover:scale-105 transition-transform duration-700">
                                <svg class="w-24 h-24 text-blue-100 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                        @endif

                    </a>
                </div>

                {{-- Hero Content --}}
                <div class="lg:col-span-5 flex flex-col justify-center">
                    <div class="flex items-center gap-3 text-xs font-bold tracking-widest uppercase text-blue-600 mb-4">
                        <span>{{ $featured->category->name ?? 'Vertex' }}</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="text-gray-400">{{ $featured->published_at ? $featured->published_at->format('M d, Y') : 'Draft' }}</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-bold tracking-tighter text-gray-900 dark:text-white leading-[1.1] mb-6">
                        <a href="{{ route('blog.show', $featured->slug) }}" class="hover:text-blue-600 transition-colors">
                            {{ $featured->title }}
                        </a>
                    </h2>

                    <p class="text-lg text-gray-500 dark:text-gray-400 leading-relaxed mb-6 line-clamp-3 font-serif">
                        {{ $featured->excerpt }}
                    </p>

                    {{-- Tags in Hero --}}
                    @if($featured->tags->count() > 0)
                        <div class="mb-6 flex flex-wrap gap-2">
                            @foreach($featured->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="text-xs font-bold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <a href="{{ route('blog.show', $featured->slug) }}" class="inline-flex items-center text-sm font-bold text-gray-900 dark:text-white border-b-2 border-blue-600 pb-0.5 hover:text-blue-600 transition-colors">
                            Read Article
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- FILTER HEADER (Search, Tag, Category) --}}
        @if(request('search') || isset($category) || isset($tag))
            <div class="mb-12 border-b border-gray-100 dark:border-gray-800 pb-4 flex justify-between items-end">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                    @if(isset($category)) {{ $category->name }}
                    @elseif(isset($tag)) Tag: #{{ $tag->name }}
                    @elseif(request('search')) Search: "{{ request('search') }}"
                    @endif
                </h1>
                <a href="{{ route('blog.index') }}" class="text-sm text-gray-400 hover:text-blue-600">Clear Filters</a>
            </div>
        @endif

        {{-- POST GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-16">
            @forelse ($gridPosts as $post)
                <article class="group flex flex-col h-full">
                    
                    {{-- Grid Image / Fallback --}}
                    <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 mb-6 aspect-[4/3] relative shadow-sm">
                        @if ($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105">
                        @else
                            {{-- Grid Fallback: Standard Gradient --}}
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                                <svg class="w-12 h-12 text-blue-100 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                        @endif
                    </a>

                    {{-- Meta --}}
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">
                        <span class="text-blue-600">{{ $post->category->name ?? 'Vertex' }}</span>
                        <span>&bull;</span>
                        <span>{{ $post->published_at ? $post->published_at->format('M d') : 'Draft' }}</span>
                    </div>

                    {{-- Title --}}
                    <h2 class="text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white leading-tight mb-3">
                        <a href="{{ route('blog.show', $post->slug) }}" class="group-hover:text-blue-600 transition-colors">
                            {{ $post->title }}
                        </a>
                    </h2>

                    {{-- Tags in Grid --}}
                    @if($post->tags->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($post->tags->take(3) as $tag)
                                <span class="text-[10px] font-semibold tracking-wider text-gray-400 dark:text-gray-600">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Excerpt --}}
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-3 mb-4 font-serif text-sm">
                        {{ $post->excerpt }}
                    </p>
                </article>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="inline-block p-4 rounded-full bg-gray-50 dark:bg-gray-800 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No articles found.</p>
                    <a href="{{ route('blog.index') }}" class="mt-4 inline-block text-sm font-bold text-blue-600 hover:underline">Clear Filters</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-20 pt-8 border-t border-gray-100 dark:border-gray-800">
            {{ $posts->withQueryString()->links() }}
        </div>

    </div>
</x-blog-layout>
