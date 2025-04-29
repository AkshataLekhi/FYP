<x-header />

    <!-- Hero Section -->
    <section class="hero">
        <div class="text-content">
            <h1>WELCOME TO OUTFIT ORBIT</h1>
            <p>Where Style Takes Flight — Discover, Create, and Elevate Your Fashion Universe.</p>
            <button class="cta-btn" onclick="window.location.href='/signup'">See More</button>
        </div>
        <div class="image-content">
            <img src="{{ asset('images/bg.jpg') }}" alt="Logo">
        </div>
    </section>

    <!-- Start Your Journey Section -->
    <section class="journey__container" id="about">
        <div class="section__container">
            <h2 class="section__title">Start Your Journey With Us</h2>
            <p class="section__subtitle">Step into a world where your style story begins — bold, vibrant, and unforgettable.</p>
            <div class="journey__grid">
                <div class="img__card">
                    <img src="images/outfit_1.jpg" alt="Image 1" />
                    <div class="img__name"><span>Bold and Beautiful</span></div>
                </div>
                <div class="img__card">
                    <img src="images/outfit_7.jpg" alt="Image 2" />
                    <div class="img__name"><span>Confidence Looks Good</span></div>
                </div>
                <div class="img__card">
                    <img src="images/outfit_2.jpg" alt="Image 3" />
                    <div class="img__name"><span>Grace in Every Step</span></div>
                </div>
                <div class="img__card">
                    <img src="images/outfit_8.jpg" alt="Image 4" />
                    <div class="img__name"><span>Pretty Dress, Worry Less</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="banner__container" id="blog">
            <div class="banner__content">
                <h2>Get To Know Us More</h2>
                <p>Where Creativity, Passion, and Style Come Together — Welcome to Our World.</p>
                <li><a href="{{ URL::to('signup') }}" class="signup-btn">Sign-Up Here!</a></li>
            </div>
    </section>

<x-footer />
