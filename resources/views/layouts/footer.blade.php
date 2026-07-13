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
