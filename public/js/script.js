// =========================================================
// CALIFORNIA TARGET BOOK — CLONE SCRIPT
// =========================================================

document.addEventListener('DOMContentLoaded', function () {

  /* ---- Sticky navbar background on scroll ---- */
  const nav = document.getElementById('mainNav');
  function handleScroll() {
    if (window.scrollY > 60) {
      nav.classList.add('scrolled');
    } else {
      nav.classList.remove('scrolled');
    }
  }
  window.addEventListener('scroll', handleScroll);
  handleScroll();

  /* ---- Mobile nav toggle ---- */
  const toggle = document.getElementById('navToggle');
  const menu = document.getElementById('navMenu');
  toggle.addEventListener('click', function () {
    menu.classList.toggle('open');
  });
  menu.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      menu.classList.remove('open');
    });
  });



  /* ---- Newsletter form (front-end only demo) ---- */
  const newsletterForm = document.getElementById('newsletterForm');
  newsletterForm.addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Thanks for subscribing! (demo form — no data is sent)');
    newsletterForm.reset();
  });

  /* ---- Footer contact form (front-end only demo) ---- */
  const contactForm = document.getElementById('contactForm');
  contactForm.addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Message sent! (demo form — no data is sent)');
    contactForm.reset();
  });

  /* ---- Smooth-scroll for on-page anchor links ---- */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      if (targetId.length > 1) {
        const target = document.querySelector(targetId);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });

});
