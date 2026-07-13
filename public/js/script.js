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

  /* ---- Editorial board data (generic placeholder photos) ---- */
  const staff = [
    { name: 'Marva Diaz', role: 'Publisher', img: 42 },
    { name: 'Darry Sragow', role: 'Publisher Emeritus', img: 51 },
    { name: 'Rob Pyers', role: 'Research Director', img: 12 },
    { name: 'Marty Wilson', role: 'Senior Editor', img: 53 },
    { name: 'Tony Quinn', role: 'Ph.D., Senior Editor', img: 54 },
    { name: 'Andrew Acosta', role: 'Editor', img: 13 },
    { name: 'Robb Korinke', role: 'Editor', img: 14 },
    { name: 'Carla Marinucci', role: 'Editor', img: 47 },
    { name: 'Susan Mcentire', role: 'Editor', img: 48 },
    { name: 'Evan Mclaughlin', role: 'Editor', img: 15 },
    { name: 'Dan Morain', role: 'Editor', img: 52 },
    { name: 'Stephanie Roberson', role: 'Editor', img: 44 },
    { name: 'Rob Stutzman', role: 'Editor', img: 16 },
    { name: 'Roxanne Connelly', role: 'Administrative Director', img: 45 },
    { name: 'Jelena Herrera', role: 'Communications Director', img: 46 },
    { name: 'Allan Hoffenblum', role: '(1940-2015)', img: 55 },
    { name: 'Al Pross', role: '(1942-2019)', img: 56 }
  ];

  const grid = document.getElementById('boardGrid');
  const frag = document.createDocumentFragment();

  staff.forEach(function (person) {
    const card = document.createElement('div');
    card.className = 'staff-card';
    card.innerHTML =
      '<div class="staff-photo">' +
        '<img src="https://i.pravatar.cc/160?img=' + person.img + '" alt="' + person.name + '">' +
      '</div>' +
      '<div class="staff-info">' +
        '<h4>' + person.name + '</h4>' +
        '<span class="role">' + person.role + '</span>' +
        '<a href="#" class="btn-see-more">See more</a>' +
      '</div>';
    frag.appendChild(card);
  });

  grid.appendChild(frag);

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
