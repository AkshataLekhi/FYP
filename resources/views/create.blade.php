<!DOCTYPE html>
<html lang="en">

{{-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Create Post</title>
</head> --}}

<body>

    <a href="{{ url('/mainPage') }}" class="back-arrow">
        <i class="bi bi-arrow-left"></i>
    </a>

    <div class="container">
        <div class="post-card">
            <h2 class="title">Create Your Post</h2>

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <input type="text" name="title" id="title" placeholder="Add Caption" class="input-field" required>
                <input type="text" name="description" id="description" placeholder="Description" class="input-field" required>
                <input type="file" name="picture" id="imageInput" accept="image/*" class="input-field" required>
                <input type="text" name="option_one" placeholder="Option 1" class="input-field">
                <input type="text" name="option_two" placeholder="Option 2" class="input-field">

                <button type="submit" class="post-btn">Post</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/create.js') }}"></script>

</body>

</html>
