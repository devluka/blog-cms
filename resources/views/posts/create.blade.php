<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Write a New Post') }}
        </h2>
    </x-slot>

    {{-- SEO Logic using Alpine.js --}}
    {{-- CRITICAL: id="seo-component" and @seo-update are required for TinyMCE communication --}}
    <div class="py-12" 
         id="seo-component" 
         x-data="seoAnalyzer()" 
         @seo-update="content = $event.detail; checkSeo()">
         
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- MAIN FORM --}}
            <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p class="font-bold">Please fix the following errors:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" id="postForm">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" x-model="title" @input="checkSeo" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-xs mt-1" :class="title.length > 60 ? 'text-red-500' : 'text-gray-500'">
                                <span x-text="title.length"></span>/60 characters (Recommended: 50-60)
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Slug (URL Preview)</label>
                            <input type="text" name="slug" :value="slugify(title)" readonly
                                class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm text-gray-500 cursor-not-allowed">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Tags</label>
                            <input type="text" name="tags" placeholder="Technology, Laravel, Tutorial (Comma separated)"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-xs text-gray-500 mt-1">Separate tags with commas.</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Featured Image</label>
                            <input type="file" name="featured_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        {{-- SEO META FIELDS --}}
                        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <h3 class="font-bold text-gray-700 mb-2">SEO Meta Data</h3>
                            
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700">Focus Keyword</label>
                                <input type="text" 
                                       name="meta_keyword" 
                                       x-model="keyword" 
                                       @input="checkSeo" 
                                       placeholder="e.g. Laravel Tutorial"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">The main phrase you want this post to rank for.</p>
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                                <textarea name="meta_description" rows="2" x-model="description" @input="checkSeo"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                <p class="text-xs mt-1" :class="description.length > 160 ? 'text-red-500' : 'text-gray-500'">
                                    <span x-text="description.length"></span>/160 characters
                                </p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea id="myeditor" name="body"></textarea>
                        </div>

                        <div class="mb-4 flex items-center">
                            <input type="checkbox" name="is_published" value="1" id="publish" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="publish" class="ml-2 text-sm text-gray-600">Publish immediately?</label>
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Save Post
                        </button>
                    </form>
                </div>
            </div>

            {{-- SIDEBAR: REAL-TIME SEO SCORE --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-gray-100 sticky top-6">
                    
                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            SEO Score
                        </h3>
                    </div>
                    
                    {{-- Overall Score Indicator --}}
                    <div class="flex items-center gap-4 mb-6">
                        <div class="relative flex items-center justify-center w-16 h-16 rounded-full border-4"
                             :class="score >= 80 ? 'border-green-500 text-green-600 bg-green-50' : (score >= 50 ? 'border-yellow-500 text-yellow-600 bg-yellow-50' : 'border-red-500 text-red-600 bg-red-50')">
                            <span class="text-xl font-extrabold" x-text="score + '%'"></span>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500">Optimization</div>
                            <div class="text-xs text-gray-400" x-text="score >= 80 ? 'Great job!' : (score >= 50 ? 'Needs work' : 'Poor')"></div>
                        </div>
                    </div>

                    {{-- Checklist --}}
                    <ul class="space-y-4 text-sm">
                        
                        {{-- 1. Title Length --}}
                        <li class="flex items-start gap-3">
                            <div class="shrink-0 mt-0.5">
                                <svg x-show="checks.titleLength" x-cloak class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <svg x-show="!checks.titleLength" x-cloak class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span :class="checks.titleLength ? 'text-gray-700 font-medium' : 'text-gray-500'">Title length (40-60 chars)</span>
                        </li>

                        {{-- 2. Keyword in Title --}}
                        <li class="flex items-start gap-3">
                            <div class="shrink-0 mt-0.5">
                                <svg x-show="checks.keywordInTitle" x-cloak class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <svg x-show="!checks.keywordInTitle" x-cloak class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span :class="checks.keywordInTitle ? 'text-gray-700 font-medium' : 'text-gray-500'">Keyword in Title</span>
                        </li>

                        {{-- 3. Description Length --}}
                        <li class="flex items-start gap-3">
                            <div class="shrink-0 mt-0.5">
                                <svg x-show="checks.descLength" x-cloak class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <svg x-show="!checks.descLength" x-cloak class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span :class="checks.descLength ? 'text-gray-700 font-medium' : 'text-gray-500'">Meta Desc (120-160 chars)</span>
                        </li>

                        {{-- 4. Keyword in Description --}}
                        <li class="flex items-start gap-3">
                            <div class="shrink-0 mt-0.5">
                                <svg x-show="checks.keywordInDesc" x-cloak class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <svg x-show="!checks.keywordInDesc" x-cloak class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span :class="checks.keywordInDesc ? 'text-gray-700 font-medium' : 'text-gray-500'">Keyword in Description</span>
                        </li>

                        {{-- 5. Content Length --}}
                        <li class="flex items-start gap-3">
                            <div class="shrink-0 mt-0.5">
                                <svg x-show="checks.contentLength" x-cloak class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <svg x-show="!checks.contentLength" x-cloak class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span :class="checks.contentLength ? 'text-gray-700 font-medium' : 'text-gray-500'">Content > 300 words</span>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>

    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script>
        function seoAnalyzer() {
            return {
                title: '',
                slug: '',
                description: '',
                keyword: '',
                content: '',
                score: 0,
                checks: { titleLength: false, keywordInTitle: false, descLength: false, keywordInDesc: false, contentLength: false },
                
                slugify(text) {
                    return text.toString().toLowerCase()
                        .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
                },

                checkSeo() {
                    let passed = 0;
                    let totalChecks = 5;
                    

                    this.checks.titleLength = this.title.length >= 40 && this.title.length <= 60;
                    if(this.checks.titleLength) passed++;
                    
                    this.checks.keywordInTitle = this.keyword.length > 0 && this.title.toLowerCase().includes(this.keyword.toLowerCase());
                    if(this.checks.keywordInTitle) passed++;

                    this.checks.descLength = this.description.length >= 120 && this.description.length <= 160;
                    if(this.checks.descLength) passed++;
                    this.checks.keywordInDesc = this.keyword.length > 0 && this.description.toLowerCase().includes(this.keyword.toLowerCase());
                    if(this.checks.keywordInDesc) passed++;
                    let text = this.content.trim();
                    let wordCount = text === '' ? 0 : text.split(/\s+/).length;
                    
                    this.checks.contentLength = wordCount > 300;
                    if(this.checks.contentLength) passed++;


                    this.score = Math.round((passed / totalChecks) * 100);
                }
            }
        }

        tinymce.init({
            selector: '#myeditor',
            license_key: 'gpl',    
            plugins: 'lists link image table wordcount',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image',
            skin: 'oxide',
            content_css: 'default',
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',

            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('tinymce.upload') }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status === 403) {
                        reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                        return;
                    }
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }

                    const json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed. Code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }),

            setup: function(editor) {
                editor.on('KeyUp Change', function(e) {
                    var content = editor.getContent({format: 'text'});
                    var el = document.getElementById('seo-component');
                    
                    if (el) {
                        el.dispatchEvent(new CustomEvent('seo-update', { 
                            detail: content,
                            bubbles: true 
                        }));
                    }
                });
            }
        });
    </script>
</x-app-layout>