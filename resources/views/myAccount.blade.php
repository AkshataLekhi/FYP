<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Account</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
</head>
<body>

    <div class="profile-section text-center">
        <!-- Back Arrow -->
        <a href="{{ url('/mainPage') }}" class="back-arrow">
            <i class="bi bi-arrow-left"></i>
        </a>

        <!-- Heading -->
        <h2 class="profile-heading">Welcome {{ Auth::user()->name }} !</h2>

        <!-- Buttons side by side -->
        <div class="button-row">
            <a href="{{ route('profile') }}" class="btn btn-edit">
                <i class="bi bi-pencil-square"></i> Edit Profile
            </a>

            <form method="POST" action="{{ route('account.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">
                    <i class="bi bi-trash"></i> Delete Account
                </button>
            </form>
        </div>
    </div>

    <div class="tabs">
        <a href="#" class="tab-link active" data-target="posts">Your Posts</a>
        <a href="#" class="tab-link" data-target="saves">Your Saves</a>
        {{-- <a href="#" class="tab-link" data-target="followers">Followers</a>
<a href="#" class="tab-link" data-target="following">Following</a> --}}

    </div>

    <!-- Tab Contents -->
    <div id="posts" class="tab-content active">
        <div class="pinterest-container">
            <div class="pinterest-grid">
                @foreach ($posts as $post)
                    <div class="pinterest-card" data-post-id="{{ $post->id }}">
                        <div class="card">
                            <img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top" alt="{{ $post->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ $post->description }}</p>
                                <!-- Action buttons -->
                                <div class="action-buttons d-flex justify-content-between">

                                    <div class="management-actions">
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
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Comment Modal -->
                    <div class="modal fade" id="commentModal-{{ $post->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('comments.store') }}" method="POST" class="modal-content shadow-lg border-0 rounded-4">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">

                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-semibold">Comments on <span class="text-danger">"{{ $post->title }}"</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body pt-0">
                                    <div class="comments-section mb-4" style="max-height: 250px; overflow-y: auto;">
                                        @if($post->comments->count())
                                            @foreach($post->comments as $comment)
                                                <div class="mb-3">
                                                    <div class="fw-bold text-dark">{{ $comment->user->name }}</div>
                                                    <div class="text-muted">{{ $comment->content }}</div>
                                                    <small class="text-secondary fst-italic">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                <hr class="text-secondary">
                                            @endforeach
                                        @else
                                            <p class="text-muted">No comments yet. Be the first to comment!</p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="commentContent-{{ $post->id }}" class="fw-semibold mb-1">Add a Comment:</label>
                                        <textarea name="content" class="form-control rounded-3 shadow-sm" id="commentContent-{{ $post->id }}" rows="3" placeholder="Write something nice..." required></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer border-0 pt-0">
                                    <button type="submit" class="btn btn-danger rounded-pill px-4">Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="saves" class="tab-content">
        <div class="pinterest-container">
            <div class="pinterest-grid">
                @if (!empty($savedPosts) && $savedPosts->count())
                    @foreach ($savedPosts as $post)
                        <div class="pinterest-card" data-post-id="{{ $post->id }}">
                            <div class="card">
                                <img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top" alt="{{ $post->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                    <p class="card-text">{{ $post->description }}</p>
                                    <p class="text-muted small">Posted by {{ $post->user->name }}</p>

                                    <div class="action-buttons d-flex justify-content-between">
                                        <div class="save-actions">
                                            <a href="#" class="action-btn unsave-btn text-danger" data-post-id="{{ $post->id }}">
                                                <i class="bi bi-bookmark-x-fill"></i> Unsave
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No saved posts found.</p>
                @endif
            </div>
        </div>
    </div>


    <!-- Edit Post Modal -->
    <div class="modal fade" id="editPostModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="editPostForm" method="POST" class="modal-content shadow-lg border-0 rounded-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="editPostId" name="post_id">

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-semibold">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body pt-0">
                    <div class="form-group mb-3">
                        <label for="editTitle" class="fw-semibold mb-1">Title:</label>
                        <input type="text" name="title" class="form-control rounded-3 shadow-sm" id="editTitle" required>
                    </div>

                    <div class="form-group">
                        <label for="editDescription" class="fw-semibold mb-1">Description:</label>
                        <textarea name="description" class="form-control rounded-3 shadow-sm" id="editDescription" rows="4" required></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/account.js') }}"></script>
</body>
</html>
