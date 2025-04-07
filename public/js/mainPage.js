document.addEventListener('DOMContentLoaded', function() {
    // Like functionality
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const likeCount = this.querySelector('.like-count');

            // Toggle like state
            this.classList.toggle('liked');
            const isLiked = this.classList.contains('liked');

            // Update like count
            const currentCount = parseInt(likeCount.textContent);
            likeCount.textContent = isLiked ? currentCount + 1 : currentCount - 1;

            // Send AJAX request
            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ liked: isLiked })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeCount.textContent = data.likes_count;
                } else {
                    // Revert UI if failed
                    this.classList.toggle('liked');
                    likeCount.textContent = currentCount;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.classList.toggle('liked');
                likeCount.textContent = currentCount;
            });
        });
    });

    // Comment form submission
    document.querySelectorAll('.add-comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const formData = new FormData(this);
            const commentSection = this.closest('.modal-content').querySelector('.comments-section');
            const commentCount = document.querySelector(`.comment-btn[data-post-id="${postId}"] .comment-count`);

            fetch(`/posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new comment to the list
                    const newComment = document.createElement('div');
                    newComment.innerHTML = `
                        <div class="comment">
                            <strong>${data.comment.user.name}</strong>
                            <p>${data.comment.content}</p>
                            <small class="text-muted">Just now</small>
                        </div>
                        <hr>
                    `;
                    commentSection.appendChild(newComment);

                    // Update comment count
                    if (commentCount) {
                        commentCount.textContent = parseInt(commentCount.textContent) + 1;
                    }

                    // Clear form
                    this.reset();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Delete functionality
    let postToDelete = null;
    const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            postToDelete = this.dataset.postId;
            deleteConfirmModal.show();
        });
    });

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (!postToDelete) return;

        fetch(`/posts/${postToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`.pinterest-card[data-post-id="${postToDelete}"]`).remove();
            }
            deleteConfirmModal.hide();
            postToDelete = null;
        })
        .catch(error => {
            console.error('Error:', error);
            deleteConfirmModal.hide();
            postToDelete = null;
        });
    });

    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const likeButtons = document.querySelectorAll('.like-btn');

    // Get liked posts from localStorage
    let likedPostData = JSON.parse(localStorage.getItem('likedPosts')) || {};

    // Show already liked posts and counts
    likeButtons.forEach(button => {
        const postId = button.dataset.postId;
        const icon = button.querySelector('i');
        const countSpan = button.querySelector('.like-count');

        if (likedPostData[postId]) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
            countSpan.textContent = likedPostData[postId];
        }
    });

    // Handle like/unlike
    likeButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const postId = this.dataset.postId;
            const icon = this.querySelector('i');
            const countSpan = this.querySelector('.like-count');

            let count = parseInt(countSpan.textContent);

            if (likedPostData[postId]) {
                // Unlike
                delete likedPostData[postId];
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                count = Math.max(0, count - 1);
            } else {
                // Like
                likedPostData[postId] = count + 1;
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                count = count + 1;
            }

            countSpan.textContent = count;
            localStorage.setItem('likedPosts', JSON.stringify(likedPostData));
        });
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const saveButtons = document.querySelectorAll('.save-btn');

    // Load saved posts from localStorage
    let savedPostIds = JSON.parse(localStorage.getItem('savedPosts')) || [];

    // Highlight already saved posts
    savedPostIds.forEach(id => {
        const icon = document.querySelector(`.save-btn[data-post-id="${id}"] i`);
        if (icon) {
            icon.classList.remove('bi-bookmark');
            icon.classList.add('bi-bookmark-fill');
        }
    });

    // Handle save button clicks
    saveButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const icon = this.querySelector('i');

            if (savedPostIds.includes(postId)) {
                // Unsave
                savedPostIds = savedPostIds.filter(id => id !== postId);
                icon.classList.remove('bi-bookmark-fill');
                icon.classList.add('bi-bookmark');
            } else {
                // Save
                savedPostIds.push(postId);
                icon.classList.remove('bi-bookmark');
                icon.classList.add('bi-bookmark-fill');
            }

            // Store in localStorage
            localStorage.setItem('savedPosts', JSON.stringify(savedPostIds));
        });
    });
});
