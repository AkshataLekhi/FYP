<x-header />

    <!-- Hero Section -->
    <section class="hero">
        <div class="text-content">
            <h1>WELCOME TO OUTFIT ORBIT</h1>
            <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.</p>
            <button class="cta-btn">See More</button>
        </div>
        <div class="image-content">
            <img src="{{ asset('images/bg.jpg') }}" alt="Logo">
        </div>
    </section>

    <!-- Start Your Journey Section -->
    <section class="journey__container" id="about">
        <div class="section__container">
            <h2 class="section__title">Start Your Journey With Us</h2>
            <p class="section__subtitle">Lorem ipsum dolor sit amet,</p>
            <div class="journey__grid">
                <div class="img__card">
                    <img src="images/img5.jpg" alt="Image 5" />
                    <div class="img__name"><span>Lorem ipsum dolor</span></div>
                </div>
                <div class="img__card">
                    <img src="images/img6.jpg" alt="Image 6" />
                    <div class="img__name"><span>Lorem ipsum dolor</span></div>
                </div>
                <div class="img__card">
                    <img src="images/img3.jpg" alt="Image 3" />
                    <div class="img__name"><span>Lorem ipsum dolor</span></div>
                </div>
                <div class="img__card">
                    <img src="images/img4.jpg" alt="Image 4" />
                    <div class="img__name"><span>Lorem ipsum dolor</span></div>
                </div>
                <div class="img__card">
                    <img src="images/img1.jpg" alt="Image 1" />
                    <div class="img__name"><span>Lorem ipsum dolor</span></div>
                </div>
                <div class="img__card">
                    <img src="images/img2.jpg" alt="Image 2" />
                    <div class="img__name"><span>Lorem ipsum dolor</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="banner__container" id="blog">
            <div class="banner__content">
                <h2>Get To Know Us More</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <li><a href="{{ URL::to('signup') }}" class="signup-btn">Sign-Up Here!</a></li>
            </div>
    </section>

<x-footer />
