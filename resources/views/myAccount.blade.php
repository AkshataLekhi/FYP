<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Your Account</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
</head>
<body>
    <div class="profile-section">

        <a href="{{ url('/mainPage') }}" class="back-arrow">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h2>All About Your Profile</h2>

        <a href="{{ route('profile') }}" class="profile-edit-btn">
            <i class="bi bi-pencil-square"></i> Edit Profile
        </a>

    </div>
    <div class="tabs">
        <a href="#" class="tab-link active" data-target="posts">Your Posts</a>
        <a href="#" class="tab-link" data-target="saves">Your Saves</a>
    </div>

    <!-- Tab Contents -->
    <div id="posts" class="tab-content">
            <div class="pinterest-container">
            <div class="pinterest-grid">
            @foreach ($posts as $post)
                <div class="pinterest-card" data-post-id="{{ $post->id }}">
                    <div class="card">
                        <img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top" alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->description }}</p>

                            <!-- Inside each post card -->
                        <div class="action-buttons">
                            <a href="#" class="action-btn edit-btn"
                                data-post-id="{{ $post->id }}"
                                data-title="{{ $post->title }}"
                                data-description="{{ $post->description }}">
                                <i class="bi bi-pen"></i>
                            </a>
                            <a href="#" class="action-btn delete-btn" data-id="{{ $post->id }}">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </div>

                        <div id="editModal" class="modal">
                            <div class="modal-content">
                                <h3>Edit Your Post</h3>
                                <form id="editPostForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="editPostId" name="post_id">

                                    <div>
                                        <label>Title:</label>
                                        <input type="text" id="editTitle" name="title">
                                    </div>

                                    <div>
                                        <label>Description:</label>
                                        <textarea id="editDescription" name="description" rows="4"></textarea>
                                    </div>

                                    <button type="submit">Save Changes</button>
                                    <button type="button" id="closeModal">Cancel</button>
                                </form>
                            </div>
                        </div>


                        </div>
                    </div>
                </div>

            @endforeach
            </div>
            </div>
    </div>

    <div id="saves" class="tab-content">

        <!-- You can show saved items here -->
        
    </div>

    <script src="{{ asset('js/account.js') }}"></script>

</body>
</html>
