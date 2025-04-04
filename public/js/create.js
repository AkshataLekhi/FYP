document.getElementById("postForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const fileInput = document.getElementById("imageInput").files[0];
    const title = document.getElementById("title").value;
    const description = document.getElementById("description").value;
    const link = document.getElementById("links").value;

    if (!fileInput) {
        alert("Please select an image to upload!");
        return;
    }

    const reader = new FileReader();
    reader.readAsDataURL(fileInput); // Convert image to Base64

    reader.onload = function () {
        const imageUrl = reader.result; // Base64 string of the image
        saveUserPost(imageUrl, title, description, link);
    };
});

function saveUserPost(imageUrl, title, description, link) {
    let posts = JSON.parse(localStorage.getItem("userPosts")) || [];

    let newPost = {
        image: imageUrl,
        title: title || "Untitled Post",
        description: description || "No Description",
        link: link || "#"
    };

    posts.unshift(newPost); // Add new post at the beginning
    localStorage.setItem("userPosts", JSON.stringify(posts));

    window.location.href = "{{ route('mainPage') }}"; // Redirect to main page
}
