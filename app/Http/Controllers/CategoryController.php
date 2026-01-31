<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Needed for slug generation

class CategoryController extends Controller
{
    // 1. Show the form to create a new category
    public function create()
    {
        return view('categories.create');
    }

    // 2. Handle the form submission and save to DB
    public function store(Request $request)
    {
        // Validation: Ensure name is required and unique
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Auto-generate slug from name (e.g., "Tech News" -> "tech-news")
        $slug = Str::slug($request->name);

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);


        return redirect()->route('dashboard')->with('status', 'Category created successfully!');
    }
}