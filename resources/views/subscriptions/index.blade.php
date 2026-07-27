@extends('layouts.master_headless')

@section('title', 'Subscriptions - California Target Book')

@section('body_class', 'checkout-body landing-body')

@section('styles')
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- Site styles -->
  <link rel="stylesheet" href="/css/style_new.css">
@endsection

@section('content')
  @include('layouts.navbar')

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
          <img src="/subscriptions_page_img/COMPUTER-LAPTOP.png.webp" class="sub-laptop-img" alt="California Target Book Portal Mockup">
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
                </div>
                
                <div class="plan-price-section">
                    <span style="font-size: 14px; font-weight: 600; color: #64748b; margin-right: 4px;">from</span>
                    <span class="price-amount">${{ number_format(config('subscriptions.one_year_online')) }}</span>
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
                        <span>Hot Sheets email alerts included</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>3 printed book editions</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>One book per mailing, three mailings per year</span>
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
                </div>
                
                <div class="plan-price-section">
                    <span style="font-size: 14px; font-weight: 600; color: #64748b; margin-right: 4px;">from</span>
                    <span class="price-amount">${{ number_format(config('subscriptions.two_year_online')) }}</span>
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
                        <span>Hot Sheets email alerts included</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>6 printed book editions over 2 years</span>
                    </li>
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>One book per mailing, three mailings per year</span>
                    </li>
                </ul>
                <div class="plan-action">
                    <a href="/subscriptions/two-year" class="btn-subscribe btn-subscribe-solid">Subscribe Now</a>
                </div>
            </div>
        </div>
        <div class="addon-banner">
            <div class="addon-banner-content">
                <h4>Looking for Printed Books?</h4>
                <p>You can purchase additional printed books without an active subscription.</p>
            </div>
            <a href="/subscriptions/book-only" class="btn-addon-banner">
                Purchase add-ons <i class="bi bi-arrow-right"></i>
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
          <img src="/subscriptions_page_img/Large-screen-with-a-gaming-gear_42502910-9799-422a-8571-7b399a7ca173-removebg-preview.png.webp" alt="California Legislative Districts">
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
          <img src="/subscriptions_page_img/Smart-TV-mounted-on-the-white-wall-in-the-conference-room_Slide_Citysdsd.jpg.webp" alt="County Government Information">
        </div>
      </div>
    </div>
  </section>

  <!-- Feature 3: Ballot Initiatives -->
  <section class="feature-section-row">
    <div class="container-ctb">
      <div class="feat-grid">
        <div class="feat-img">
          <img src="/subscriptions_page_img/Samsung-Galaxy-Tab-S7_ctb-tablet1234.png.webp" alt="Ballot Initiatives">
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
          <img src="/subscriptions_page_img/TABLE-3.png.webp" alt="Campaign Finance Reports">
        </div>
      </div>
    </div>
  </section>

  <!-- Feature 5: Candidate Directory -->
  <section class="feature-section-row">
    <div class="container-ctb">
      <div class="feat-grid">
        <div class="feat-img">
          <img src="/subscriptions_page_img/Samsung-Galaxy-Tab-S7_ctb-tablet1-CHANGED.png.webp" alt="Candidate Directory">
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
          <img src="/subscriptions_page_img/TABLET-2.png.webp" alt="Hot Sheet Newsletter">
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
@endsection
