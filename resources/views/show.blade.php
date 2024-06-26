@extends('app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{ $post->title }}</h3>
            <small>by {{ $post->writer }}</small>
        </div>
        <div class="card-body">
            <p>{{ $post->body }}</p>
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid">
            @endif
            <div>
                <form action="{{ route('posts.incrementLikes', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Like ({{ $post->likes }})
                    </button>
                </form>
            </div>
            <div>
                <h5>Comments</h5>
                @foreach($post->comments as $comment)
                    <p>{{ $comment->body }} - <small>{{ $comment->writer }}</small></p>
                @endforeach
                <form action="{{ route('comments.store', $post) }}" method="post">
                    @csrf
                    <div>penulis<input type="text" class="form-control" id="writer" name="writer" ></div>
                    <div>isi<textarea name="body" required></textarea></div>
                    <div><button type="submit">Comment</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('posts.destroy', $post->id) }}" method="post" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
@endsection
