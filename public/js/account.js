    // // Get CSRF token from meta tag
    // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // // DELETE POST
    // document.querySelectorAll('.delete-btn').forEach(button => {
    //     button.addEventListener('click', function (e) {
    //         e.preventDefault();
    //         const postId = this.getAttribute('data-id');

    //         if (confirm("Are you sure you want to delete this post?")) {
    //             fetch(`/posts/${postId}`, {
    //                 method: 'DELETE',
    //                 headers: {
    //                     'X-CSRF-TOKEN': csrfToken,
    //                     'Accept': 'application/json',
    //                     'Content-Type': 'application/json',
    //                 }
    //             })
    //             .then(response => {
    //                 if (!response.ok) {
    //                     throw new Error('Failed to delete post');
    //                 }
    //                 // Remove post card from DOM
    //                 const postCard = document.querySelector(`[data-post-id="${postId}"]`);
    //                 if (postCard) {
    //                     postCard.remove();
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error('Delete error:', error);
    //                 alert("Failed to delete post.");
    //             });
    //         }
    //     });
    // });

    // // EDIT POST
    // const editModal = document.getElementById('editModal');
    // const closeModal = document.getElementById('closeModal');
    // const editForm = document.getElementById('editPostForm');

    // document.querySelectorAll('.edit-btn').forEach(button => {
    //     button.addEventListener('click', function (e) {
    //         e.preventDefault();

    //         const postId = this.getAttribute('data-post-id');
    //         const title = this.getAttribute('data-title');
    //         const description = this.getAttribute('data-description');

    //         // Populate modal form
    //         document.getElementById('editPostId').value = postId;
    //         document.getElementById('editTitle').value = title;
    //         document.getElementById('editDescription').value = description;

    //         // Update form action
    //         editForm.setAttribute('action', `/posts/${postId}`);

    //         // Show the modal
    //         editModal.style.display = 'block';
    //     });
    // });

    // // CLOSE MODAL
    // closeModal.addEventListener('click', () => {
    //     editModal.style.display = 'none';
    // });

    // document.querySelectorAll('.edit-btn').forEach(button => {
    //     // Only trigger edit modal if it's inside a post card
    //     if (button.closest('.pinterest-card')) {
    //         button.addEventListener('click', function (e) {
    //             e.preventDefault();
    //             // your modal code...
    //         });
    //     }
    // });


    // document.querySelectorAll('.tab-link').forEach(link => {
    //     link.addEventListener('click', function (e) {
    //         e.preventDefault();

    //         // Remove active class from all tabs
    //         document.querySelectorAll('.tab-link').forEach(tab => {
    //             tab.classList.remove('active');
    //         });

    //         // Hide all tab content
    //         document.querySelectorAll('.tab-content').forEach(content => {
    //             content.style.display = 'none';
    //         });

    //         // Add active class to clicked tab
    //         this.classList.add('active');

    //         // Show the corresponding tab content
    //         const target = this.getAttribute('data-target');
    //         document.getElementById(target).style.display = 'block';
    //     });
    // });

    // // Show the first tab content by default
    // document.querySelectorAll('.tab-content').forEach((el, index) => {
    //     el.style.display = index === 0 ? 'block' : 'none';
    // });

    // // Show posts by default
    // document.getElementById('posts').classList.add('active');


    // document.addEventListener('DOMContentLoaded', () => {
    //     const savedTab = document.querySelector('.tab-link[data-target="saves"]');
    //     const postsTab = document.querySelector('.tab-link[data-target="posts"]');
    //     const savesContent = document.getElementById('saves');
    //     const postsContent = document.getElementById('posts');
    //     const savedPostIds = JSON.parse(localStorage.getItem('savedPosts')) || [];

    //     savedTab.addEventListener('click', () => {
    //         postsContent.style.display = 'none';
    //         savesContent.style.display = 'block';

    //         const allPosts = document.querySelectorAll('#posts .pinterest-card');
    //         savesContent.innerHTML = '<div class="pinterest-container"><div class="pinterest-grid"></div></div>';
    //         const savesGrid = savesContent.querySelector('.pinterest-grid');

    //         allPosts.forEach(card => {
    //             const postId = card.dataset.postId;
    //             if (savedPostIds.includes(postId)) {
    //                 savesGrid.appendChild(card.cloneNode(true));
    //             }
    //         });
    //     });

    //     postsTab.addEventListener('click', () => {
    //         postsContent.style.display = 'block';
    //         savesContent.style.display = 'none';
    //     });
    // });

    // document.addEventListener('DOMContentLoaded', () => {
    //     const savedTab = document.querySelector('.tab-link[data-target="saves"]');
    //     const postsTab = document.querySelector('.tab-link[data-target="posts"]');
    //     const savesContent = document.getElementById('saves');
    //     const postsContent = document.getElementById('posts');
    //     let savedPostIds = JSON.parse(localStorage.getItem('savedPosts')) || [];

    //     savedTab.addEventListener('click', () => {
    //         postsContent.style.display = 'none';
    //         savesContent.style.display = 'block';

    //         const allPosts = document.querySelectorAll('#posts .pinterest-card');
    //         savesContent.innerHTML = '<div class="pinterest-container"><div class="pinterest-grid"></div></div>';
    //         const savesGrid = savesContent.querySelector('.pinterest-grid');

    //         allPosts.forEach(card => {
    //             const postId = card.dataset.postId;
    //             if (savedPostIds.includes(postId)) {
    //                 const clonedCard = card.cloneNode(true);

    //                 // Remove edit & delete buttons
    //                 const actionButtons = clonedCard.querySelector('.action-buttons');
    //                 if (actionButtons) actionButtons.remove();

    //                 // Add unsave button
    //                 const newActionButtons = document.createElement('div');
    //                 newActionButtons.classList.add('action-buttons');

    //                 const unsaveBtn = document.createElement('a');
    //                 unsaveBtn.href = '#';
    //                 unsaveBtn.classList.add('action-btn', 'unsave-btn');
    //                 unsaveBtn.dataset.postId = postId;
    //                 unsaveBtn.innerHTML = '<i class="bi bi-bookmark-fill"></i>';

    //                 newActionButtons.appendChild(unsaveBtn);
    //                 clonedCard.querySelector('.card-body').appendChild(newActionButtons);

    //                 savesGrid.appendChild(clonedCard);
    //             }
    //         });

    //         // Handle unsave click
    //         document.querySelectorAll('.unsave-btn').forEach(button => {
    //             button.addEventListener('click', function (e) {
    //                 e.preventDefault();
    //                 const postId = this.dataset.postId;
    //                 savedPostIds = savedPostIds.filter(id => id !== postId);
    //                 localStorage.setItem('savedPosts', JSON.stringify(savedPostIds));
    //                 this.closest('.pinterest-card').remove();
    //             });
    //         });
    //     });

    //     postsTab.addEventListener('click', () => {
    //         postsContent.style.display = 'block';
    //         savesContent.style.display = 'none';
    //     });
    // });

    // document.querySelectorAll('.tab-link').forEach(tab => {
    //     tab.addEventListener('click', function () {
    //         document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
    //         document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');

    //         tab.classList.add('active');
    //         const target = tab.getAttribute('data-target');
    //         document.getElementById(target).style.display = 'block';
    //     });
    // });


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
