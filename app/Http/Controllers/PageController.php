<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PageController extends Controller
{
    public function about()
    {
        $categories = Category::has('posts')->get();
        return view('pages.about', compact('categories'));
    }

    public function terms()
    {
        $categories = Category::has('posts')->get();
        return view('pages.terms', compact('categories'));
    }

    public function privacy()
    {
        $categories = Category::has('posts')->get();
        return view('pages.privacy', compact('categories'));
    }
}