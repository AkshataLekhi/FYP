document.querySelectorAll('.save-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const postId = this.dataset.postId;
        const icon = this.querySelector('i');
        const isSaved = icon.classList.contains('bi-bookmark-fill');

        fetch(`/posts/${postId}/${isSaved ? 'unsave' : 'save'}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                icon.classList.toggle('bi-bookmark');
                icon.classList.toggle('bi-bookmark-fill');
                this.querySelector('span').textContent = isSaved ? 'Save' : 'Saved';
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
