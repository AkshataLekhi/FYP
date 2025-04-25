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


    document.querySelectorAll('.tab-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active class from all tabs
            document.querySelectorAll('.tab-link').forEach(tab => {
                tab.classList.remove('active');
            });

            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });

            // Add active class to clicked tab
            this.classList.add('active');

            // Show the corresponding tab content
            const target = this.getAttribute('data-target');
            document.getElementById(target).style.display = 'block';
        });
    });

    // Show the first tab content by default
    document.querySelectorAll('.tab-content').forEach((el, index) => {
        el.style.display = index === 0 ? 'block' : 'none';
    });

    // Show posts by default
    document.getElementById('posts').classList.add('active');


    document.addEventListener('DOMContentLoaded', () => {
        const savedTab = document.querySelector('.tab-link[data-target="saves"]');
        const postsTab = document.querySelector('.tab-link[data-target="posts"]');
        const savesContent = document.getElementById('saves');
        const postsContent = document.getElementById('posts');
        const savedPostIds = JSON.parse(localStorage.getItem('savedPosts')) || [];

        savedTab.addEventListener('click', () => {
            postsContent.style.display = 'none';
            savesContent.style.display = 'block';

            const allPosts = document.querySelectorAll('#posts .pinterest-card');
            savesContent.innerHTML = '<div class="pinterest-container"><div class="pinterest-grid"></div></div>';
            const savesGrid = savesContent.querySelector('.pinterest-grid');

            allPosts.forEach(card => {
                const postId = card.dataset.postId;
                if (savedPostIds.includes(postId)) {
                    savesGrid.appendChild(card.cloneNode(true));
                }
            });
        });

        postsTab.addEventListener('click', () => {
            postsContent.style.display = 'block';
            savesContent.style.display = 'none';
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const savedTab = document.querySelector('.tab-link[data-target="saves"]');
        const postsTab = document.querySelector('.tab-link[data-target="posts"]');
        const savesContent = document.getElementById('saves');
        const postsContent = document.getElementById('posts');
        let savedPostIds = JSON.parse(localStorage.getItem('savedPosts')) || [];

        savedTab.addEventListener('click', () => {
            postsContent.style.display = 'none';
            savesContent.style.display = 'block';

            const allPosts = document.querySelectorAll('#posts .pinterest-card');
            savesContent.innerHTML = '<div class="pinterest-container"><div class="pinterest-grid"></div></div>';
            const savesGrid = savesContent.querySelector('.pinterest-grid');

            allPosts.forEach(card => {
                const postId = card.dataset.postId;
                if (savedPostIds.includes(postId)) {
                    const clonedCard = card.cloneNode(true);

                    // Remove edit & delete buttons
                    const actionButtons = clonedCard.querySelector('.action-buttons');
                    if (actionButtons) actionButtons.remove();

                    // Add unsave button
                    const newActionButtons = document.createElement('div');
                    newActionButtons.classList.add('action-buttons');

                    const unsaveBtn = document.createElement('a');
                    unsaveBtn.href = '#';
                    unsaveBtn.classList.add('action-btn', 'unsave-btn');
                    unsaveBtn.dataset.postId = postId;
                    unsaveBtn.innerHTML = '<i class="bi bi-bookmark-fill"></i>';

                    newActionButtons.appendChild(unsaveBtn);
                    clonedCard.querySelector('.card-body').appendChild(newActionButtons);

                    savesGrid.appendChild(clonedCard);
                }
            });

            // Handle unsave click
            document.querySelectorAll('.unsave-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const postId = this.dataset.postId;
                    savedPostIds = savedPostIds.filter(id => id !== postId);
                    localStorage.setItem('savedPosts', JSON.stringify(savedPostIds));
                    this.closest('.pinterest-card').remove();
                });
            });
        });

        postsTab.addEventListener('click', () => {
            postsContent.style.display = 'block';
            savesContent.style.display = 'none';
        });
    });

    document.querySelectorAll('.tab-link').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');

            tab.classList.add('active');
            const target = tab.getAttribute('data-target');
            document.getElementById(target).style.display = 'block';
        });
    });


