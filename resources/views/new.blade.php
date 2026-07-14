<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>California Target Book</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- Site styles -->
 <link rel="stylesheet" href="/css/style_new.css">
</head>

<body>

  <!-- =========================================================
     NAVBAR
========================================================= -->
  <!--
  <nav class="navbar-ctb" id="mainNav">
    <div class="container-ctb navbar-inner">
      <a href="/" class="nav-logo">
        <img src="/img/ctb_logo.png" alt="California Target Book">
      </a>

      <ul class="nav-menu" id="navMenu">
        <li><a href="/">Home</a></li>
        <li><a href="#about">About</a></li>
        @if (Auth::check() && Auth::user()->hasActiveSubscription())
          <li><a href="/book">Book</a></li>
        @endif
        @guest
          <li><a href="/login">Sign In</a></li>
        @else
          <li><a href="/account">My account</a></li>
        @endguest
        <li><a href="#contact">Contact</a></li>
        @auth
          <li><a href="/logout">Logout</a></li>
        @endauth
      </ul>

      <div class="nav-right">
        <a href="/subscriptions" class="btn-ctb btn-red">Subscribe</a>
        <button class="navbar-toggler-ctb" id="navToggle" aria-label="Toggle menu">&#9776;</button>
      </div>
    </div>
  </nav>
  -->
  @include('layouts.navbar')

  <!-- =========================================================
     HERO
========================================================= -->
  <header class="hero" id="home">
    <div class="hero-content">
      <h1>California Target Book</h1>
      <p class="hero-sub">The essential toolbox for California political professionals</p>
      <div class="hero-btns">
        <a href="/subscriptions" class="btn-ctb btn-red">Subscribe</a>
        <a href="#about" class="btn-ctb btn-navy">About Us</a>
      </div>
    </div>
  </header>

  <!-- =========================================================
     ABOUT
========================================================= -->
  <section class="section-about" id="about">
    <div class="container-ctb">
      <div class="about-card">
          <img src="/img/ctb_logo.png" alt="California Target Book">
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
          <img src="/img/ctb_logo.png" alt="California Target Book">
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
      <h2 class="new-section-title">Our Services</h2>
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
      <h2 class="new-section-title">Testimonial quotes</h2>
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
      <h2 class="new-section-title">Editorial Board &amp; Senior Staff</h2>
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
      <div class="newsletter-card-wrap">
        <h2>Subscribe To Our Newsletter</h2>
        <p class="sub">Receive the best political content right in your email</p>
        <form class="newsletter-form" id="newsletterForm">
          <input type="text" placeholder="Name" required>
          <input type="email" placeholder="Email" required>
          <button type="submit" class="btn-ctb btn-red">Subscribe</button>
        </form>
      </div>
    </div>
  </section>

  <!-- =========================================================
     FOOTER
========================================================= -->
  <!--
  <footer class="footer-ctb" id="contact">
    <div class="container-ctb">
      <div class="footer-grid">

        <div class="footer-col footer-brand">
          <a href="/" class="footer-logo-link">
            <img src="/img/ctb_logo.png" alt="California Target Book" class="footer-logo">
          </a>
          <p class="footer-tagline">The essential toolbox for California political professionals since 1993.</p>
          <ul class="footer-contact-list">
            <li>
              <span class="footer-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              </span>
              <a href="tel:916-234-6754">916-234-6754</a>
            </li>
            <li>
              <span class="footer-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              </span>
              <a href="mailto:info@californiatargetbook.com">info@californiatargetbook.com</a>
            </li>
            <li>
              <span class="footer-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              </span>
              <span>1215 K Street, Suite 1750<br>Sacramento, CA 95814</span>
            </li>
          </ul>
        </div>

        <div class="footer-col footer-nav">
          <div class="footer-nav-group">
            <h5 class="footer-col-title">Site</h5>
            <ul class="footer-links">
              <li><a href="/">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="/subscriptions">Subscribe</a></li>
              <li><a href="#subscribe">Newsletter</a></li>
              @guest
                <li><a href="/login">Sign In</a></li>
              @else
                <li><a href="/account">My Account</a></li>
              @endguest
            </ul>
          </div>
          <div class="footer-nav-group">
            <h5 class="footer-col-title">Book</h5>
            <ul class="footer-links">
              <li><a href="{{ route('book') }}#districts">Districts</a></li>
              <li><a href="{{ route('book') }}#candidates">Candidates</a></li>
              <li><a href="{{ route('book') }}#census-data">Census Data</a></li>
              <li><a href="{{ route('book') }}#elections">Elections</a></li>
              <li><a href="{{ route('book.hotsheet') }}">Hotsheets</a></li>
              <li><a href="{{ route('book') }}#propositions">Propositions</a></li>
              <li><a href="{{ route('book') }}#finance">Finance</a></li>
              <li><a href="{{ route('book') }}#maps">Maps</a></li>
            </ul>
          </div>
        </div>

        <div class="footer-col footer-contact">
          <h5 class="footer-col-title">Get In Touch</h5>
          <p class="footer-contact-sub">Have a question? Send us a message and we'll get back to you.</p>
          <form id="contactForm" class="footer-contact-form">
            <div class="row-inline">
              <input type="text" name="name" placeholder="Name" required>
              <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <textarea name="message" placeholder="Message" required></textarea>
            <button type="submit" class="btn-ctb btn-red btn-footer-submit">Send Message</button>
          </form>
        </div>

      </div>

      <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} California Target Book. All Rights Reserved.</p>
        <a href="/copyright">Copyright</a>
      </div>
    </div>
  </footer>
  -->
  @include('layouts.footer')
        <script src="/js/script.js"></script>
  
</body>

</html>