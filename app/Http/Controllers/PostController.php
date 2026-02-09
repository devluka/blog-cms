<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image; 

class PostController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'body' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', 
            'meta_description' => 'nullable|string|max:160',
            'meta_keyword' => 'nullable|string|max:255',
        ]);

        $imagePath = null;

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.webp';
            
            if (!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }

            $path = storage_path('app/public/posts/' . $filename);

            Image::read($image)
                ->scale(width: 1200)
                ->toWebp(quality: 80)
                ->save($path);

            $imagePath = 'posts/' . $filename;
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'body' => $request->body,
            'excerpt' => Str::limit(html_entity_decode(strip_tags($request->body)), 150),
            'featured_image' => $imagePath,
            'is_published' => $request->has('is_published'),
            'published_at' => $request->has('is_published') ? now() : null,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
        ]);

        if ($request->filled('tags')) {
            $this->syncTags($post, $request->tags);
        }

        return redirect()->route('dashboard')->with('status', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'body' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'meta_description' => 'nullable|string|max:160',
            'meta_keyword' => 'nullable|string|max:255',
        ]);

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'body' => $request->body,
   
            'excerpt' => Str::limit(html_entity_decode(strip_tags($request->body)), 150),
            'is_published' => $request->has('is_published'),
            'published_at' => $request->has('is_published') && !$post->published_at ? now() : $post->published_at,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
        ];

        if ($request->has('remove_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.webp';
            
            if (!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }

            $path = storage_path('app/public/posts/' . $filename);

            Image::read($image)
                ->scale(width: 1200)
                ->toWebp(quality: 80)
                ->save($path);

            $data['featured_image'] = 'posts/' . $filename;
        }

        $post->update($data);

        $this->syncTags($post, $request->tags);

        return redirect()->route('dashboard')->with('status', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete(); 

        return redirect()->route('dashboard')->with('status', 'Post deleted!');
    }

    private function syncTags(Post $post, ?string $tagsInput)
    {
        if (!$tagsInput) {
            $post->tags()->detach();
            return;
        }

        $tagNames = explode(',', $tagsInput);
        $tagIds = [];

        foreach ($tagNames as $name) {
            $name = trim($name);
            if (empty($name)) continue;

            $tag = Tag::firstOrCreate(
                ['name' => $name], // Search by name
                ['slug' => Str::slug($name)] // Create with slug if new
            );

            $tagIds[] = $tag->id;
        }

        $post->tags()->sync($tagIds);
    }
}
