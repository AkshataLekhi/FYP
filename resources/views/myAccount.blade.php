<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Account</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
</head>
<body>
    <div class="profile-section">

        <a href="{{ url('/mainPage') }}" class="back-arrow">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h2>All About Your Profile</h2>

        <a href="{{ route('profile') }}">
            <button class="edit-btn">Edit</button>
        </a>

    </div>

    <div class="tabs">
        <a href="#" class="active">Your Posts</a>
        <a href="#">Your Saves</a>
    </div>


</body>
</html>
