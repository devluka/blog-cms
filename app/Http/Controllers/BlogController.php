<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(Request $request)
    {

        $categories = Category::has('posts')->select('id', 'name', 'slug')->get();

        $query = Post::with(['category', 'user', 'tags']) 
                     ->where('is_published', true);

        // 3. Handle Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // 4. Optimize Selection & Pagination
        $posts = $query->select(
                        'id', 
                        'user_id', 
                        'category_id', 
                        'title', 
                        'slug', 
                        'excerpt', 
                        'featured_image', 
                        'published_at'
                    )
                    ->orderBy('published_at', 'desc')
                    ->paginate(9);

        return view('blog.index', compact('posts', 'categories'));
    }

public function show($slug)
    {
        $post = Post::with(['category', 'user', 'tags'])
                    ->where('slug', $slug)
                    ->where('is_published', true)
                    ->firstOrFail();

        $relatedPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id) 
                            ->where('is_published', true)
                            ->take(3)
                            ->get();

        if ($relatedPosts->count() < 3) {
            $morePosts = Post::where('id', '!=', $post->id)
                             ->where('is_published', true)
                             ->whereNotIn('id', $relatedPosts->pluck('id'))
                             ->take(3 - $relatedPosts->count())
                             ->get();
            $relatedPosts = $relatedPosts->merge($morePosts);
        }

        $categories = Category::has('posts')->select('id', 'name', 'slug')->get();

        return view('blog.show', compact('post', 'categories', 'relatedPosts'));
    }

    /**
     * Display posts by category.
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::has('posts')->select('id', 'name', 'slug')->get();

        $posts = $category->posts()
                          ->with('user')
                          ->where('is_published', true)
                          ->select(
                              'id', 
                              'user_id', 
                              'category_id', 
                              'title', 
                              'slug', 
                              'excerpt', 
                              'featured_image', 
                              'published_at'
                          )
                          ->orderBy('published_at', 'desc')
                          ->paginate(9);

        return view('blog.index', compact('posts', 'categories', 'category'));
    }

    /**
     * Display posts by tag.
     */
    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $categories = Category::has('posts')->select('id', 'name', 'slug')->get();

        $posts = $tag->posts()
                     ->with(['user', 'category', 'tags'])
                     ->where('is_published', true)
                     ->orderBy('published_at', 'desc')
                     ->paginate(9);

        return view('blog.index', compact('posts', 'categories', 'tag'));
    }
}
