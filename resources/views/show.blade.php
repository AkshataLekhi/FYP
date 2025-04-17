<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>

    <!-- Bootstrap CSS and Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>

    <a href="{{ route('mainPage') }}" class="btn btn-outline-danger">
        <i class="bi bi-arrow-left"></i>
    </a>

<div class="container py-4">
    <div class="row">
        <!-- Left: Post Image -->
        <div class="col-md-6 text-center">
            <img src="{{ asset('storage/' . $post->picture) }}" alt="{{ $post->title }}" class="img-fluid rounded">
        </div>

        <!-- Right: Post Info -->
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="fw-bold">{{ $post->user->name }}</div>
                    <p class="text-muted small">Posted {{ $post->created_at->diffForHumans() }}</p>
                </div>

                <div class="d-flex gap-2">
                    {{-- LIKE --}}
                    <form method="POST" action="{{ route('like.toggle', $post->id) }}">
                        @csrf
                        <button class="btn btn-light">
                            <i class="bi {{ auth()->user() && $post->likes->contains(auth()->id()) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                            {{ $post->likes->count() }}
                        </button>
                    </form>

                    <!-- SAVE / UNSAVE BUTTON -->
                    @php
                        $isSaved = auth()->user() && auth()->user()->savedPosts->contains($post->id);
                    @endphp

                    <form method="POST" action="{{ $isSaved ? route('posts.unsave', $post->id) : route('posts.save', $post->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-light">
                            <i class="bi {{ $isSaved ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                        </button>
                    </form>



                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ratingModal-{{ $post->id }}">
                        Rate
                    </button>

                    @if($post->poll)
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#pollModal-{{ $post->id }}" title="Vote Now!">
                            <i class="bi bi-bar-chart"></i>
                        </button>
                    @endif
                </div>
            </div>

            <h4>{{ $post->title }}</h4>
            <p>{{ $post->description }}</p>

            <hr>

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

            <form action="{{ route('comments.store') }}" method="POST" class="d-flex align-items-center gap-2 mb-3">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="text" name="content" class="form-control" placeholder="Add a comment..." required>
                <button type="submit" class="btn btn-danger">Post</button>
            </form>

            @foreach ($post->comments as $comment)
                <div class="mb-3">
                    <strong>{{ $comment->user->name }}</strong>
                    <p>{{ $comment->content }}</p>
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
