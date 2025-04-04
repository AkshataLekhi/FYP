<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/mainPage.css') }}">
    <title>MAIN PAGE</title>
</head>

<body>

    <!-- Navigation Bar -->
    <nav>
        <a class="logo" href="#">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo">
        </a>
        <a href="#" class="active">Home</a>
        <a href="{{ route('create') }}">Create</a>
        <input type="search" name ="search" class="search" id="searchInput" placeholder="Search">
        <a href="{{ route('profile') }}"><i class="bi bi-person-fill"></i></a>
        <a href="#"><i class="bi bi-bell-fill"></i></a>
        <a href="#"><i class="bi bi-chat-heart-fill"></i></a>
        <a href="#"><i class="bi bi-clock-history"></i></a>

        <a href="#" onclick="document.getElementById('logout-form').submit();" style="cursor: pointer;">
            <i class="bi bi-box-arrow-right"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>

    <!-- Image Container -->
   <div id="container" class="row row-cols-1 row-cols-md-3 g-4 m-4">
    @foreach ($posts as $post)
        <div class="col">
            <div class="card h-100" onclick="openModal('{{ asset('storage/' . $post->picture) }}', '{{ $post->title }}', '{{ $post->description }}')">
                <img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top" alt="{{ $post->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>


    <!-- Image Modal -->
    <div class="modal" id="postModal">
        <div class="modal-content">

            <span class="close-btn" onclick="closeModal()">&times;</span>
            <img id="modalImage" class="modal-img" alt="Modal Image">
            <h3 id="modalTitle"></h3>
            <p id="modalDescription"></p>

            <div class="action-buttons">
                <button onclick="likePost()"><i class="bi bi-heart-fill"></i></button>
                <button onclick="commentPost()"><i class="bi bi-chat-left-heart-fill"></i></button>
                <button onclick="savePost()"><i class="bi bi-bookmark-heart-fill"></i></button>
                <button onclick="deletePost()"><i class="bi bi-trash3-fill"></i></button>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">

                <form action="{{ '/rating' }}" method="POST">
                    @csrf
                    {{-- <input type="hidden" name="product_id"> --}}

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">RATE ME !</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="rating-css">
                            <div class="star-icon">
                                <input type="radio" value="1" name="product_rating" checked id="rating1">
                                <label for="rating1" class="bi bi-star-fill"></label>
                                <input type="radio" value="2" name="product_rating" id="rating2">
                                <label for="rating2" class="bi bi-star-fill"></label>
                                <input type="radio" value="3" name="product_rating" id="rating3">
                                <label for="rating3" class="bi bi-star-fill"></label>
                                <input type="radio" value="4" name="product_rating" id="rating4">
                                <label for="rating4" class="bi bi-star-fill"></label>
                                <input type="radio" value="5" name="product_rating" id="rating5">
                                <label for="rating5" class="bi bi-star-fill"></label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn" style="background-color: #e60000; color: white;">
                        Submit
                    </button>

                </form>

                </div>
                </div>
            </div>

            <div class="d-flex justify-content-center my-3">
            <button type="button" class="custom-small-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                RATE
            </button>
            </div>


        </div>
    </div>

    <!-- Comment Popup Modal -->
    <div id="commentPopup" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeCommentModal()">&times;</span>
            <h3>Post a Comment</h3>
            <textarea id="commentInput" placeholder="Write your comment..."></textarea>
            <button onclick="submitComment()">Submit</button>
        </div>
    </div>

    <script src="{{ asset('js/mainPage.js') }}"></script>

</body>

</html>
