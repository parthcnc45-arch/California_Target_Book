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
    /* Subscription Plans UI (Lovable Theme with CTB Colors) */
    .subscription-plans {
      padding: 60px 0 100px;
      background: #f8fafc;
    }
    .plans-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      max-width: 900px;
      margin: 0 auto;
    }
    .plan-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 40px 32px;
      display: flex;
      flex-direction: column;
      position: relative;
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
    .plan-card:hover {
      box-shadow: 0 12px 24px rgba(0,0,0,0.06);
      transform: translateY(-4px);
    }
    .best-value-card {
      border: 2px solid var(--navy-900);
      box-shadow: 0 8px 20px rgba(16, 28, 51, 0.08);
    }
    .plan-header {
      text-align: center;
      margin-bottom: 24px;
    }
    .plan-tag {
      display: inline-block;
      font-size: 13px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 20px;
      background: #f1f5f9;
      color: #64748b;
      margin-bottom: 16px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .plan-tag.best-value {
      background: var(--navy-900);
      color: #ffffff;
      position: absolute;
      top: -14px;
      left: 50%;
      transform: translateX(-50%);
      margin-bottom: 0;
    }
    .plan-title {
      font-size: 22px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 8px;
    }
    .plan-duration {
      font-size: 14px;
      color: #64748b;
      margin: 0;
    }
    .plan-price-section {
      text-align: center;
      margin-bottom: 32px;
      padding-bottom: 32px;
      border-bottom: 1px solid #f1f5f9;
    }
    .price-amount {
      font-size: 48px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -1px;
    }
    .price-suffix {
      font-size: 20px;
      font-weight: 600;
      color: #64748b;
    }
    .plan-features {
      list-style: none;
      padding: 0;
      margin: 0 0 40px 0;
      flex-grow: 1;
    }
    .feature-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-bottom: 16px;
      font-size: 15px;
      color: #334155;
      line-height: 1.5;
    }
    .feature-item i {
      color: #10b981; /* Green checkmark */
      font-size: 18px;
      margin-top: 2px;
    }
    .plan-action {
      text-align: center;
      margin-top: auto;
    }
    .btn-subscribe {
      display: block;
      width: 100%;
      padding: 16px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.2s ease;
      text-align: center;
    }
    .btn-subscribe-outline {
      background: #ffffff;
      border: 1px solid #cbd5e1;
      color: #0f172a;
    }
    .btn-subscribe-outline:hover {
      background: #f8fafc;
      border-color: #94a3b8;
      color: #0f172a;
    }
    .btn-subscribe-solid {
      background: var(--navy-900);
      border: 1px solid var(--navy-900);
      color: #ffffff;
    }
    .btn-subscribe-solid:hover {
      background: #1e293b;
      border-color: #1e293b;
      color: #ffffff;
    }
    
    /* New text additions */
    .pricing-header {
      text-align: center;
      margin-bottom: 40px;
    }
    .pricing-header h2 {
      font-size: 32px;
      font-weight: 700;
      color: var(--navy-900);
      margin-bottom: 12px;
    }
    .pricing-header p {
      font-size: 16px;
      color: var(--primary-red);
      font-weight: 500;
      margin: 0;
    }
    .plan-card .plan-duration {
      font-size: 14px;
      color: #64748b;
      margin-top: 4px;
      margin-bottom: 0;
    }
    .plan-card .price-amount {
      font-size: 40px;
    }
    .plan-card .price-suffix {
      font-size: 16px;
      font-weight: 500;
    }
    .sign-in-link {
      text-align: center;
      margin-top: 32px;
      font-size: 14px;
      color: #64748b;
    }
    .sign-in-link a {
      color: var(--navy-900);
      font-weight: 600;
      text-decoration: none;
    }
    .sign-in-link a:hover {
      text-decoration: underline;
    }
    .addon-banner {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 24px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 40px auto 0;
      max-width: 900px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .addon-banner-content h4 {
      margin: 0 0 4px 0;
      font-size: 18px;
      font-weight: 700;
      color: var(--navy-900);
    }
    .addon-banner-content p {
      margin: 0;
      font-size: 14px;
      color: #64748b;
    }
    .btn-addon-banner {
      background: #f1f5f9;
      color: var(--navy-900);
      font-weight: 600;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
      white-space: nowrap;
    }
    .btn-addon-banner:hover {
      background: var(--navy-900);
      color: #ffffff;
    }

    @media (max-width: 768px) {
      .addon-banner {
        flex-direction: column;
        text-align: center;
        gap: 20px;
        padding: 24px;
      }
      .plans-grid {
        grid-template-columns: 1fr;
      }
      .plan-card {
        padding: 32px 24px;
      }
      .best-value-card {
        margin-top: 20px;
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
        <img src="/img/ctb_logo.png" alt="California Target Book">
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
        </div>
        <div class="sub-image-wrapper">
          <img src="https://ctb.epicenterconsulting.net/wp-content/smush-webp/2023/04/COMPUTER-LAPTOP.png.webp" class="sub-laptop-img" alt="California Target Book Portal Mockup">
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================
    SUBSCRIPTION OPTIONS
========================================================= -->
<section class="subscription-plans" id="plans">
    <div class="container-ctb">
        <div class="pricing-header">
            <h2>Simple, transparent pricing</h2>
            <p>Full access to California Target Book's comprehensive data.</p>
        </div>
        
        <div class="plans-grid">
            <!-- One-Year Plan -->
            <div class="plan-card">
                <div class="plan-header">
                    <h3 class="plan-title">One-Year Subscription</h3>
                    <p class="plan-duration">Choose Online Only or Online & Print on the next step.</p>
                </div>
                
                <div class="plan-price-section">
                    <span style="font-size: 14px; font-weight: 600; color: #64748b; margin-right: 4px;">from</span>
                    <span class="price-amount">$1,200</span>
                    <span class="price-suffix">/ year</span>
                </div>
                
                <ul class="plan-features">
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>1 online user account</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Full platform access</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>1st to see email alerts included</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Optional printed book editions</span>
                    </li>
                </ul>
                <div class="plan-action">
                    <a href="/subscriptions/one-year" class="btn-subscribe btn-subscribe-outline">Subscribe Now</a>
                </div>
            </div>

            <!-- Two-Year Plan -->
            <div class="plan-card best-value-card">
                <div class="plan-header">
                    <span class="plan-tag best-value">Best Value</span>
                    <h3 class="plan-title">Two-Year Subscription</h3>
                    <p class="plan-duration">Choose Online Only or Online & Print on the next step.</p>
                </div>
                
                <div class="plan-price-section">
                    <span style="font-size: 14px; font-weight: 600; color: #64748b; margin-right: 4px;">from</span>
                    <span class="price-amount">$2,200</span>
                    <span class="price-suffix">/ 2 years</span>
                </div>
                
                <ul class="plan-features">
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>1 online user account</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Full platform access</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>1st to see email alerts included</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Locked in rate for 2 years</span>
                    </li>
                </ul>
                <div class="plan-action">
                    <a href="/subscriptions/two-year" class="btn-subscribe btn-subscribe-solid">Subscribe Now</a>
                </div>
            </div>
        </div>
        <div class="addon-banner">
            <div class="addon-banner-content">
                <h4>Looking for Printed Books Only?</h4>
                <p>You can purchase additional printed books without an active subscription.</p>
            </div>
            <a href="/subscriptions/book-only" class="btn-addon-banner">
                Purchase Books <i class="bi bi-arrow-right"></i>
            </a>
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
      <div class="footer-bottom">
        &copy; 2024 California Target Book. All Rights Reserved. | Copyright
      </div>
    </div>
  </footer>
  -->
  @include('layouts.footer')

</body>
</html>
