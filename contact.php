<?php
/**
 * FourMap - Contact Page
 */

// ===== SEO من قاعدة البيانات =====
$seoPage = 'contact';

require_once 'includes/db.php';
require_once 'includes/settings.php';

$contactEmail   = get_setting($pdo, 'contact_email',   '');
$contactPhone   = get_setting($pdo, 'contact_phone',   '');
$contactAddress = get_setting($pdo, 'contact_address', 'المملكة العربية السعودية');
$waNumber       = get_setting($pdo, 'contact_whatsapp','201044258597');
$socialX        = get_setting($pdo, 'social_x',        '');
$socialInsta    = get_setting($pdo, 'social_instagram','');
$socialLinked   = get_setting($pdo, 'social_linkedin', '');
$socialYt       = get_setting($pdo, 'social_youtube',  '');

require_once 'includes/header.php';
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="contact-page-title">
  <div class="container">
    <h1 id="contact-page-title">تواصل <span>معنا</span></h1>
    <div class="page-breadcrumb">
      <a href="index.php">الرئيسية</a> / تواصل معنا
    </div>
  </div>
</section>

<!-- CONTACT SECTION -->
<section class="contact-page-section">
  <div class="container">

    <div class="contact-page-intro">
      <p>فريقنا جاهز للإجابة على جميع استفساراتك — اختر الطريقة الأنسب لك للتواصل معنا</p>
    </div>

    <div class="contact-cards-grid">

      <?php if (!empty($waNumber)): ?>
      <a href="https://wa.me/<?php echo htmlspecialchars($waNumber); ?>?text=<?php echo urlencode('السلام عليكم، أريد الاستفسار عن خدماتكم'); ?>"
         class="contact-card contact-card--wa" target="_blank" rel="noopener">
        <div class="contact-card-icon">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.125.553 4.122 1.523 5.855L0 24l6.335-1.498A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.894 0-3.668-.497-5.2-1.367l-.374-.217-3.853.911.977-3.762-.243-.389A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
          </svg>
        </div>
        <div class="contact-card-content">
          <span class="contact-card-label">واتساب</span>
          <span class="contact-card-value">تواصل معنا الآن</span>
        </div>
        <div class="contact-card-arrow">←</div>
      </a>
      <?php endif; ?>

      <?php if (!empty($contactPhone)): ?>
      <a href="tel:<?php echo htmlspecialchars($contactPhone); ?>" class="contact-card contact-card--phone">
        <div class="contact-card-icon">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
          </svg>
        </div>
        <div class="contact-card-content">
          <span class="contact-card-label">رقم الجوال</span>
          <span class="contact-card-value" dir="ltr"><?php echo htmlspecialchars($contactPhone); ?></span>
        </div>
        <div class="contact-card-arrow">←</div>
      </a>
      <?php endif; ?>

      <?php if (!empty($contactEmail)): ?>
      <a href="mailto:<?php echo htmlspecialchars($contactEmail); ?>" class="contact-card contact-card--email">
        <div class="contact-card-icon">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
          </svg>
        </div>
        <div class="contact-card-content">
          <span class="contact-card-label">البريد الإلكتروني</span>
          <span class="contact-card-value"><?php echo htmlspecialchars($contactEmail); ?></span>
        </div>
        <div class="contact-card-arrow">←</div>
      </a>
      <?php endif; ?>

      <?php if (!empty($contactAddress)): ?>
      <div class="contact-card contact-card--address">
        <div class="contact-card-icon">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
          </svg>
        </div>
        <div class="contact-card-content">
          <span class="contact-card-label">العنوان</span>
          <span class="contact-card-value"><?php echo htmlspecialchars($contactAddress); ?></span>
        </div>
      </div>
      <?php endif; ?>

    </div>

    <!-- Social -->
    <?php
    $hasSocial = (!empty($socialX) && $socialX !== '#') ||
                 (!empty($socialInsta) && $socialInsta !== '#') ||
                 (!empty($socialLinked) && $socialLinked !== '#') ||
                 (!empty($socialYt) && $socialYt !== '#');
    ?>
    <?php if ($hasSocial): ?>
    <div class="contact-social-section">
      <h3>تابعنا على السوشيال ميديا</h3>
      <div class="contact-social-icons">
        <?php if (!empty($socialX) && $socialX !== '#'): ?>
        <a href="<?php echo htmlspecialchars($socialX); ?>" target="_blank" rel="noopener" class="contact-social-btn" aria-label="X">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L2.25 2.25h6.865l4.249 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <?php endif; ?>
        <?php if (!empty($socialInsta) && $socialInsta !== '#'): ?>
        <a href="<?php echo htmlspecialchars($socialInsta); ?>" target="_blank" rel="noopener" class="contact-social-btn" aria-label="Instagram">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        </a>
        <?php endif; ?>
        <?php if (!empty($socialLinked) && $socialLinked !== '#'): ?>
        <a href="<?php echo htmlspecialchars($socialLinked); ?>" target="_blank" rel="noopener" class="contact-social-btn" aria-label="LinkedIn">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </a>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="contact-cta-strip">
      <div class="contact-cta-text">
        <h3>هل تريد طلب استشارة هندسية؟</h3>
        <p>أرسل تفاصيل مشروعك وسنتواصل معك في أقرب وقت</p>
      </div>
      <a href="consultation.php" class="contact-cta-btn">
        طلب استشارة الآن
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
      </a>
    </div>

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>