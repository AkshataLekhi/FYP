<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <div class="container">
    <div class="form-box login">
      <!-- Flash messages -->
      @if(session()->has('success'))
        <div class="alert alert-success">
          <p>{{ session()->get('success') }}</p>
        </div>
      @endif

      @if(session()->has('error'))
        <div class="alert alert-danger">
          <p>{{ session()->get('error') }}</p>
        </div>
      @endif

      <form action="{{ url('loginUser') }}" method="POST">
        @csrf
        <h1>LOGIN</h1>
        <div class="input-box">
          <input type="email" name="email" placeholder="Email" required>
          <i class="bi bi-envelope-fill"></i>
        </div>
        <div class="input-box">
          <input type="password" name="password" placeholder="Password" required>
          <i class="bi bi-file-lock2-fill"></i>
        </div>
        <div class="forgot-link">
          <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" class="btn">Login</button>
      </form>
    </div>

    <div class="form-box register">
      <form action="{{ url('signupUser') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1>REGISTER</h1>
        <div class="input-box">
          <input type="text" name="fullname" placeholder="User Name" required>
          <i class="bi bi-person-fill"></i>
        </div>
        <div class="input-box">
          <input type="file" name="file" required>
          <i class="bi bi-image"></i>
        </div>
        <div class="input-box">
          <input type="email" name="email" placeholder="Email" required>
          <i class="bi bi-envelope-fill"></i>
        </div>
        <div class="input-box">
          <input type="text" name="number" placeholder="Contact Number" required>
          <i class="bi bi-telephone-fill"></i>
        </div>
        <div class="input-box">
          <input type="password" name="password" placeholder="Password" required>
          <i class="bi bi-file-lock2-fill"></i>
        </div>
        <button type="submit" class="btn">Register</button>
        <p>or register with</p>
        <div class="social-icons">
          <a href="#"><i class="bi bi-google"></i></a>
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-linkedin"></i></a>
        </div>
      </form>
    </div>

    <div class="toggle-box">
      <div class="toggle-panel toggle-left">
        <h1>Hello, Again</h1>
        <p>Don't have an account?</p>
        <button class="btn register-btn">Register Here</button>
      </div>
      <div class="toggle-panel toggle-right">
        <h1>Welcome To <br> Outfit Orbit</h1>
        <p>Already have an account?</p>
        <button class="btn login-btn">Login Here</button>
      </div>
    </div>
  </div>
  <a href="index.html" class="back-arrow">
    <i class="bi bi-arrow-left"></i>
  </a>
  <script src="{{ asset('js/signup.js') }}"></script>
</body>
</html>
