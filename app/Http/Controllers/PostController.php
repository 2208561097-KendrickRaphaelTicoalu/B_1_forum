<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\posts;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = posts::with('comments')->get();
        return view('index', compact('posts'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'writer' => 'required',
            'body' => 'required',
            'image' => 'nullable|image',
        ]);

        $post = new posts;
        $post->writer = $request->writer;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->likes = 0;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = null;
        }
        $post->save();

        return redirect()->route('posts.index');
    }

    public function show($id)
    {
        $post = posts::with('comments')->findOrFail($id);
        return view('show', compact('post'));
    }
    public function edit($id)
    {
        $post = posts::findOrFail($id);
        return view('edit', compact('post'));
    }
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            // Add other fields you want to validate
        ]);

        // Find the post by ID
        $post = posts::findOrFail($id);

        // Update the post with the new data
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // Update other fields as needed

        // Save the updated post
        $post->save();

        // Redirect back to the post details page with a success message
        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully.');
    }
    public function destroy($id)
    {
        $post = posts::findOrFail($id);
    
        // Delete the image if exists
        if ($post->image) {
            Storage::delete($post->image);
        }
    
        $post->delete();
    
        return redirect()->route('posts.index')->with('success', 'posts deleted successfully.');
    }
    public function incrementLikes($id)
    {
        $post = posts::findOrFail($id);
        $post->likes = $post->likes + 1;
        $post->save();

        return redirect()->route('posts.show', $post)->with('success', 'Post liked successfully.');
    }    
}
