@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Post</div>

                    <div class="card-body">
                    <form action="{{ route('posts.update', $post->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Form fields for editing -->
                        <input type="text" name="title" value="{{ $post->title }}">
                        <textarea name="body">{{ $post->body }}</textarea>
                        <!-- Submit button -->
                        <button type="submit">Update Post</button>
                    </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
