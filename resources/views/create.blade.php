<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Create Post</title>
</head>

<body>

    <a href="{{ url('/mainPage') }}" class="back-arrow">
        <i class="bi bi-arrow-left"></i>
    </a>

    <div class="container">
        <div class="post-card">
            <h2 class="title">Create Your Post</h2>

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">

            {{-- <form id="postForm" enctype="multipart/form-data"> --}}
                @csrf

                <input type="text" name="title" id="title" placeholder="Title" class="input-field" required>
                <input type="text" name="description" id="description" placeholder="Description" class="input-field" required>
                <input type="url" name="links" id="links" placeholder="Links (Optional)" class="input-field">
                <input type="file" name="picture" id="imageInput" accept="image/*" class="input-field" required>
                <button type="submit" class="post-btn">Post</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/create.js') }}"></script>


    {{-- <script>
        document.getElementById("postForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const fileInput = document.getElementById("imageInput").files[0];
            const title = document.getElementById("title").value;
            const description = document.getElementById("description").value;
            const link = document.getElementById("links").value;

            if (!fileInput) {
                alert("Please select an image to upload!");
                return;
            }

            const reader = new FileReader();
            reader.readAsDataURL(fileInput); // Convert image to Base64

            reader.onload = function () {
                const imageUrl = reader.result; // Base64 string of the image
                saveUserPost(imageUrl, title, description, link);
            };
        });

        function saveUserPost(imageUrl, title, description, link) {
            let posts = JSON.parse(localStorage.getItem("userPosts")) || [];

            let newPost = {
                image: imageUrl,
                title: title || "Untitled Post",
                description: description || "No Description",
                link: link || "#"
            };

            posts.unshift(newPost); // Add new post at the beginning
            localStorage.setItem("userPosts", JSON.stringify(posts));

            window.location.href = "{{ route('mainPage') }}"; // Redirect to main page
        }
    </script> --}}

</body>

</html>
