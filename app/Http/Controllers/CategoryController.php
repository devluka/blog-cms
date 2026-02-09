<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('posts')->latest()->paginate(10);
        $editingCategory = null;
        if ($request->has('edit')) {
            $editingCategory = Category::find($request->edit);
        }

        return view('categories.index', compact('categories', 'editingCategory'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories,name']);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
        ]);

        return redirect()->route('categories.index')->with('status', 'Category created!');
    }

    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('status', 'Category updated!');
    }

    public function destroy(Request $request, Category $category)
    {
        if ($category->posts()->count() > 0) {
            $request->validate([
                'action' => 'required|in:reassign,delete_posts',
                'new_category_id' => 'required_if:action,reassign|exists:categories,id',
            ]);

            if ($request->action === 'reassign') {
                $category->posts()->update(['category_id' => $request->new_category_id]);
            } else {
                $category->posts()->delete();
            }
        }

        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category deleted!');
    }
}
