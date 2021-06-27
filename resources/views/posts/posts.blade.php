<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>

<!-- CONTENT -->
<div class="container">

    <div class="new-post">
        <h2>Create a new post</h2>
        @if($errors->all())
            {{ var_dump($errors->all()) }}
        @endif
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <label for="title" >Title:</label><br>
            <textarea class="input" id="title" name="title" style="resize: none"></textarea><br>
            <label for="description">Description:</label><br>
            <textarea class="input" id="description" name="description" style="resize: vertical" rows="5"> </textarea><br><br>
            <input type="submit" value="Post it!">
        </form>
    </div><br>

    <div class="feed">
        <h2>Feed</h2>
        @foreach($posts as $post)
            <table id="post">
                <tr>
                    <td id="fixed">Title</td><td id="title">{{$post->title}}</td><br>
                    <td id="delete-button">
                        <form method="POST" action="{{ route('posts.destroy', $post->post_id ) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td id="fixed">Description</td><td id="description">{{$post->description}}</td>
                </tr>
            </table>
        @endforeach
    </div>
</div>

</body>
</html>

<script>
</script>

