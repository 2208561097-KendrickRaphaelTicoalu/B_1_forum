<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comments;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $comment = new comments();
        $comment->post_id = $postId;
        $comment->writer = $request->writer;
        $comment->body = $request->body;
        $comment->save();

        return redirect()->route('posts.show', $postId)->with('success', 'Comment added successfully.');
    }
}
