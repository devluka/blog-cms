<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
            deleteModalOpen: false, 
            deleteAction: '', 
            categoryName: '', 
            postsCount: 0,
            categoryId: null
         }">
         
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('status'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm mb-10 flex justify-between items-center">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6">

                <div class="w-full md:w-1/3">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-700">
                                {{ isset($editingCategory) ? 'Edit Category' : 'Add New Category' }}
                            </h3>
                            @if(isset($editingCategory))
                                <a href="{{ route('categories.index') }}" class="text-xs text-red-500 hover:underline">Cancel</a>
                            @endif
                        </div>

                        <form action="{{ isset($editingCategory) ? route('categories.update', $editingCategory) : route('categories.store') }}" method="POST">
                            @csrf
                            @if(isset($editingCategory))
                                @method('PUT')
                            @endif

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                                <input type="text" name="name" 
                                       value="{{ old('name', $editingCategory->name ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" class="w-full py-2 px-4 rounded font-bold text-white transition 
                                {{ isset($editingCategory) ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }}">
                                {{ isset($editingCategory) ? 'Update' : 'Create' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full md:w-2/3">
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Posts</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-5 py-4 text-sm font-bold text-gray-900">{{ $category->name }}</td>
                                    <td class="px-5 py-4 text-sm text-center">
                                        <span class="px-2 py-1 font-semibold text-blue-900 bg-blue-200 rounded-full text-xs">
                                            {{ $category->posts_count }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('categories.index', ['edit' => $category->id]) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>

                                            <button @click="
                                                deleteModalOpen = true; 
                                                deleteAction = '{{ route('categories.destroy', $category) }}';
                                                categoryName = '{{ $category->name }}';
                                                postsCount = {{ $category->posts_count }};
                                                categoryId = {{ $category->id }};
                                            " class="text-red-600 hover:text-red-900">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-4 bg-gray-50 border-t">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" @click="deleteModalOpen = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form :action="deleteAction" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="'Delete ' + categoryName"></h3>
                            
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this category?
                                </p>
                                
                                <div x-show="postsCount > 0" class="mt-4 bg-yellow-50 p-3 rounded border border-yellow-200">
                                    <p class="text-sm text-yellow-800 font-bold mb-2">
                                        Warning: This category contains <span x-text="postsCount"></span> posts.
                                    </p>
                                    
                                    <div class="mt-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="action" value="reassign" checked class="text-blue-600"
                                                   onclick="document.getElementById('new_cat_select').disabled = false">
                                            <span class="ml-2 text-sm text-gray-700">Move posts to:</span>
                                        </label>
                                        
                                        <select name="new_category_id" id="new_cat_select" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            @foreach($categories as $c)
                                                <option value="{{ $c->id }}" x-show="categoryId != {{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="action" value="delete_posts" class="text-red-600"
                                                   onclick="document.getElementById('new_cat_select').disabled = true">
                                            <span class="ml-2 text-sm text-red-600 font-bold">Delete posts too</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Confirm Delete
                            </button>
                            <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
</x-app-layout>