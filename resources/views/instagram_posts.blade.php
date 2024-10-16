<!DOCTYPE html>
<html>
<head>
    <title>Instagram Posts</title>
</head>
<body>
    <h1>Instagram Posts</h1>
    @foreach ($posts as $post)
        <div>
            <h3>{{ $post->caption }}</h3>
            <a href="{{ $post->permalink }}" target="_blank">
                <img src="{{ $post->media_url }}" width="300" />
            </a>
            <p>Posted at: {{ $post->posted_at }}</p>
        </div>
    @endforeach
</body>
</html>
