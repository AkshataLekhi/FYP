{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stories Feature</title>
    <link rel="stylesheet" href="{{ asset('css/stories.css') }}">
</head>
<body>

    <div class="story-container">
        <!-- Story Upload Form -->
        <form id="storyForm" enctype="multipart/form-data">
            @csrf
            <input type="file" id="storyFile" name="media" required>
            <select id="mediaType" name="media_type">
                <option value="image">Image</option>
                <option value="video">Video</option>
            </select>
            <button type="submit">Upload Story</button>
        </form>

        <!-- Stories Section -->
        <div class="stories">
            <!-- Stories will be displayed here -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchStories();

            // Handle story upload
            document.getElementById('storyForm').addEventListener('submit', function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                fetch('/api/stories', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer YOUR_ACCESS_TOKEN',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    fetchStories();
                });
            });

            // Fetch and display stories
            function fetchStories() {
                fetch('/api/stories', {
                    headers: {
                        'Authorization': 'Bearer YOUR_ACCESS_TOKEN',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let storiesContainer = document.querySelector('.stories');
                    storiesContainer.innerHTML = '';
                    data.forEach(story => {
                        let storyElement = document.createElement('div');
                        storyElement.classList.add('story');
                        if (story.media_type === 'image') {
                            storyElement.innerHTML = `<img src="/storage/${story.media_path}" alt="Story">`;
                        } else {
                            storyElement.innerHTML = `<video src="/storage/${story.media_path}" controls></video>`;
                        }
                        storiesContainer.appendChild(storyElement);
                    });
                });
            }
        });
    </script>

</body>
</html> --}}








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stories</title>
</head>
<body>
    <h2>Stories</h2>
    <div id="stories"></div>

    <script>
        fetch('/api/stories')
        .then(response => response.json())
        .then(data => {
            let container = document.getElementById('stories');
            data.forEach(story => {
                let div = document.createElement('div');
                div.innerHTML = story.media_type === 'image'
                    ? `<img src="/storage/${story.media_path}" width="100">`
                    : `<video src="/storage/${story.media_path}" width="100" controls></video>`;
                container.appendChild(div);
            });
        });
    </script>
</body>
</html>
