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
