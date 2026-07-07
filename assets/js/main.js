/**
 * FourMap - Main JavaScript
 * RTL Arabic Website
 * Pure Vanilla JS
 */

document.addEventListener("DOMContentLoaded", function () {

  /* ===========================================
     TRANSPARENT NAVBAR — SCROLL EFFECT
     =========================================== */
const siteHeader = document.getElementById("site-header");
const isHome = document.body.classList.contains('is-home');

if (siteHeader) {
  function onScroll() {
    if (!isHome) return;
    siteHeader.classList.toggle("scrolled", window.scrollY > 10);
  }

  if (!isHome) siteHeader.classList.add("scrolled");
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();
}
  /* ===========================================
     MOBILE NAVIGATION TOGGLE
     =========================================== */
  const hamburger = document.getElementById("nav-hamburger");
  const navMenu   = document.getElementById("nav-menu");

  if (hamburger && navMenu) {
    hamburger.addEventListener("click", function () {
      const isOpen = navMenu.classList.toggle("open");
      hamburger.classList.toggle("open", isOpen);
      hamburger.setAttribute("aria-expanded", isOpen);
    });

    // Close menu when a link is clicked
    navMenu.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        navMenu.classList.remove("open");
        hamburger.classList.remove("open");
        hamburger.setAttribute("aria-expanded", "false");
      });
    });

    // Close menu when clicking outside
    document.addEventListener("click", function (e) {
      if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
        navMenu.classList.remove("open");
        hamburger.classList.remove("open");
        hamburger.setAttribute("aria-expanded", "false");
      }
    });
  }

  /* ===========================================
     SCROLL TO TOP BUTTON
     =========================================== */
  const scrollBtn = document.querySelector(".scroll-top");

  if (scrollBtn) {
    window.addEventListener("scroll", function () {
      scrollBtn.classList.toggle("visible", window.scrollY > 380);
    }, { passive: true });

    scrollBtn.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  /* ===========================================
     SCROLL REVEAL ANIMATION
     =========================================== */
  const revealEls = document.querySelectorAll(
    ".why-item, .service-full-card, .team-card, .stat-card, .mission-card"
  );

  if ("IntersectionObserver" in window && revealEls.length) {
    revealEls.forEach(function (el, i) {
      el.style.opacity    = "0";
      el.style.transform  = "translateY(28px)";
      el.style.transition =
        "opacity 0.5s ease " + (i % 4) * 0.1 + "s, " +
        "transform 0.5s ease " + (i % 4) * 0.1 + "s";
    });

    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.style.opacity   = "1";
          entry.target.style.transform = "translateY(0)";
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    revealEls.forEach(function (el) { observer.observe(el); });
  }

  /* ===========================================
     CONTACT FORM CLIENT-SIDE VALIDATION
     =========================================== */
  const contactForm = document.getElementById("contact-form");

  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      let isValid = true;

      // Clear previous errors
      contactForm.querySelectorAll(".field-error").forEach(el => el.remove());
      contactForm.querySelectorAll(".form-group input, .form-group textarea")
        .forEach(el => el.style.borderColor = "");

      const nameField  = document.getElementById("name");
      const phoneField = document.getElementById("phone");
      const emailField = document.getElementById("email");
      const msgField   = document.getElementById("message");

      if (nameField && nameField.value.trim().length < 2) {
        showFieldError(nameField, "الرجاء إدخال الاسم الكامل");
        isValid = false;
      }

      if (phoneField && !/^[\d\s\+\-\(\)]{7,}$/.test(phoneField.value.trim())) {
        showFieldError(phoneField, "الرجاء إدخال رقم جوال صحيح");
        isValid = false;
      }

      if (emailField && emailField.value.trim() !== "") {
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value.trim())) {
          showFieldError(emailField, "الرجاء إدخال بريد إلكتروني صحيح");
          isValid = false;
        }
      }

      if (msgField && msgField.value.trim().length < 10) {
        showFieldError(msgField, "الرجاء كتابة رسالة لا تقل عن 10 أحرف");
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
        const firstError = contactForm.querySelector(".field-error");
        if (firstError) firstError.scrollIntoView({ behavior: "smooth", block: "center" });
      }
    });
  }

  function showFieldError(field, message) {
    field.style.borderColor = "#e74c3c";
    const errorEl = document.createElement("p");
    errorEl.className  = "field-error";
    errorEl.style.cssText = "color:#e74c3c;font-size:0.82rem;margin-top:5px;font-weight:600;";
    errorEl.textContent = message;
    field.parentNode.appendChild(errorEl);
  }

  /* ===========================================
     AUTO-DISMISS ALERT MESSAGES
     =========================================== */
  document.querySelectorAll(".alert").forEach(function (alert) {
    setTimeout(function () {
      alert.style.transition = "opacity 0.6s ease";
      alert.style.opacity    = "0";
      setTimeout(function () { alert.remove(); }, 600);
    }, 5000);
  });

  /* ===========================================
     SERVICE STRIPS — TOUCH HOVER EFFECT
     =========================================== */
  document.querySelectorAll(".service-strip").forEach(function (strip) {
    strip.addEventListener("touchstart", function () {
      const overlay = this.querySelector(".service-strip-overlay");
      if (overlay) overlay.style.opacity = "1";
    }, { passive: true });

    strip.addEventListener("touchend", function () {
      const self = this;
      setTimeout(function () {
        const overlay = self.querySelector(".service-strip-overlay");
        if (overlay) overlay.style.opacity = "0.9";
      }, 1200);
    }, { passive: true });
  });

});

/* ===========================================
   PARTNERS MARQUEE (seamless auto-scroll)
   =========================================== */
(function () {
  const marquee = document.querySelector(".partners-marquee");
  if (!marquee) return;

  const track = marquee.querySelector(".partners-track");
  if (!track) return;

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

  let speed    = parseFloat(marquee.dataset.speed || "35");
  let x        = 0;
  let paused   = false;
  let lastTime = null;

  function getHalfWidth() {
    return track.scrollWidth / 2;
  }

  function tick(ts) {
    if (!lastTime) lastTime = ts;
    const dt = (ts - lastTime) / 1000;
    lastTime = ts;

    if (!paused) {
      x += speed * dt;
      if (x >= getHalfWidth()) x = 0;
      track.style.transform = `translateX(${x}px)`;
    }

    requestAnimationFrame(tick);
  }

  marquee.addEventListener("mouseenter",  () => paused = true);
  marquee.addEventListener("mouseleave",  () => paused = false);
  marquee.addEventListener("touchstart",  () => paused = true,  { passive: true });
  marquee.addEventListener("touchend",    () => paused = false, { passive: true });

  requestAnimationFrame(tick);
})();