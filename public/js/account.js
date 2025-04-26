    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        document.querySelectorAll('.tab-link').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all tabs and content
                document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                const target = this.getAttribute('data-target');
                document.getElementById(target).classList.add('active');
            });
        });

        // Initialize edit modals
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const postId = this.getAttribute('data-post-id');
                const title = this.getAttribute('data-title');
                const description = this.getAttribute('data-description');

                // Set form values
                document.getElementById('editPostId').value = postId;
                document.getElementById('editTitle').value = title;
                document.getElementById('editDescription').value = description;

                // Set form action
                document.getElementById('editPostForm').action = `/posts/${postId}`;

                // Show modal
                const editModal = new bootstrap.Modal(document.getElementById('editPostModal'));
                editModal.show();
            });
        });

        // Delete post functionality
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const postId = this.getAttribute('data-id');

                if (confirm('Are you sure you want to delete this post?')) {
                    fetch(`/posts/${postId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the post card from DOM
                            document.querySelector(`.pinterest-card[data-post-id="${postId}"]`).remove();

                            // Show success message
                            alert('Post deleted successfully!');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });

        // Like post functionality
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const postId = this.getAttribute('data-post-id');
                const icon = this.querySelector('i');
                const likeCount = this.querySelector('.like-count');

                fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update like icon
                        if (data.action === 'liked') {
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill', 'text-danger');
                        } else {
                            icon.classList.remove('bi-heart-fill', 'text-danger');
                            icon.classList.add('bi-heart');
                        }

                        // Update like count
                        likeCount.textContent = data.likesCount;
                    }
                });
            });
        });

        // Unsave post functionality
        document.querySelectorAll('.unsave-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const postId = this.getAttribute('data-post-id');

                fetch(`/posts/${postId}/unsave`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the post card from DOM
                        this.closest('.pinterest-card').remove();

                        // Show success message or update UI
                        alert('Post unsaved successfully!');
                    }
                });
            });
        });
    });




    // Save post functionality
document.querySelectorAll('.save-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const postId = this.getAttribute('data-post-id');
        const icon = this.querySelector('i'); // Targeting the icon to change its state

        // AJAX request to save the post
        fetch(`/posts/${postId}/save`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Toggle the bookmark icon to indicate the post is saved
                if (data.action === 'saved') {
                    icon.classList.remove('bi-bookmark');
                    icon.classList.add('bi-bookmark-fill', 'text-success');
                } else {
                    icon.classList.remove('bi-bookmark-fill', 'text-success');
                    icon.classList.add('bi-bookmark');
                }

                // Optionally show success message or update UI
                alert('Post saved successfully!');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});


// // JavaScript for Follow Button Action
// document.querySelectorAll('.follow-btn').forEach(button => {
//     button.addEventListener('click', function(event) {
//         event.preventDefault();
//         let postId = this.getAttribute('data-post-id');
//         let followStatus = this.querySelector('.follow-status').textContent.trim();

//         // Send a request to follow/unfollow
//         fetch(`/posts/${postId}/follow`, {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({ action: followStatus === 'Follow' ? 'follow' : 'unfollow' })
//         })
//         .then(response => response.json())
//         .then(data => {
//             // Update the button text based on follow status
//             if (data.success) {
//                 this.querySelector('.follow-status').textContent = followStatus === 'Follow' ? 'Unfollow' : 'Follow';
//             } else {
//                 alert('There was an issue processing your request.');
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             alert('An error occurred.');
//         });
//     });
// });


// JavaScript for Follow Button Action
document.querySelectorAll('.follow-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        let postId = this.getAttribute('data-post-id');
        let followStatus = this.querySelector('.follow-status').textContent.trim();
        let creatorName = this.getAttribute('data-creator-name'); // Get the post creator's name

        // Send a request to follow/unfollow
        fetch(`/posts/${postId}/follow`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ action: followStatus === 'Follow' ? 'follow' : 'unfollow' })
        })
        .then(response => response.json())
        .then(data => {
            // Handle response
            if (data.success) {
                // Update the button text based on follow status
                this.querySelector('.follow-status').textContent = followStatus === 'Follow' ? 'Unfollow' : 'Follow';

                // Create and show the pop-up message
                let messageText = followStatus === 'Follow'
                ? `You are now following the post created by ${creatorName}.`
                : `You have unfollowed the post created by ${creatorName}.`;

                // Create the popup element
                let popup = document.createElement('div');
                popup.classList.add('popup-message');
                popup.textContent = messageText;

                // Style the popup
                popup.style.position = 'fixed';
                popup.style.top = '10px';
                popup.style.left = '50%';
                popup.style.transform = 'translateX(-50%)';
                popup.style.backgroundColor = '#333';
                popup.style.color = '#fff';
                popup.style.padding = '10px 20px';
                popup.style.borderRadius = '5px';
                popup.style.fontSize = '1rem';
                popup.style.zIndex = '9999';
                popup.style.display = 'none';
                popup.style.opacity = '0';
                popup.style.transition = 'opacity 0.3s ease-in-out';

                document.body.appendChild(popup);

                // Show the popup with fade-in effect
                setTimeout(() => {
                    popup.style.display = 'block';
                    popup.style.opacity = '1';
                }, 10);

                // Hide the popup after 3 seconds
                setTimeout(() => {
                    popup.style.opacity = '0';
                    setTimeout(() => popup.remove(), 300); // Remove after fade-out
                }, 3000);
            } else {
                // If the user is trying to follow their own post
                if (data.message) {
                    alert(data.message); // Show the error message from the backend
                } else {
                    alert('There was an issue processing your request.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });
});
