<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/mainPage.css') }}">
    <title>MAIN PAGE</title>
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            text-align: center;
            width: 60%;
            position: relative;
            border-radius: 8px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
        }

        .action-buttons {
            margin-top: 10px;
        }

        .action-buttons button {
            margin: 5px;
            padding: 10px;
            cursor: pointer;
        }

        /* Loader */
        #loader {
            display: none;
            text-align: center;
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav>
        <a class="logo" href="#">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo">
        </a>
        <a href="#" class="active">Home</a>
        <a href="{{ route('create') }}">Create</a>
        <input type="text" class="search" id="searchInput" placeholder="Search">
        <a href="{{ route('profile') }}"><i class="bi bi-person-fill"></i></a>
        <a href="#"><i class="bi bi-bell-fill"></i></a>
        <a href="#"><i class="bi bi-chat-heart-fill"></i></a>
        <a href="#"><i class="bi bi-clock-history"></i></a>

        <a href="#" onclick="document.getElementById('logout-form').submit();" style="cursor: pointer;">
            <i class="bi bi-box-arrow-right"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>

    <!-- Image Container -->
    <div id="container">
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
    </div>

    <!-- Image Modal -->
    <div class="modal" id="postModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <img id="modalImage" style="max-width: 100%;">
            <h3 id="modalTitle"></h3>
            <p id="modalDescription"></p>

            <div class="action-buttons">
                <button onclick="likePost()">Like</button>
                <button onclick="commentPost()">Comment</button>
                <button onclick="savePost()">Save</button>
            </div>

            <div class="rating-css">
                <div class="star-icon">
                    <input type="radio" value="1" name="product_rating" checked id="rating1">
                    <label for="rating1" class="bi bi-star-fill"></label>
                    <input type="radio" value="2" name="product_rating" id="rating2">
                    <label for="rating2" class="bi bi-star-fill"></label>
                    <input type="radio" value="3" name="product_rating" id="rating3">
                    <label for="rating3" class="bi bi-star-fill"></label>
                    <input type="radio" value="4" name="product_rating" id="rating4">
                    <label for="rating4" class="bi bi-star-fill"></label>
                    <input type="radio" value="5" name="product_rating" id="rating5">
                    <label for="rating5" class="bi bi-star-fill"></label>
                </div>
            </div>

        </div>
    </div>

    <script>
        let page = 1;
        let fetching = false;
        const container = document.getElementById('container');
        const cols = Array.from(container.getElementsByClassName('col'));

        // Fetch Dog Images API
        const fetchImageData = async () => {
            try {
                fetching = true;
                document.getElementById('loader').style.display = 'block';
                const response = await fetch(`https://dog.ceo/api/breeds/image/random/8`);
                const data = await response.json();
                fetching = false;
                return data.message.map(image => ({
                    image: image,
                    title: "Dog Image",
                    description: "A cute dog!"
                }));
            } catch (error) {
                console.error("Error fetching data:", error);
                fetching = false;
                return [];
            }
        };

        // Load User-Created Posts from Local Storage
        const loadUserPosts = () => {
            return JSON.parse(localStorage.getItem('userPosts')) || [];
        };

        // Display All Images (API + User Posts)
        const displayImages = async () => {
            const images = await fetchImageData();
            const userPosts = loadUserPosts();
            const allImages = [...userPosts, ...images]; // Combine User Images and API Images

            if (allImages.length > 0) {
                allImages.forEach((post, index) => {
                    createCard(post, cols[index % cols.length]);
                });
            }

            document.getElementById('loader').style.display = 'none';
        };

        // Create Image Card
        const createCard = (post, col) => {
            const card = document.createElement('div');
            card.classList.add('card');
            const img = document.createElement('img');
            img.src = post.image;
            img.alt = post.title;
            img.style.width = "100%";
            img.onerror = function () {
                this.parentElement.style.display = "none";
            };

            img.onclick = function () {
                openModal(post);
            };

            card.appendChild(img);
            col.appendChild(card);
        };

        // Open Modal
        function openModal(post) {
            document.getElementById("modalImage").src = post.image;
            document.getElementById("modalTitle").innerText = post.title;
            document.getElementById("modalDescription").innerText = post.description;
            document.getElementById("postModal").style.display = "flex";
        }

        // Close Modal
        function closeModal() {
            document.getElementById("postModal").style.display = "none";
        }

        // Handle Scroll Load More Images
        const handleScroll = () => {
            if (fetching) return;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            const bodyHeight = document.documentElement.scrollHeight;

            if (bodyHeight - scrollTop - windowHeight < 800) {
                page++;
                fetchImageData().then((images) => {
                    images.forEach((image, index) => {
                        createCard(image, cols[index % cols.length]);
                    });
                });
            }
        };

        window.addEventListener('scroll', handleScroll);

        // Search Functionality
        document.getElementById("searchInput").addEventListener("input", function () {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll(".card img");

            cards.forEach((img) => {
                let title = img.alt.toLowerCase();
                if (title.includes(filter)) {
                    img.parentElement.style.display = "block";
                } else {
                    img.parentElement.style.display = "none";
                }
            });
        });

        // Like, Comment, Save Dummy Functions
        function likePost() {
            alert("You liked this post!");
        }

        function commentPost() {
            let comment = prompt("Enter your comment:");
            if (comment) {
                alert("Comment added!");
            }
        }

        function savePost() {
            alert("Post saved!");
        }

        // Load Images on Page Load
        displayImages();
    </script>

</body>

</html>
