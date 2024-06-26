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
        $post = posts::with('writer', 'comments', 'likes')->findOrFail($id);
        return view('show', compact('post'));
    }
    public function edit($id)
    {
        $post = posts::findOrFail($id);
        return view('edit', compact('post'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'writer' => 'required',
            'body' => 'required',
            'image' => 'nullable|image',
        ]);
    
        $post = posts::findOrFail($id);
        $post->title = $request->title;
        $post->writer = $request->writer;
        $post->body = $request->body;
    
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($post->image) {
                Storage::delete($post->image);
            }
            $post->image = $request->file('image')->store('images');
        }
    
        $post->save();
    
        return redirect()->route('show', $post->id)->with('success', 'posts updated successfully.');
    }
    public function destroy($id)
    {
        $post = posts::findOrFail($id);
    
        // Delete the image if exists
        if ($post->image) {
            Storage::delete($post->image);
        }
    
        $post->delete();
    
        return redirect()->route('index')->with('success', 'posts deleted successfully.');
    }
    public function incrementLikes($id)
    {
        $post = posts::findOrFail($id);
        $post->likes = $post->likes + 1;
        $post->save();

        return redirect()->route('show', $post)->with('success', 'Post liked successfully.');
    }    
}
