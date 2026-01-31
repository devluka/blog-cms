<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Write a New Post') }}
        </h2>
    </x-slot>

    {{-- SEO Logic using Alpine.js --}}
    <div class="py-12" x-data="seoAnalyzer()">
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

                        {{-- SEO META FIELDS (New) --}}
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
                            {{-- We add an ID to trigger checks when TinyMCE changes --}}
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
                <div class="bg-white p-6 shadow-sm sm:rounded-lg sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">SEO Score</h3>
                    
                    {{-- Overall Score Indicator --}}
                    <div class="flex items-center gap-4 mb-6">
                        <div class="text-3xl font-bold" :class="scoreColor" x-text="score + '%'"></div>
                        <div class="text-sm text-gray-500">Optimization Level</div>
                    </div>

                    {{-- Checklist --}}
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <span x-text="checks.titleLength ? '✅' : '❌'"></span>
                            <span :class="checks.titleLength ? 'text-green-700' : 'text-red-600'">Title length (40-60 chars)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span x-text="checks.keywordInTitle ? '✅' : '❌'"></span>
                            <span :class="checks.keywordInTitle ? 'text-green-700' : 'text-red-600'">Keyword in Title</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span x-text="checks.descLength ? '✅' : '❌'"></span>
                            <span :class="checks.descLength ? 'text-green-700' : 'text-red-600'">Meta Desc length (120-160 chars)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span x-text="checks.keywordInDesc ? '✅' : '❌'"></span>
                            <span :class="checks.keywordInDesc ? 'text-green-700' : 'text-red-600'">Keyword in Meta Desc</span>
                        </li>
                         <li class="flex items-start gap-2">
                            <span x-text="checks.contentLength ? '✅' : '❌'"></span>
                            <span :class="checks.contentLength ? 'text-green-700' : 'text-red-600'">Content > 300 words</span>
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
                    if(tinymce.get('myeditor')) {
                        this.content = tinymce.get('myeditor').getContent({format: 'text'});
                    }
                    // ... (Rest of your SEO check logic) ...
                    let passed = 0;
                    let totalChecks = 5;
                    
                    // Re-paste your exact checks here
                    this.checks.titleLength = this.title.length >= 40 && this.title.length <= 60;
                    if(this.checks.titleLength) passed++;
                    
                    this.checks.keywordInTitle = this.keyword.length > 0 && this.title.toLowerCase().includes(this.keyword.toLowerCase());
                    if(this.checks.keywordInTitle) passed++;

                    this.checks.descLength = this.description.length >= 120 && this.description.length <= 160;
                    if(this.checks.descLength) passed++;

                    this.checks.keywordInDesc = this.keyword.length > 0 && this.description.toLowerCase().includes(this.keyword.toLowerCase());
                    if(this.checks.keywordInDesc) passed++;

                    let wordCount = this.content.trim().split(/\s+/).length;
                    this.checks.contentLength = wordCount > 300;
                    if(this.checks.contentLength) passed++;

                    this.score = Math.round((passed / totalChecks) * 100);
                },
                get scoreColor() {
                    if (this.score < 50) return 'text-red-600';
                    if (this.score < 80) return 'text-yellow-500';
                    return 'text-green-600';
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
            
            // --- 1. ENABLE IMAGE UPLOADS ---
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',

            // --- 2. THE UPLOAD HANDLER ---
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

            // --- 3. SEO Integration (Existing) ---
            setup: function(editor) {
                editor.on('KeyUp Change', function(e) {
                    // This weird syntax gets the Alpine data scope
                    let alpineElement = document.querySelector('[x-data]');
                    if (alpineElement && alpineElement.__x) {
                        let alpineComponent = alpineElement.__x.$data;
                        alpineComponent.content = editor.getContent({format: 'text'});
                        alpineComponent.checkSeo();
                    }
                });
            }
        });
    </script>
</x-app-layout>