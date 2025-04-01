<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/signup.css') }}"> --}}

</head>
<body>
    <a href="{{ url('/mainPage') }}" class="back-arrow">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div class="container">

        <!-- Profile Card -->
        <div class="profile-card">
            <h2 class="profile-name">My Profile</h2>
            {{-- <div class="profile-image"></div> --}}


            <!-- Profile Form -->
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <p>{{ session()->get('success') }}</p>
                </div>
            @endif

            <form action="{{ URL::to('updateUser')}}" method="POST" enctype="multipart/form-data">

            @csrf

            <img src="{{ URL::asset('uploads/profiles/'.$user->picture) }}" class="mx-auto d-block mb-2" width="100px" alt="Profile Picture">

                <input type="text" name="fullname" class="input-field" placeholder="Name" value="{{ $user->fullname}}" required>
                <input type="email" name="email" class="input-field" placeholder="Email" value="{{ $user->email}}" readonly required>
                <input type="text" name="password" class="input-field" placeholder="Password" value="{{ $user->password}}" required>
                <input type="file" name="file" class="input-field">
                <button type="submit" class="save-btn">Save Changes</button>
            </form>


        </div>
    </div>
</body>
</html>
