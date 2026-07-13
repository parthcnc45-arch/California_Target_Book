<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subscriptions - California Target Book</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- Site styles -->
  <link rel="stylesheet" href="{{ asset('css/style_new.css') }}">

  <style>
    /* Custom style overrides and specific additions for Subscriptions Page */
    .navbar-ctb {
      background: rgba(16, 28, 51, 0.98) !important;
      position: sticky !important;
      box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
    }
    
    .sub-hero {
      padding: 80px 0 100px;
      background: #ffffff;
    }

    .sub-grid {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      align-items: center;
      gap: 60px;
    }

    .sub-image-wrapper {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .sub-image-wrapper::before {
      content: '';
      position: absolute;
      width: 320px;
      height: 320px;
      background: radial-gradient(circle, rgba(30, 86, 214, 0.2) 0%, rgba(30, 86, 214, 0) 70%);
      border-radius: 50%;
      z-index: 0;
    }

    .sub-laptop-img {
      position: relative;
      z-index: 1;
      max-width: 100%;
      height: auto;
      filter: drop-shadow(0 20px 30px rgba(0,0,0,0.12));
    }

    .sub-content h1 {
      font-size: 42px;
      color: var(--navy-900);
      margin-bottom: 24px;
      font-weight: 700;
      line-height: 1.2;
    }

    .sub-content p {
      font-size: 15.5px;
      color: var(--text-body);
      line-height: 1.8;
      margin-bottom: 30px;
    }

    .sub-buttons {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .btn-sub-plan {
      flex: 1;
      min-width: 220px;
      padding: 16px 20px;
      border-radius: 8px;
      text-align: center;
      font-weight: 700;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 4px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .btn-sub-red {
      background: var(--red-700);
      color: #ffffff;
      border: 2px solid var(--red-700);
    }

    .btn-sub-red:hover {
      background: var(--red-800);
      border-color: var(--red-800);
      transform: translateY(-2px);
      color: #ffffff;
    }

    .btn-sub-navy {
      background: var(--navy-btn);
      color: #ffffff;
      border: 2px solid var(--navy-btn);
    }

    .btn-sub-navy:hover {
      background: var(--navy-900);
      border-color: var(--navy-900);
      transform: translateY(-2px);
      color: #ffffff;
    }

    .btn-sub-plan .plan-price {
      font-size: 13px;
      font-weight: 400;
      opacity: 0.9;
    }

    /* Alternating feature sections */
    .feature-section-row {
      padding: 80px 0;
      background: #ffffff;
    }

    .feature-section-row:nth-child(even) {
      background: var(--grey-100);
    }

    .feat-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      gap: 80px;
    }

    .feat-text h2 {
      font-size: 32px;
      color: var(--navy-900);
      margin-bottom: 20px;
      font-weight: 700;
    }

    .feat-text p {
      font-size: 15px;
      color: var(--text-body);
      line-height: 1.8;
    }

    .feat-img {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .feat-img img {
      max-width: 100%;
      border-radius: 8px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.07);
    }

    /* Mobile responsiveness */
    @media (max-width: 991px) {
      .sub-grid, .feat-grid {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
      }
      .feat-grid > div:nth-child(1) {
        order: 2;
      }
      .feat-grid > div:nth-child(2) {
        order: 1;
      }
      .sub-buttons {
        justify-content: center;
      }
    }
  </style>
</head>

<body>

  <!-- =========================================================
     NAVBAR
========================================================= -->
  <nav class="navbar-ctb" id="mainNav">
    <div class="container-ctb navbar-inner">
      <a href="/" class="nav-logo">
        <img fetchpriority="high" decoding="async" width="150" height="80" src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2.png.webp" alt="" title="ctb_logo.png" srcset="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2.png.webp 250w, https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2-100x100.png.webp 100w, https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/ctb_logo-2-150x150.png.webp 150w" sizes="(max-width: 250px) 100vw, 250px" class="wp-image-18" data-smush-webp-fallback="{&quot;src&quot;:&quot;https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2.png&quot;,&quot;srcset&quot;:&quot;https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2.png 250w, https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2-100x100.png 100w, https:\/\/ctb.epicenterconsulting.net\/wp-content\/uploads\/2023\/04\/ctb_logo-2-150x150.png 150w&quot;}">
      </a>

      <ul class="nav-menu" id="navMenu">
        <li><a href="/">Home</a></li>
        <li><a href="/#about">About</a></li>
        @if (Auth::check() && Auth::user()->hasActiveSubscription())
          <li><a href="/book">Book App</a></li>
        @endif
        <li><a href="/#contact">Contact</a></li>
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
     HERO / SUBSCRIPTION INTRO
========================================================= -->
  <section class="sub-hero">
    <div class="container-ctb">
      <div class="sub-grid">
        <div class="sub-content">
          <h1>California Target Book Subscription</h1>
          <p>
            Experience California politics like never before with the California Target Book subscription. Get convenient, online access to everything you need to stay up to date on every aspect of the state's political landscape. Find comprehensive campaign finance data, candidate profiles, vote history, district maps and analysis in one easy-to-use platform. Choose the subscription model that works for you. Select a plan below to get started.
          </p>
          <div class="sub-buttons">
            <a href="/subscriptions/one-year" class="btn-sub-plan btn-sub-red">
              <span>One-Year Subscription</span>
              <span class="plan-price">$1,200.00 / year</span>
            </a>
            <a href="/subscriptions/two-year" class="btn-sub-plan btn-sub-navy">
              <span>Two-Year Subscription</span>
              <span class="plan-price">$2,200.00 / 2 years</span>
            </a>
          </div>
        </div>
        <div class="sub-image-wrapper">
          <img src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/COMPUTER-LAPTOP.png.webp" class="sub-laptop-img" alt="California Target Book Portal Mockup">
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================
     FEATURES ROW BY ROW
========================================================= -->

  <!-- Feature 1: Legislative Districts -->
  <section class="feature-section-row">
    <div class="container-ctb">
      <div class="feat-grid">
        <div class="feat-img">
          <img src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/Large-screen-with-a-gaming-gear_42502910-9799-422a-8571-7b399a7ca173-removebg-preview.png.webp" alt="California Legislative Districts">
        </div>
        <div class="feat-text">
          <h2>California Legislative Districts</h2>
          <p>
            The California Target Book covers all 80 Assembly, 40 State Senate and 53 Congressional seats, including maps, vote histories, party registration statistics, profiles of all candidates and interest group ratings.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Feature 2: County Government Information -->
  <section class="feature-section-row">
    <div class="container-ctb">
      <div class="feat-grid">
        <div class="feat-text">
          <h2>County Government Information</h2>
          <p>
            In-depth coverage of county government campaigns and elections in California. The online edition includes details on voter registration, post-election results, interactive maps and profiles of each supervisorial district in California's 58 counties.
          </p>
        </div>
        <div class="feat-img">
          <img src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/Smart-TV-mounted-on-the-white-wall-in-the-conference-room_Slide_Citysdsd.jpg.webp" alt="County Government Information">
        </div>
      </div>
    </div>
  </section>

  <!-- Feature 3: Ballot Initiatives -->
  <section class="feature-section-row">
    <div class="container-ctb">
      <div class="feat-grid">
        <div class="feat-img">
          <img src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/Samsung-Galaxy-Tab-S7_ctb-tablet1234.png.webp" alt="Ballot Initiatives">
        </div>
        <div class="feat-text">
          <h2>Ballot Initiatives</h2>
          <p>
            Our comprehensive guide to California ballot propositions is updated continuously and includes details on the supporters and opponents of each measure, plus campaign finance data.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Feature 4: Campaign Finance Reports -->
  <section class="feature-section-row">
    <div class="container-ctb">
      <div class="feat-grid">
        <div class="feat-text">
          <h2>Campaign Finance Reports</h2>
          <p>
            Key information on campaign finance in California. The online edition has database tools for searching contributions and expenditures for state or federal candidates, ballot measures and independent expenditure committees.
          </p>
        </div>
        <div class="feat-img">
          <img src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/TABLE-3.png.webp" alt="Campaign Finance Reports">
        </div>
      </div>
    </div>
  </section>

  <!-- Feature 5: Candidate Directory -->
  <section class="feature-section-row">
    <div class="container-ctb">
      <div class="feat-grid">
        <div class="feat-img">
          <img src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/Samsung-Galaxy-Tab-S7_ctb-tablet1-CHANGED.png.webp" alt="Candidate Directory">
        </div>
        <div class="feat-text">
          <h2>Candidate Directory</h2>
          <p>
            The California Target Book has built a comprehensive candidate directory for state or federal office over the last 10 years and for county, local and school district offices over the last 20 years.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Feature 6: Hot Sheet Newsletter -->
  <section class="feature-section-row">
    <div class="container-ctb">
      <div class="feat-grid">
        <div class="feat-text">
          <h2>Hot Sheet Newsletter</h2>
          <p style="font-weight: 600; font-size: 17px; margin-bottom: 12px; color: var(--navy-900);">
            Join the growing community of 50K+ subscribers
          </p>
          <p>
            Online subscribers have access to the Hot Sheet, reporting late breaking California political developments, and a weekly digest of California campaign news.
          </p>
        </div>
        <div class="feat-img">
          <img src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/TABLET-2.png.webp" alt="Hot Sheet Newsletter">
        </div>
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
      <div class="footer-bottom">
        &copy; 2024 California Target Book. All Rights Reserved. | Copyright
      </div>
    </div>
  </footer>

</body>
</html>
