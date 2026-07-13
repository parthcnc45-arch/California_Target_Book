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
        @if (Auth::user()->isAdmin())
          <li><a href="/ctb-admin">Admin</a></li>
        @endif
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
