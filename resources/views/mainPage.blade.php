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
        <a href="{{ route('mainPage') }}" class="active">Home</a>
        <a href="{{ route('create') }}">Create</a>

        {{-- <input type="search" name="search" class="search" id="searchInput" placeholder="Search"> --}}

        <form method="GET" action="{{ route('mainPage') }}" class="d-flex align-items-center">
            <input type="search" name="search" class="search" id="searchInput" placeholder="Search..." value="{{ request('search') }}">
        </form>

        <div class="nav-icons">
            <a href="{{ route('account') }}"><i class="bi bi-person-fill"></i></a>

            {{-- <a href="#"><i class="bi bi-bell-fill"></i></a> --}}

            {{-- Notification Section --}}
            <div class="notification-wrapper position-relative">
                <i class="bi bi-bell notification-bell" onclick="toggleNotificationBox()"></i>

                @if($notifications->where('is_read', false)->count())
                    <span class="notif-dot"></span>
                @endif

                <div class="notif-popup" id="notifPopup" style="display: none;">
                    @forelse ($notifications as $notif)
                        <div class="notif-card" onclick="markAsRead({{ $notif->id }})">
                            <div class="notif-message">{{ $notif->message }}</div>
                            <div class="notif-time text-muted small">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="notif-card text-muted">No notifications yet..</div>
                    @endforelse
                </div>
            </div>


            <a href="{{ url('/chatify') }}"><i class="bi bi-chat-heart-fill"></i></a>
            <a href="#"><i class="bi bi-clock-history"></i></a>
            <a href="#" onclick="document.getElementById('logout-form').submit();" style="cursor: pointer;">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>

    <!-- Pinterest Style Image Container -->
    <div class="pinterest-container">
        <div class="pinterest-grid">

            @foreach ($posts as $post)
                <div class="pinterest-card" data-post-id="{{ $post->id }}">
                    <div class="card">
                        <img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top" alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->description }}</p>

                            <div class="card-actions d-flex align-items-center gap-2">
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ratingModal-{{ $post->id }}">
                                    Rate
                                </button>

                                @if($post->poll)
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#pollModal-{{ $post->id }}" title="Vote Now!">
                                        <i class="bi bi-bar-chart"></i>
                                    </button>
                                @endif

                                <div class="action-buttons ms-auto d-flex gap-2">

                                    <a href="#" class="action-btn like-btn" data-post-id="{{ $post->id }}">
                                        <i class="bi {{ $post->likes->contains(auth()->id()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        <span class="like-count">{{ $post->likes->count() }}</span>
                                    </a>

                                    <a href="#" class="action-btn comment-btn" data-bs-toggle="modal" data-bs-target="#commentModal-{{ $post->id }}">
                                        <i class="bi bi-chat"></i>
                                        <span class="comment-count">{{ $post->comments_count}}</span>
                                    </a>

                                    <a href="#" class="action-btn save-btn" data-post-id="{{ $post->id }}">
                                        <i class="bi bi-bookmark"></i>
                                    </a>
                                </div>
                            </div>
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
                                    <h5 class="modal-title" id="ratingLabel{{ $post->id }}">RATE "{{ $post->title }}"</h5>
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


                <!-- Poll Modal -->
                @if($post->poll)
                <div class="modal fade" id="pollModal-{{ $post->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <form action="{{ route('poll.vote') }}" method="POST" class="modal-content shadow border-0 rounded-4 p-3">
                            @csrf
                            <input type="hidden" name="poll_id" value="{{ $post->poll->id }}">

                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-semibold text-danger">📊 Participate in Poll</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="vote" value="1" id="poll1-{{ $post->id }}" checked>
                                    <label class="form-check-label fs-6 fw-medium" for="poll1-{{ $post->id }}">
                                        {{ $post->poll->option_one }}
                                    </label>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="radio" name="vote" value="2" id="poll2-{{ $post->id }}">
                                    <label class="form-check-label fs-6 fw-medium" for="poll2-{{ $post->id }}">
                                        {{ $post->poll->option_two }}
                                    </label>
                                </div>

                                <div class="poll-results border-top pt-3 mt-3">
                                    <p class="text-muted mb-1 fw-semibold">📈 Current Votes:</p>
                                    <div class="d-flex justify-content-between px-2">
                                        <span>{{ $post->poll->option_one }}:</span>
                                        <span class="fw-bold">{{ $post->poll->votes_one }} votes</span>
                                    </div>
                                    <div class="d-flex justify-content-between px-2">
                                        <span>{{ $post->poll->option_two }}:</span>
                                        <span class="fw-bold">{{ $post->poll->votes_two }} votes</span>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer border-0 pt-0">
                                <button type="submit" class="btn btn-danger rounded-pill px-4">Vote</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif



            @endforeach
        </div>
    </div>

    <script src="{{ asset('js/mainPage.js') }}"></script>
</body>
</html>
