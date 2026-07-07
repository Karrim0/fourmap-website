<?php
/**
 * FourMap - Services Page
 */

// ===== SEO من قاعدة البيانات =====
$seoPage = 'services';

require_once 'includes/db.php';
require_once 'includes/settings.php';

$whatsapp      = get_setting($pdo, 'contact_whatsapp', '201044258597');
$appStoreUrl   = get_setting($pdo, 'appstore_url',     '#');
$googlePlayUrl = get_setting($pdo, 'googleplay_url',   '#');

$stmt     = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY id DESC");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php';
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="services-page-title">
  <div class="container">
    <h1 id="services-page-title"><span>خدماتنا</span> الهندسية</h1>
    <div class="page-breadcrumb">
      <a href="index.php">الرئيسية</a> / خدماتنا
    </div>
  </div>
</section>

<!-- SERVICES GRID -->
<section class="services-full">
  <div class="container">
    <div class="text-center" style="margin-bottom: 52px;">
      <h2 class="section-title">ماذا نقدم لك؟</h2>
      <p class="section-subtitle" style="margin-top:14px;">
        طيف واسع من الخدمات الهندسية المتخصصة في مكان واحد
      </p>
    </div>

    <div class="services-full-grid">
      <?php foreach ($services as $service): ?>
        <article class="service-full-card">
          <div class="service-full-img">
            <img src="<?php echo htmlspecialchars($service['image']); ?>"
                 alt="<?php echo htmlspecialchars($service['title']); ?>"
                 loading="lazy"
                 onerror="this.style.display='none'">
          </div>
          <div class="service-full-card-body">
            <h3><?php echo htmlspecialchars($service['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($service['description'])); ?></p>
            <a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo urlencode('السلام عليكم، أريد الاستفسار عن خدمة: ' . $service['title']); ?>"
               class="service-wa-btn" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.553 4.122 1.523 5.855L0 24l6.335-1.498A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.894 0-3.668-.497-5.2-1.367l-.374-.217-3.853.911.977-3.762-.243-.389A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
              </svg>
              اطلب الخدمة عبر واتساب
            </a>
          </div>
        </article>
      <?php endforeach; ?>

      <!-- كارت تحميل التطبيق -->
      <div class="service-full-card app-card">
        <div class="app-card-body">
          <div class="app-card-icon">
            <svg viewBox="0 0 24 24" fill="currentColor" width="36" height="36">
              <path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/>
            </svg>
          </div>
          <h3 class="app-card-title">حمّل تطبيق <span>فور ماب</span></h3>
          <p class="app-card-sub">كل خدماتك الهندسية في جيبك — اطلب، تابع، واستلم بسهولة</p>
          <div class="app-card-badges">
            <a href="<?php echo htmlspecialchars($appStoreUrl); ?>" target="_blank" rel="noopener" class="app-badge">
              <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
              </svg>
              <div><span>تحميل من</span><strong>App Store</strong></div>
            </a>
            <a href="<?php echo htmlspecialchars($googlePlayUrl); ?>" target="_blank" rel="noopener" class="app-badge">
              <svg viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                <path d="M3.18 23.76c.3.17.64.22.99.16l12.4-7.17-2.58-2.59-10.81 9.6zM.75 1.93C.28 2.36 0 3.05 0 3.97v16.06c0 .92.28 1.61.76 2.04l.11.1 9-9v-.21L.86 1.83l-.11.1zM20.56 10.4l-2.6-1.5-2.9 2.9 2.9 2.9 2.61-1.51c.74-.43.74-1.36-.01-1.79zM3.18.24L15.58 7.4l-2.58 2.59L2.19.39C2.54.33 2.88.38 3.18.55v-.31z"/>
              </svg>
              <div><span>تحميل من</span><strong>Google Play</strong></div>
            </a>
          </div>
        </div>
      </div>

    </div>

    <?php if (empty($services)): ?>
      <div class="services-empty">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p>لا توجد خدمات متاحة حالياً</p>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- CTA STRIP -->
<section class="services-cta">
  <div class="container">
    <div class="services-cta-inner">
      <div class="services-cta-text">
        <h2>هل تحتاج خدمة هندسية الآن؟</h2>
        <p>تواصل معنا وسنكون سعداء بمساعدتك في أقرب وقت</p>
      </div>
      <div class="services-cta-btns">
        <a href="consultation.php" class="services-cta-btn">
          طلب استشارة
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
        </a>
        <a href="https://wa.me/<?php echo $whatsapp; ?>"
           class="services-cta-btn services-cta-btn--wa" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.125.553 4.122 1.523 5.855L0 24l6.335-1.498A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.894 0-3.668-.497-5.2-1.367l-.374-.217-3.853.911.977-3.762-.243-.389A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
          </svg>
          واتساب
        </a>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>