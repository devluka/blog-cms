<x-blog-layout 
    :categories="$categories" 
    :meta-title="$post->title" 
    :meta-description="$post->meta_description ? $post->meta_description : $post->excerpt" 
    :meta-keyword="$post->meta_keyword"
    :meta-image="$post->featured_image ? asset('storage/' . $post->featured_image) : null"
>
    {{-- Reading Progress Bar --}}
    <div x-data="{ width: 0 }" 
         @scroll.window="width = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100"
         class="fixed top-[80px] left-0 w-full h-[2px] z-40 bg-transparent">
        <div class="h-full bg-blue-600 transition-all duration-75" :style="`width: ${width}%`"></div>
    </div>

    <article class="py-16 md:py-24">
        
        {{-- Header --}}
        <header class="max-w-3xl mx-auto px-6 text-center mb-12">
            @if($post->category)
                <a href="{{ route('blog.category', $post->category->slug) }}" class="inline-block mb-6 text-xs font-bold uppercase tracking-widest text-blue-600 hover:text-blue-700 transition-colors">
                    {{ $post->category->name }}
                </a>
            @endif
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tighter text-gray-900 dark:text-white leading-[1.1] mb-8">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                <span class="font-medium text-gray-900 dark:text-white">{{ $post->user->name }}</span>
                <span>&bull;</span>
                <time datetime="{{ $post->published_at }}">{{ $post->published_at->format('F d, Y') }}</time>
                <span>&bull;</span>
                <span class="text-blue-600">{{ ceil(str_word_count(strip_tags($post->body)) / 200) }} min read</span>
            </div>
        </header>

        {{-- Wide Featured Image --}}
        @if ($post->featured_image)
            <div class="max-w-5xl mx-auto px-6 mb-16">
                <img class="w-full h-auto object-cover aspect-[21/9] rounded-2xl shadow-sm" 
                     src="{{ asset('storage/' . $post->featured_image) }}" 
                     alt="{{ $post->title }}">
            </div>
        
        @endif

        {{-- Content --}}
        <div class="max-w-2xl mx-auto px-6">
            <div class="prose prose-lg prose-blue prose-headings:font-sans prose-headings:tracking-tight prose-p:font-serif prose-p:text-gray-600 dark:prose-p:text-gray-300 dark:prose-invert hover:prose-a:text-blue-600 transition-colors">
                {!! $post->body !!}
            </div>

            {{-- Tags --}}
            @if($post->tags->count() > 0)
                <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}" 
                               class="text-xs font-bold uppercase tracking-wide text-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-gray-400 px-3 py-1.5 rounded-full hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-700 transition-colors">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Bottom Actions --}}
            <div class="mt-12 flex justify-between items-center">
                <a href="{{ route('blog.index') }}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-blue-600 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Articles
                </a>

                {{-- Share / Copy Link --}}
                <div x-data="{ copied: false }">
                    <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                            class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-colors"
                            :class="copied ? 'bg-green-100 text-green-700' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200'">
                        <span x-text="copied ? 'Copied!' : 'Share Article'"></span>
                        <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                        <svg x-show="copied" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </article>

    @if($relatedPosts->count() > 0)
        <div class=" dark:border-gray-800 py-16 md:py-24 mt-4">
            <div class="max-w-7xl mx-auto px-6">
                <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-12">Read Next</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-12">
                    @foreach($relatedPosts as $related)
                        <article class="group flex flex-col h-full">
                            {{-- Image --}}
                            <a href="{{ route('blog.show', $related->slug) }}" class="block overflow-hidden rounded-xl bg-gray-200 dark:bg-gray-800 mb-5 aspect-[4/3] relative shadow-sm">
                                @if ($related->featured_image)
                                    <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                         alt="{{ $related->title }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>

                            {{-- Meta --}}
                            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">
                                <span class="text-blue-600">{{ $related->category->name ?? 'Article' }}</span>
                                <span>&bull;</span>
                                <span>{{ $related->published_at ? $related->published_at->format('M d') : '' }}</span>
                            </div>

                            {{-- Title --}}
                            <h4 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white leading-tight mb-2">
                                <a href="{{ route('blog.show', $related->slug) }}" class="group-hover:text-blue-600 transition-colors">
                                    {{ $related->title }}
                                </a>
                            </h4>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</x-blog-layout>