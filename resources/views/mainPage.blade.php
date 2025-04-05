<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        <input type="search" name="search" class="search" id="searchInput" placeholder="Search">
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
    <div class="container mt-4">
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top" alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->description }}</p>
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ratingModal-{{ $post->id }}">Rate</button>
                        </div>
                    </div>
                </div>

                <!-- Rating Modal -->
                <div class="modal fade" id="ratingModal-{{ $post->id }}" tabindex="-1" aria-labelledby="ratingLabel{{ $post->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ url('/rating') }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ratingLabel{{ $post->id }}">Rate {{ $post->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="rating-css">
                                        <div class="star-icon">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" value="{{ $i }}" name="product_rating" id="rating{{ $post->id }}_{{ $i }}" {{ $i == 1 ? 'checked' : '' }}>
                                                <label for="rating{{ $post->id }}_{{ $i }}" class="bi bi-star-fill"></label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="{{ asset('js/mainPage.js') }}"></script>
</body>
</html>
