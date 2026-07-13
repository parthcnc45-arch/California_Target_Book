<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>California Target Book</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- Site styles -->
 <link rel="stylesheet" href="{{ asset('css/style_new.css') }}">
</head>

<body>

  <!-- =========================================================
     NAVBAR
========================================================= -->
  <nav class="navbar-ctb" id="mainNav">
    <div class="container-ctb navbar-inner">
      <a href="#" class="nav-logo">
       <img fetchpriority="high" decoding="async" width="150" height="80" src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2.png.webp" alt="" title="ctb_logo.png" srcset="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2.png.webp 250w, https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2-100x100.png.webp 100w, https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2-150x150.png.webp 150w" sizes="(max-width: 250px) 100vw, 250px" class="wp-image-18" data-smush-webp-fallback="{&quot;src&quot;:&quot;https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2.png&quot;,&quot;srcset&quot;:&quot;https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2.png 250w, https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2-100x100.png 100w, https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2-150x150.png 150w&quot;}">
      </a>

      <ul class="nav-menu" id="navMenu">
        <li><a href="/">Home</a></li>
        <li><a href="#about">About</a></li>
        @if (Auth::check() && Auth::user()->hasActiveSubscription())
          <li><a href="/book">Book App</a></li>
        @endif
        <li><a href="#contact">Contact</a></li>
        @guest
          <li><a href="/login">Sign In</a></li>
        @else
          <li><a href="/account">My account</a></li>
          <li><a href="/logout">Logout</a></li>
        @endguest
      </ul>

      <div class="nav-right">
        <a href="/subscriptions" class="btn-ctb btn-red">Subscribe</a>
        <button class="navbar-toggler-ctb" id="navToggle" aria-label="Toggle menu">&#9776;</button>
      </div>
    </div>
  </nav>

  <!-- =========================================================
     HERO
========================================================= -->
  <header class="hero" id="home">
    <div class="hero-content">
      <h1>California Target Book</h1>
      <p class="hero-sub">The essential toolbox for California political professionals</p>
      <div class="hero-btns">
        <a href="/subscriptions" class="btn-ctb btn-red">Subscribe</a>
        <a href="#about" class="btn-ctb btn-outline-light">About Us</a>
      </div>
    </div>
  </header>

  <!-- =========================================================
     ABOUT
========================================================= -->
  <section class="section-about" id="about">
    <div class="container-ctb">
      <div class="about-card">
        <div><img src="https://ctb.epicenterconsulting.net/wp-content/uploads/2023/04/ctb_logo-2.png" alt=""></div>
        <div class="about-text">
          <h2>About The California Target Book</h2>
          <p>Established in 1993, the California Target Book gives non-partisan, unbiased
            information to all who want to be kept fully informed and updated on congressional
            and state legislative election campaigns in California. The online edition includes
            a comprehensive set of tools for keeping up-to-date on every aspect of California's
            political system including elections, campaign finance, ballot measures, and
            redistricting.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================
     ONLINE EDITION
========================================================= -->
  <section class="section-online">
    <div class="container-ctb">
      <div class="online-grid">
        <div class="online-text">
          <h2>Online Edition</h2>
          <p>The California Target Book is the trusted, unbiased source of comprehensive current
            data for California political professionals and insiders who need to stay up to date
            on campaigns and elections at every level in the state.</p>
          <a href="/subscriptions" class="btn-ctb btn-navy">Subscribe</a>
        </div>
        <div class="online-image">
          <div class="laptop-mock">
            <div class="laptop-screen">
              <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=900&auto=format&fit=crop"
                alt="Online edition dashboard preview">
            </div>
            <div class="laptop-base"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================
     HARD COPY EDITION
========================================================= -->
  <section class="section-hardcopy" id="book">
    <div class="container-ctb">
      <div class="hardcopy-card">
        <div>
         <img fetchpriority="high" decoding="async" width="150" height="150" src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2.png.webp" alt="" title="ctb_logo.png" srcset="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2.png.webp 250w, https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2-100x100.png.webp 100w, https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2-150x150.png.webp 150w" sizes="(max-width: 250px) 100vw, 250px" class="wp-image-18" data-smush-webp-fallback="{&quot;src&quot;:&quot;https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2.png&quot;,&quot;srcset&quot;:&quot;https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2.png 250w, https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2-100x100.png 100w, https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2-150x150.png 150w&quot;}">
          <span class="pdf-tag">PDF</span>
        </div>
        <div class="hardcopy-text">
          <div class="hardcopy-head">
            <h2>Hard Copy<br>Edition</h2>
            <a href="#" class="btn-ctb btn-navy">Buy Now</a>
          </div>
          <p>Many readers supplement their online subscriptions by choosing to receive the hard
            copy edition of the California Target Book, a handy abridged version of the
            information available on our web site. It includes vote histories, voter
            registration and turnout data and candidate profiles.</p>
          <p>Six editions are published during each election cycle–three updates in odd numbered
            off years and three editions (pre-primary, post-primary, post-general) in even
            numbered election years.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================
     OUR SERVICES
========================================================= -->
  <section class="section-services">
    <div class="container-ctb">
      <h2 class="section-title">Our Services</h2>
      <div class="services-grid">

        <div class="service-card">
          <div class="img-wrap">
            <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=700&auto=format&fit=crop"
              alt="Legislative Districts map">
          </div>
          <div class="card-body">
            <h3>Legislative Districts</h3>
            <p>District-by-district coverage of each of California's 80 Assembly, 40 state Senate
              and 53 Congressional seats, including maps, vote histories, census and party
              registration statistics, incumbent interest group ratings and profiles of all
              candidates who have filed for election.</p>
          </div>
        </div>

        <div class="service-card">
          <div class="img-wrap">
            <img src="https://images.unsplash.com/photo-1591189863430-ab87e120f312?q=80&w=700&auto=format&fit=crop"
              alt="Ballot Initiatives voting">
          </div>
          <div class="card-body">
            <h3>Ballot Initiatives</h3>
            <p>In-depth coverage includes detailed financial data for the organizations
              supporting and opposing them.</p>
          </div>
        </div>

        <div class="service-card">
          <div class="img-wrap">
            <img src="https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?q=80&w=700&auto=format&fit=crop"
              alt="Election Information building">
          </div>
          <div class="card-body">
            <h3>Election Information</h3>
            <p>The California Target Book has compiled election results and a searchable
              candidate directory for state or federal office over the last ten years and for
              county, local and school district offices over the last 20 years.</p>
          </div>
        </div>

        <div class="service-card">
          <div class="img-wrap">
            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=700&auto=format&fit=crop"
              alt="Data and Analysis charts">
          </div>
          <div class="card-body">
            <h3>Data &amp; Analysis</h3>
            <p>District-by-district coverage of each of California's 80 Assembly, 40 state Senate
              and 53 Congressional seats, including maps, vote histories, census and party
              registration statistics, incumbent interest group ratings and profiles of all
              candidates who have filed for election.</p>
          </div>
        </div>

        <div class="service-card">
          <div class="img-wrap">
            <img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=700&auto=format&fit=crop"
              alt="News listings">
          </div>
          <div class="card-body">
            <h3>News</h3>
            <p>County-level data includes voter registration, post election results,
              interactive district maps and incumbent profiles for each of California's 266
              Supervisorial Districts in the state's 58 counties.</p>
          </div>
        </div>

        <div class="service-card">
          <div class="img-wrap">
            <img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=700&auto=format&fit=crop"
              alt="Hot Sheets news update">
          </div>
          <div class="card-body">
            <h3>Hot Sheets</h3>
            <p>Online subscribers have access to the Hot Sheet, reporting late breaking
              California political developments.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================
     TESTIMONIAL
========================================================= -->
  <section class="section-testimonial">
    <div class="container-ctb">
      <h2 class="section-title">Testimonial quotes</h2>
      <div class="testimonial-card">
        <div class="avatar">
          <img src="https://i.pravatar.cc/120?img=52" alt="Dan Morain">
        </div>
        <div>
          <p>There's a reason why the California Target Book is flourishing more than 30 years
            after its founding. People who need to understand California elections and politics
            know they can rely on the Target Book to deliver accurate, timely and unbiased
            information with important historical context.</p>
          <span class="author">Dan Morain</span>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================
     EDITORIAL BOARD
========================================================= -->
  <section class="section-board" id="editorial">
    <div class="container-ctb">
      <h2 class="section-title">Editorial Board &amp; Senior Staff</h2>
      <p class="board-sub">Our team offers an extensive, balanced knowledge of California politics.</p>

      <div class="board-grid" id="boardGrid">
        <!-- Cards injected by script.js -->
      </div>
    </div>
  </section>

  <!-- =========================================================
     NEWSLETTER
========================================================= -->
  <section class="section-newsletter" id="subscribe">
    <div class="container-ctb">
      <h2>Subscribe To Our Newsletter</h2>
      <p class="sub">Receive the best political content right in your email</p>
      <form class="newsletter-form" id="newsletterForm">
        <input type="text" placeholder="Name" required>
        <input type="email" placeholder="Email" required>
        <button type="submit" class="btn-ctb btn-red">Subscribe</button>
      </form>
    </div>
  </section>

  <!-- =========================================================
     FOOTER
========================================================= -->
  <footer class="footer-ctb" id="contact">
    <div class="container-ctb">
      <div class="footer-grid">

        <div class="footer-brand">
          <div class="logo-badge">CTB</div>
          <p>&#128222; Phone: 916-234-6754</p>
          <p>&#128205; Mailing Address: 1215 K Street, Suite 1750, Sacramento, CA 95814</p>
        </div>

        <div class="footer-book">
          <h5>Book</h5>
          <ul class="footer-links">
            <li><a href="#">Districts</a></li>
            <li><a href="#">Candidates</a></li>
            <li><a href="#">Census Data</a></li>
            <li><a href="#">Elections</a></li>
            <li><a href="#">Hotsheets</a></li>
            <li><a href="#">Propositions</a></li>
            <li><a href="#">Finance</a></li>
            <li><a href="#">Maps</a></li>
          </ul>
        </div>

        <div class="footer-contact">
          <h5>Contact</h5>
          <form id="contactForm">
            <div class="row-inline">
              <input type="text" placeholder="Name" required>
              <input type="email" placeholder="Email Address" required>
            </div>
            <textarea placeholder="Message" required></textarea>
            <button type="submit" class="btn-ctb btn-red">Submit</button>
          </form>
        </div>

      </div>

      <div class="footer-bottom">
        &copy; 2024 California Target Book. All Rights Reserved. | Copyright
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>