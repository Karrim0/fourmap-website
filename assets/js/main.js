/**
 * FourMap - Main JavaScript
 * RTL Arabic Website
 * Pure Vanilla JS
 */

document.addEventListener("DOMContentLoaded", function () {
  /* ===========================================
     MOBILE NAVIGATION TOGGLE
     =========================================== */
  const hamburger = document.querySelector(".nav-hamburger");
  const navMenu = document.querySelector(".nav-menu");

  if (hamburger && navMenu) {
    hamburger.addEventListener("click", function () {
      this.classList.toggle("open");
      navMenu.classList.toggle("open");
    });

    // Close menu when a link is clicked
    navMenu.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        hamburger.classList.remove("open");
        navMenu.classList.remove("open");
      });
    });

    // Close menu when clicking outside
    document.addEventListener("click", function (e) {
      if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
        hamburger.classList.remove("open");
        navMenu.classList.remove("open");
      }
    });
  }

  /* ===========================================
     SCROLL TO TOP BUTTON
     =========================================== */
  var scrollBtn = document.querySelector(".scroll-top");

  if (scrollBtn) {
    window.addEventListener("scroll", function () {
      if (window.scrollY > 380) {
        scrollBtn.classList.add("visible");
      } else {
        scrollBtn.classList.remove("visible");
      }
    });

    scrollBtn.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  /* ===========================================
     STICKY HEADER SHADOW ENHANCEMENT
     =========================================== */
  var siteHeader = document.querySelector(".site-header");

  if (siteHeader) {
    window.addEventListener("scroll", function () {
      if (window.scrollY > 10) {
        siteHeader.style.boxShadow = "0 4px 28px rgba(0,0,0,0.5)";
      } else {
        siteHeader.style.boxShadow = "0 2px 18px rgba(0,0,0,0.35)";
      }
    });
  }

  /* ===========================================
     SCROLL REVEAL ANIMATION
     Uses IntersectionObserver
     =========================================== */
  var revealEls = document.querySelectorAll(
    ".why-item, .service-full-card, .team-card, .stat-card, .mission-card",
  );

  if ("IntersectionObserver" in window && revealEls.length) {
    // Set initial invisible state
    revealEls.forEach(function (el, i) {
      el.style.opacity = "0";
      el.style.transform = "translateY(28px)";
      el.style.transition =
        "opacity 0.5s ease " +
        (i % 4) * 0.1 +
        "s, transform 0.5s ease " +
        (i % 4) * 0.1 +
        "s";
    });

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.style.opacity = "1";
            entry.target.style.transform = "translateY(0)";
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12 },
    );

    revealEls.forEach(function (el) {
      observer.observe(el);
    });
  }

  /* ===========================================
     CONTACT FORM CLIENT-SIDE VALIDATION
     =========================================== */
  var contactForm = document.getElementById("contact-form");

  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      var isValid = true;

      // Clear previous errors
      contactForm.querySelectorAll(".field-error").forEach(function (el) {
        el.remove();
      });
      contactForm
        .querySelectorAll(".form-group input, .form-group textarea")
        .forEach(function (el) {
          el.style.borderColor = "";
        });

      var nameField = document.getElementById("name");
      var phoneField = document.getElementById("phone");
      var emailField = document.getElementById("email");
      var msgField = document.getElementById("message");

      // Validate name
      if (nameField && nameField.value.trim().length < 2) {
        showFieldError(nameField, "الرجاء إدخال الاسم الكامل");
        isValid = false;
      }

      // Validate phone
      if (phoneField && !/^[\d\s\+\-\(\)]{7,}$/.test(phoneField.value.trim())) {
        showFieldError(phoneField, "الرجاء إدخال رقم جوال صحيح");
        isValid = false;
      }

      // Validate email
      if (emailField && emailField.value.trim() !== "") {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailField.value.trim())) {
          showFieldError(emailField, "الرجاء إدخال بريد إلكتروني صحيح");
          isValid = false;
        }
      }

      // Validate message
      if (msgField && msgField.value.trim().length < 10) {
        showFieldError(msgField, "الرجاء كتابة رسالة لا تقل عن 10 أحرف");
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
        // Scroll to first error
        var firstError = contactForm.querySelector(".field-error");
        if (firstError) {
          firstError.scrollIntoView({ behavior: "smooth", block: "center" });
        }
      }
    });
  }

  function showFieldError(field, message) {
    field.style.borderColor = "#e74c3c";
    var errorEl = document.createElement("p");
    errorEl.className = "field-error";
    errorEl.style.cssText =
      "color:#e74c3c;font-size:0.82rem;margin-top:5px;font-weight:600;";
    errorEl.textContent = message;
    field.parentNode.appendChild(errorEl);
  }

  /* ===========================================
     AUTO-DISMISS ALERT MESSAGES
     =========================================== */
  var alerts = document.querySelectorAll(".alert");
  alerts.forEach(function (alert) {
    setTimeout(function () {
      alert.style.transition = "opacity 0.6s ease";
      alert.style.opacity = "0";
      setTimeout(function () {
        alert.remove();
      }, 600);
    }, 5000);
  });

  /* ===========================================
     SMOOTH HOVER EFFECT ON SERVICE STRIPS
     (Enhancement for touch devices)
     =========================================== */
  document.querySelectorAll(".service-strip").forEach(function (strip) {
    strip.addEventListener(
      "touchstart",
      function () {
        this.querySelector(".service-strip-overlay").style.opacity = "1";
      },
      { passive: true },
    );
    strip.addEventListener(
      "touchend",
      function () {
        var self = this;
        setTimeout(function () {
          self.querySelector(".service-strip-overlay").style.opacity = "0.9";
        }, 1200);
      },
      { passive: true },
    );
  });
});
