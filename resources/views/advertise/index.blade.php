<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Advertise | California Target Book</title>
  <meta name="description" content="Reach California's most influential political professionals, decision-makers, and campaign managers. Explore advertising options with the California Target Book.">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- Site styles -->
  <link rel="stylesheet" href="/css/style_new.css">
  
  <!-- Custom Advertise styles -->
  <link rel="stylesheet" href="/css/advertise.css">
</head>

<body>

  @include('layouts.navbar')

  <!-- Hero Section -->
  <header class="advertise-hero">
    <div class="container-ctb">
      <h1>Advertise With Us</h1>
      <p>Reach California's most influential political and government professionals — legislators, agency leaders, lobbyists, campaign staff, and senior public affairs executives.</p>
      <div class="hero-btn-container">
        <a href="#pricing" class="btn-hero-red">Post an Ad Now</a>
        <a href="#pricing" class="btn-hero-outline">View Pricing</a>
      </div>
    </div>
  </header>

  <!-- Who Reads section -->
  <section class="container-ctb py-3">
    <h2 class="adv-section-title">Who Reads California Target Book?</h2>
    <p class="adv-section-subtitle">Our subscribers are the decision-makers and influencers shaping California policy every day.</p>
    
    <div class="row g-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col-sm-6 col-lg-3">
        <div class="reader-card">
          <div class="reader-icon">🏛️</div>
          <h4>Legislators & Staff</h4>
          <p>State Assembly & Senate members and their offices.</p>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-sm-6 col-lg-3">
        <div class="reader-card">
          <div class="reader-icon">👥</div>
          <h4>Agency Leaders</h4>
          <p>Directors, deputies, and senior staff across state agencies.</p>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-sm-6 col-lg-3">
        <div class="reader-card">
          <div class="reader-icon">💼</div>
          <h4>Lobbyists & Advocates</h4>
          <p>Registered lobbyists and public affairs professionals.</p>
        </div>
      </div>
      <!-- Card 4 -->
      <div class="col-sm-6 col-lg-3">
        <div class="reader-card">
          <div class="reader-icon">📰</div>
          <h4>Media & Reporters</h4>
          <p>Capitol press corps and political journalists statewide.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works section -->
  <section class="container-ctb py-3">
    <h2 class="adv-section-title">How It Works</h2>
    <p class="adv-section-subtitle">Getting your ad in front of California's political professionals is simple.</p>

    <div class="steps-container d-none d-md-flex">
      <div class="steps-line"></div>
      
      <!-- Step 1 -->
      <div class="step-node">
        <div class="step-circle">1</div>
        <h5>Choose Your Ad Type</h5>
        <p>Select a Classified Ad or Leaderboard Banner</p>
      </div>
      
      <!-- Step 2 -->
      <div class="step-node">
        <div class="step-circle">2</div>
        <h5>Select Duration</h5>
        <p>Pick weekly or monthly run dates</p>
      </div>
      
      <!-- Step 3 -->
      <div class="step-node">
        <div class="step-circle">3</div>
        <h5>Submit & Pay</h5>
        <p>Complete the form and checkout securely</p>
      </div>
      
      <!-- Step 4 -->
      <div class="step-node">
        <div class="step-circle">4</div>
        <h5>Go Live</h5>
        <p>Your ad appears on the site and in the daily report</p>
      </div>
    </div>

    <!-- Mobile fallback list -->
    <div class="d-md-none">
      <div class="row g-4">
        <div class="col-12 d-flex align-items-start">
          <div class="step-circle me-3 ms-0 flex-shrink-0" style="margin: 0;">1</div>
          <div>
            <h5 class="fw-bold mb-1">Choose Your Ad Type</h5>
            <p class="text-muted mb-0 small">Select a Classified Ad or Leaderboard Banner</p>
          </div>
        </div>
        <div class="col-12 d-flex align-items-start">
          <div class="step-circle me-3 ms-0 flex-shrink-0" style="margin: 0;">2</div>
          <div>
            <h5 class="fw-bold mb-1">Select Duration</h5>
            <p class="text-muted mb-0 small">Pick weekly or monthly run dates</p>
          </div>
        </div>
        <div class="col-12 d-flex align-items-start">
          <div class="step-circle me-3 ms-0 flex-shrink-0" style="margin: 0;">3</div>
          <div>
            <h5 class="fw-bold mb-1">Submit & Pay</h5>
            <p class="text-muted mb-0 small">Complete the form and checkout securely</p>
          </div>
        </div>
        <div class="col-12 d-flex align-items-start">
          <div class="step-circle me-3 ms-0 flex-shrink-0" style="margin: 0;">4</div>
          <div>
            <h5 class="fw-bold mb-1">Go Live</h5>
            <p class="text-muted mb-0 small">Your ad appears on the site and in the daily report</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing Cards section -->
  <section class="container-ctb py-3" id="pricing">
    <h2 class="adv-section-title">Ad Types & Pricing</h2>
    <p class="adv-section-subtitle">Choose the format that best fits your message and budget.</p>

    <div class="row g-4 justify-content-center">
      <!-- Classified Ad Card -->
      <div class="col-md-6 col-lg-5">
        <div class="pricing-card">
          <div class="pricing-preview-area">
            <div class="mock-classified">
              <span class="tag">Jobs</span>
              <div class="org">Your Organization</div>
              <div class="title">Your Job Title Here</div>
              <div class="desc">Brief description of the role, salary range, and how to apply. Application date closes at real (MM/DD)</div>
            </div>
          </div>
          <div class="pricing-body">
            <h3>Classified Ad</h3>
            <p class="desc">Post a job opening, lease office space, promote consulting services, or any other classified listing. Ads run on the Classifieds page (publicly accessible) and in the daily email report.</p>
            
            <div class="badge-container">
              <span class="badge-item">Text-based</span>
              <span class="badge-item">Up to 100 words</span>
              <span class="badge-item">Link included</span>
              <span class="badge-item">Daily email inclusion</span>
            </div>

            <div class="price-row">
              <div class="price-box">
                <span class="label">Weekly</span>
                <div class="amount">$165 <span>/wk</span></div>
              </div>
              <div class="price-box">
                <span class="label">Monthly</span>
                <div class="amount">$585 <span>/mo</span></div>
              </div>
            </div>

            <a href="/classifieds/submit" class="btn-pricing-action-red">Post a Classified Ad</a>
          </div>
        </div>
      </div>

      <!-- Leaderboard Banner Ad Card -->
      <div class="col-md-6 col-lg-5">
        <div class="pricing-card">
          <div class="pricing-preview-area">
            <div class="mock-banner">
              <div class="size-text">728 × 90 BANNER AD</div>
              <div class="sub-text">Appears between sections of the daily report</div>
            </div>
          </div>
          <div class="pricing-body">
            <h3>Leaderboard Banner Ad</h3>
            <p class="desc">728x90 banner ads appear between sections of the daily email report and on the website. Limited spots available — high visibility placement for brand awareness and campaigns.</p>
            
            <div class="badge-container">
              <span class="badge-item">728x90 px</span>
              <span class="badge-item">Image/HTML</span>
              <span class="badge-item">Click-through URL</span>
              <span class="badge-item">Limited availability</span>
            </div>

            <div class="price-row">
              <div class="price-box">
                <span class="label">Weekly</span>
                <div class="amount">$350 <span>/wk</span></div>
              </div>
              <div class="price-box">
                <span class="label">Monthly</span>
                <div class="amount">$1,200 <span>/mo</span></div>
              </div>
            </div>

            <a href="mailto:info@californiatargetbook.com?subject=Leaderboard Banner Ad Inquiry" class="btn-pricing-action-blue">Inquire About Banner Ads</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="container-ctb py-3">
    <h2 class="adv-section-title">Frequently Asked Questions</h2>

    <div class="faq-accordion">
      <!-- Q1 -->
      <div class="faq-item">
        <div class="faq-question">
          <span>How long does it take for my ad to appear?</span>
          <span class="toggle-icon">+</span>
        </div>
        <div class="faq-answer">
          <p>Classified ads submitted by 3:00 PM PST are typically reviewed and pushed live on the website by the following business day. Daily email inclusions begin the morning after approval.</p>
        </div>
      </div>
      <!-- Q2 -->
      <div class="faq-item">
        <div class="faq-question">
          <span>Is the Classifieds page publicly accessible?</span>
          <span class="toggle-icon">+</span>
        </div>
        <div class="faq-answer">
          <p>Yes! Unlike our premium candidate profiles and redistricting tools, the Classifieds and Advertise pages are accessible to the public, maximizing exposure for your postings.</p>
        </div>
      </div>
      <!-- Q3 -->
      <div class="faq-item">
        <div class="faq-question">
          <span>Can I request a custom run period?</span>
          <span class="toggle-icon">+</span>
        </div>
        <div class="faq-answer">
          <p>Absolutely. If our standard weekly or monthly options don't match your schedule, please reach out to our team at info@californiatargetbook.com for custom packages.</p>
        </div>
      </div>
      <!-- Q4 -->
      <div class="faq-item">
        <div class="faq-question">
          <span>Can I edit my ad after it goes live?</span>
          <span class="toggle-icon">+</span>
        </div>
        <div class="faq-answer">
          <p>Yes, you can edit your active ad content. Simply email our support team with the updated text or link, and we'll process the changes within a business day.</p>
        </div>
      </div>
      <!-- Q5 -->
      <div class="faq-item">
        <div class="faq-question">
          <span>What happens when my ad expires?</span>
          <span class="toggle-icon">+</span>
        </div>
        <div class="faq-answer">
          <p>Once your purchased run duration concludes, your ad will automatically transition to inactive status and stop appearing in the daily report and on the main listings section.</p>
        </div>
      </div>
    </div>
  </section>

  @include('layouts.footer')

  <script src="/js/script.js"></script>
  
  <!-- FAQ Toggle JS -->
  <script>
    document.querySelectorAll('.faq-question').forEach(question => {
      question.addEventListener('click', () => {
        const item = question.parentElement;
        item.classList.toggle('active');
      });
    });
  </script>
</body>

</html>
