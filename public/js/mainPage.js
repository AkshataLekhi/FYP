document.addEventListener('DOMContentLoaded', function () {

    // LIKE FUNCTIONALITY (❤️)
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();

            const postId = this.dataset.postId;
            const icon = this.querySelector('i');
            const countSpan = this.querySelector('.like-count');
            const token = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch("/like", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ post_id: postId })
                });

                const data = await response.json();

                if (data.liked) {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                } else {
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                }

                countSpan.textContent = data.likeCount;
            } catch (error) {
                console.error('Like failed:', error);
            }
        });
    });

    // COMMENT FUNCTIONALITY (💬)
    document.querySelectorAll('.add-comment-form').forEach(form => {
        form.addEventListener('submit', function (e) {
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

                    if (commentCount) {
                        commentCount.textContent = parseInt(commentCount.textContent) + 1;
                    }

                    this.reset();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // DELETE POST FUNCTIONALITY (🗑️)
    let postToDelete = null;
    const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            postToDelete = this.dataset.postId;
            deleteConfirmModal.show();
        });
    });

    document.getElementById('confirmDelete').addEventListener('click', function () {
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

    // SAVE POST FUNCTIONALITY (🔖)
    const saveButtons = document.querySelectorAll('.save-btn');
    let savedPostIds = JSON.parse(localStorage.getItem('savedPosts')) || [];

    savedPostIds.forEach(id => {
        const icon = document.querySelector(`.save-btn[data-post-id="${id}"] i`);
        if (icon) {
            icon.classList.remove('bi-bookmark');
            icon.classList.add('bi-bookmark-fill');
        }
    });

    saveButtons.forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const icon = this.querySelector('i');
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const isSaved = icon.classList.contains('bi-bookmark-fill');

            try {
                const response = await fetch(`/posts/${postId}/${isSaved ? 'unsave' : 'save'}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    icon.classList.toggle('bi-bookmark-fill');
                    icon.classList.toggle('bi-bookmark');
                }
            } catch (error) {
                console.error('Error saving post:', error);
            }
        });
    });
});

// TOOLTIPS (✨)
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el);
    });

// Notification

    function toggleNotificationBox() {
        const popup = document.getElementById('notifPopup');
        popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
    }

    document.querySelectorAll('.follow-btn').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            const btn = this;

            fetch(`/follow/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'followed') {
                    btn.innerHTML = '<i class="bi bi-person-check-fill"></i> Following';
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-success');
                } else if (data.status === 'unfollowed') {
                    btn.innerHTML = '<i class="bi bi-person-plus-fill"></i> Follow';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-primary');
                }
            })
            .catch(err => console.error(err));
        });
    });
