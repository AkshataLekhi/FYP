let page = 1;
let fetching = false;
let currentPostIndex = null;

const container = document.getElementById('container');
const cols = Array.from(container.getElementsByClassName('col'));

// Fetch Images API
const fetchImageData = async () => {
    try {
        fetching = true;
        const response = await fetch();

        // const response = await fetch(`https://dog.ceo/api/breeds/image/random/8`);

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
    const allImages = [...userPosts, ...images];

    if (allImages.length > 0) {
        allImages.forEach((post, index) => {
            createCard(post, cols[index % cols.length]);
        });
    }
};

// Create individual card and append to column
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

// Open modal with selected post details
function openModal(post) {
    const userPosts = loadUserPosts();
    currentPostIndex = userPosts.findIndex(p => p.image === post.image && p.title === post.title);

    document.getElementById("modalImage").src = post.image;
    document.getElementById("modalTitle").innerText = post.title;
    document.getElementById("modalDescription").innerText = post.description;
    document.getElementById("postModal").style.display = "flex";
}

// Close post modal
function closeModal() {
    document.getElementById("postModal").style.display = "none";
}

// Like functionality (placeholder)
function likePost() {
    alert("You liked this post!");
}

// Open comment modal
function commentPost() {
    document.getElementById("commentPopup").style.display = "flex";
}

// Close comment modal
function closeCommentModal() {
    document.getElementById("commentPopup").style.display = "none";
}

// Handle submitting comment
function submitComment() {
    const comment = document.getElementById("commentInput").value.trim();
    if (!comment) {
        alert("Please enter a comment.");
        return;
    }

    console.log("Comment submitted:", comment);
    alert("Comment submitted!");

    document.getElementById("commentInput").value = "";
    closeCommentModal();
}

// Save post functionality (placeholder)
function savePost() {
    alert("Post saved!");
}

// Handle infinite scroll
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

// Search functionality
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

// Delete a post
function deletePost() {
    let userPosts = loadUserPosts();

    if (currentPostIndex !== null && currentPostIndex !== -1) {
        userPosts.splice(currentPostIndex, 1);
        localStorage.setItem('userPosts', JSON.stringify(userPosts));
        closeModal();
        location.reload(); // Optional: reloads to refresh UI
    } else {
        alert("Unable to delete the post.");
    }
}

displayImages();
