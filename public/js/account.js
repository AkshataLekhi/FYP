    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // DELETE POST
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const postId = this.getAttribute('data-id');

            if (confirm("Are you sure you want to delete this post?")) {
                fetch(`/posts/${postId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete post');
                    }
                    // Remove post card from DOM
                    const postCard = document.querySelector(`[data-post-id="${postId}"]`);
                    if (postCard) {
                        postCard.remove();
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    alert("Failed to delete post.");
                });
            }
        });
    });

    // EDIT POST
    const editModal = document.getElementById('editModal');
    const closeModal = document.getElementById('closeModal');
    const editForm = document.getElementById('editPostForm');

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const postId = this.getAttribute('data-post-id');
            const title = this.getAttribute('data-title');
            const description = this.getAttribute('data-description');

            // Populate modal form
            document.getElementById('editPostId').value = postId;
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;

            // Update form action
            editForm.setAttribute('action', `/posts/${postId}`);

            // Show the modal
            editModal.style.display = 'block';
        });
    });

    // CLOSE MODAL
    closeModal.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        // Only trigger edit modal if it's inside a post card
        if (button.closest('.pinterest-card')) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                // your modal code...
            });
        }
    });


    document.querySelectorAll('.tab-link').forEach(tab => {
        tab.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active class from all tabs
            document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            // Show selected tab content
            const targetId = this.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
        });
    });

    // Show posts by default
    document.getElementById('posts').classList.add('active');
