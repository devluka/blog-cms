<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Models\Category;

class ContactController extends Controller
{
    public function show()
    {
        $categories = Category::has('posts')->select('id', 'name', 'slug')->get();
        return view('contact', compact('categories'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        // 2. Send Email
        \Mail::to('hello@deployte.com')->send(new \App\Mail\ContactFormMail($validated));

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Message sent successfully!']);
        }

    
        return back()->with('success', 'Message sent successfully!');
    }
}