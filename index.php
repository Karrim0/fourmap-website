<?php
/**
 * FourMap - Homepage
 */

$seoPage = 'home';

require_once 'includes/db.php';
require_once 'includes/settings.php';

$whatsapp = get_setting($pdo, 'contact_whatsapp', '201044258597');

// HERO
$heroTitleText      = get_setting($pdo, 'hero_title_text',      'كل خدماتك الهندسية،');
$heroTitleHighlight = get_setting($pdo, 'hero_title_highlight', 'بين يديك !');
$heroSubtitle       = get_setting($pdo, 'hero_subtitle',        'مكتبك الهندسي الرقمى');
$appStoreUrl        = get_setting($pdo, 'appstore_url',         '#');
$googlePlayUrl      = get_setting($pdo, 'googleplay_url',       '#');
$heroImage          = get_setting($pdo, 'hero_image',           'assets/images/hero-bg.jpg');

// ABOUT
$aboutTitle = get_setting($pdo, 'about_title', 'من نحن؟');
$aboutP1    = get_setting($pdo, 'about_p1', '');
$aboutP2    = get_setting($pdo, 'about_p2', '');
$aboutImage = get_setting($pdo, 'about_image', 'assets/images/about.png');

// VISION
$visionText     = get_setting($pdo, 'vision_text',      '');
$visionMapImage = get_setting($pdo, 'vision_map_image', 'assets/images/09.png');

// WHY US
$whyTitle    = get_setting($pdo, 'why_title',    'ليه فور ماب؟');
$whySubtitle = get_setting($pdo, 'why_subtitle', 'منصة رقمية موحدة تجمع كل الخدمات الهندسية المهمة في مكان واحد');

$whyItems = [];
$defaults = [
  1 => ['icon' => 'assets/images/11.png', 'title' => 'سهولة الوصول',      'text' => 'كل الخدمات متوفرة عبر الجوال في تطبيق واحد'],
  2 => ['icon' => 'assets/images/10.png', 'title' => 'مهندسين معتمدين',   'text' => 'خدمات تنفيذ واستشارات عبر محترفين معتمدين'],
  3 => ['icon' => 'assets/images/12.png', 'title' => 'تنفيذ سريع وموثوق', 'text' => 'نظام متابعة فوري من الطلب حتى التسليم'],
  4 => ['icon' => 'assets/images/13.png', 'title' => 'توثيق ومصداقية',    'text' => 'كل الإجراءات مرتبطة بجهات موثوقة ومرخصة'],
];
for ($i = 1; $i <= 4; $i++) {
  $whyItems[$i] = [
    'icon'  => get_setting($pdo, "why{$i}_icon",  $defaults[$i]['icon']),
    'title' => get_setting($pdo, "why{$i}_title", $defaults[$i]['title']),
    'text'  => get_setting($pdo, "why{$i}_text",  $defaults[$i]['text']),
  ];
}

require_once 'includes/header.php';

// Services
$limit = 4;
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM services WHERE status='active' AND is_featured=1");
$countStmt->execute();
$totalServices = (int) $countStmt->fetchColumn();

$listStmt = $pdo->prepare("SELECT title, description, image FROM services WHERE status='active' AND is_featured=1 ORDER BY id DESC LIMIT :limit");
$listStmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$listStmt->execute();
$servicesHome = $listStmt->fetchAll(PDO::FETCH_ASSOC);

// Articles — آخر 3
$articlesStmt = $pdo->prepare("SELECT id, title, excerpt, image, created_at FROM articles WHERE status='active' ORDER BY id DESC LIMIT 3");
$articlesStmt->execute();
$latestArticles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HERO -->
<section class="hero-section" aria-labelledby="hero-title"
  <?php if (!empty($heroImage)): ?>
  style="background-image: url('<?php echo htmlspecialchars($heroImage); ?>')"
  <?php endif; ?>>
  <div class="container">
    <div class="hero-inner">
      <div class="hero-tag">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
        </svg>
        مكتبك الهندسي الرقمي
      </div>
      <h1 class="hero-title" id="hero-title">
        <?php echo htmlspecialchars($heroTitleText); ?>
        <span><?php echo htmlspecialchars($heroTitleHighlight); ?></span>
      </h1>
      <p class="hero-subtitle"><?php echo htmlspecialchars($heroSubtitle); ?></p>
      <div class="hero-buttons">
        <a href="<?php echo htmlspecialchars($appStoreUrl); ?>" class="hero-store-badge" aria-label="تحميل من App Store" target="_blank" rel="noopener">
          <div class="store-badge-inner">
            <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
            <div class="store-badge-text"><span class="store-badge-sub">تحميل من</span><span class="store-badge-name">App Store</span></div>
          </div>
        </a>
        <a href="<?php echo htmlspecialchars($googlePlayUrl); ?>" class="hero-store-badge" aria-label="تحميل من Google Play" target="_blank" rel="noopener">
          <div class="store-badge-inner">
            <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M3.18 23.76c.3.17.64.22.99.16l12.4-7.17-2.58-2.59-10.81 9.6zM.75 1.93C.28 2.36 0 3.05 0 3.97v16.06c0 .92.28 1.61.76 2.04l.11.1 9-9v-.21L.86 1.83l-.11.1zM20.56 10.4l-2.6-1.5-2.9 2.9 2.9 2.9 2.61-1.51c.74-.43.74-1.36-.01-1.79zM3.18.24L15.58 7.4l-2.58 2.59L2.19.39C2.54.33 2.88.38 3.18.55v-.31z"/></svg>
            <div class="store-badge-text"><span class="store-badge-sub">تحميل من</span><span class="store-badge-name">Google Play</span></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="about-section" id="about">
  <div class="about-section-body">
    <div class="container">
      <div class="about-media-box">
        <img src="<?php echo htmlspecialchars($aboutImage); ?>" alt="فور ماب - من نحن" loading="lazy" onerror="this.style.display='none'">
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section" id="services" aria-labelledby="services-heading">
  <div class="section-header">
    <div class="container">
      <h2 class="section-header__title" id="services-heading">خدماتنا <span>الهندسية</span></h2>
      <p class="section-header__sub">نقدم لك كل ما تحتاجه من خدمات هندسية في مكان واحد</p>
    </div>
  </div>
  <div class="services-strips">
    <?php foreach ($servicesHome as $service): ?>
      <div class="service-strip">
        <img src="<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" loading="lazy">
        <a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo urlencode('أريد الاستفسار عن خدمة: ' . $service['title']); ?>" class="service-wa-corner" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.553 4.122 1.523 5.855L0 24l6.335-1.498A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.894 0-3.668-.497-5.2-1.367l-.374-.217-3.853.911.977-3.762-.243-.389A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
        </a>
        <div class="service-strip-overlay">
          <div class="service-caption">
            <h3 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h3>
            <p class="service-desc"><?php echo htmlspecialchars($service['description']); ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if ($totalServices > $limit): ?>
      <a href="services.php" class="service-strip service-more">
        <div class="service-more-content">
          <div class="service-more-icon">
            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M8 12h8M14 9l3 3-3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 class="service-more-title">اكتشف كل خدماتنا</h3>
          <p class="service-more-sub"><strong><?php echo $totalServices; ?></strong> خدمات هندسية متخصصة<br>في انتظارك</p>
          <span class="service-more-cta">عرض الكل <svg class="service-more-arrow" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg></span>
        </div>
      </a>
    <?php endif; ?>
  </div>
</section>

<!-- WHY US -->
<section class="why-section" id="why-us" aria-labelledby="why-heading">
  <div class="section-header">
    <div class="container">
      <h2 class="section-header__title" id="why-heading"><?php echo htmlspecialchars($whyTitle); ?></h2>
      <p class="section-header__sub"><?php echo htmlspecialchars($whySubtitle); ?></p>
    </div>
  </div>
  <div class="why-section-body">
    <div class="container">
      <div class="why-grid">
        <?php for ($i = 1; $i <= 4; $i++): ?>
          <?php if (empty($whyItems[$i]['title'])) continue; ?>
          <div class="why-item">
            <div class="why-icon">
              <img src="<?php echo htmlspecialchars($whyItems[$i]['icon']); ?>" alt="<?php echo htmlspecialchars($whyItems[$i]['title']); ?>" loading="lazy" onerror="this.style.display='none'">
            </div>
            <h3 class="why-item-title"><?php echo htmlspecialchars($whyItems[$i]['title']); ?></h3>
            <p class="why-item-text"><?php echo htmlspecialchars($whyItems[$i]['text']); ?></p>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>

<!-- VISION -->
<section class="vision" id="vision" aria-labelledby="vision-heading">
  <div class="vision-topbar">
    <div class="container">
      <div class="vision-topbar-inner">
        <h2 class="vision-topbar-title" id="vision-heading">رؤيتنا <span>المستقبلية</span></h2>
      </div>
    </div>
  </div>
  <div class="vision-body">
    <div class="container">
      <p class="vision-text"><?php echo htmlspecialchars($visionText); ?></p>
      <div class="vision-map">
        <img class="vision-map-img" src="<?php echo htmlspecialchars($visionMapImage); ?>" alt="خريطة المملكة العربية السعودية - رؤية 2030" loading="lazy">
      </div>
    </div>
  </div>
</section>

<!-- ════════════════════════════════
     ARTICLES — آخر المقالات
════════════════════════════════ -->
<?php if (!empty($latestArticles)): ?>
<section id="articles" aria-labelledby="articles-heading" style="background:var(--w-cream);">

  <div class="section-header" style="background:var(--w-cream);">
    <div class="container">
      <h2 class="section-header__title" id="articles-heading">
        آخر <span>المقالات</span>
      </h2>
      <p class="section-header__sub">اطلع على أحدث المقالات والمعلومات الهندسية</p>
    </div>
  </div>

  <div style="padding: 0 0 80px;">
    <div class="container">

<div class="articles-grid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px; margin-bottom:40px;">
        <?php foreach ($latestArticles as $a): ?>
          <article style="background:var(--w);border-radius:var(--r-lg);overflow:hidden;box-shadow:var(--sh-sm);border:1.5px solid var(--b);display:flex;flex-direction:column;transition:transform var(--ease-bounce),box-shadow var(--ease);"
                   onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='var(--sh-md)'"
                   onmouseout="this.style.transform='';this.style.boxShadow='var(--sh-sm)'">

            <?php if (!empty($a['image'])): ?>
              <a href="article.php?id=<?php echo (int)$a['id']; ?>" style="display:block;height:180px;overflow:hidden;">
                <img src="<?php echo htmlspecialchars($a['image']); ?>"
                     alt="<?php echo htmlspecialchars($a['title']); ?>"
                     loading="lazy"
                     style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s;"
                     onmouseover="this.style.transform='scale(1.07)'"
                     onmouseout="this.style.transform=''"
                     onerror="this.parentElement.style.display='none'">
              </a>
            <?php else: ?>
              <div style="height:160px;background:var(--y-ghost);display:flex;align-items:center;justify-content:center;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--y-dk)" stroke-width="1.2" opacity="0.4">
                  <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>
                </svg>
              </div>
            <?php endif; ?>

            <div style="padding:18px;flex:1;display:flex;flex-direction:column;">
              <div style="font-size:0.75rem;color:var(--t-muted);margin-bottom:8px;">
                <?php echo date('d / m / Y', strtotime($a['created_at'])); ?>
              </div>
              <h3 style="font-size:0.98rem;font-weight:700;color:var(--t-dark);line-height:1.5;margin-bottom:10px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                <a href="article.php?id=<?php echo (int)$a['id']; ?>"
                   style="color:inherit;transition:color var(--ease);"
                   onmouseover="this.style.color='var(--y-dk)'"
                   onmouseout="this.style.color='inherit'">
                  <?php echo htmlspecialchars($a['title']); ?>
                </a>
              </h3>
              <?php if (!empty($a['excerpt'])): ?>
                <p style="font-size:0.84rem;color:var(--t-muted);line-height:1.7;flex:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:14px;">
                  <?php echo htmlspecialchars($a['excerpt']); ?>
                </p>
              <?php endif; ?>
              <a href="article.php?id=<?php echo (int)$a['id']; ?>"
                 style="font-size:0.82rem;font-weight:700;color:var(--y-dk);display:inline-flex;align-items:center;gap:4px;margin-top:auto;">
                اقرأ المزيد
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <!-- زر عرض الكل -->
      <div style="text-align:center;">
        <a href="articles.php" style="display:inline-flex;align-items:center;gap:8px;padding:12px 32px;background:var(--t-dark);color:#fff;font-weight:700;font-size:0.95rem;border-radius:var(--r-pill);transition:background var(--ease),transform var(--ease),color var(--ease);"
           onmouseover="this.style.background='var(--y)';this.style.color='var(--t-dark)';this.style.transform='translateY(-2px)'"
           onmouseout="this.style.background='var(--t-dark)';this.style.color='#fff';this.style.transform=''">
          عرض كل المقالات
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
        </a>
      </div>

    </div>
  </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="cta-section" id="cta" aria-labelledby="cta-title">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-text">
        <h2 id="cta-title">فريقنا من المهندسين <span>المتخصصين</span><br>جاهز لمساعدتك</h2>
        <p>تواصل معنا الآن للحصول على استشارة هندسية أو حمّل التطبيق مباشرة</p>
        <div class="cta-store-badges">
          <a href="<?php echo htmlspecialchars($appStoreUrl); ?>" class="hero-store-badge" target="_blank" rel="noopener">
            <div class="store-badge-inner">
              <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
              <div class="store-badge-text"><span class="store-badge-sub">تحميل من</span><span class="store-badge-name">App Store</span></div>
            </div>
          </a>
          <a href="<?php echo htmlspecialchars($googlePlayUrl); ?>" class="hero-store-badge" target="_blank" rel="noopener">
            <div class="store-badge-inner">
              <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M3.18 23.76c.3.17.64.22.99.16l12.4-7.17-2.58-2.59-10.81 9.6zM.75 1.93C.28 2.36 0 3.05 0 3.97v16.06c0 .92.28 1.61.76 2.04l.11.1 9-9v-.21L.86 1.83l-.11.1zM20.56 10.4l-2.6-1.5-2.9 2.9 2.9 2.9 2.61-1.51c.74-.43.74-1.36-.01-1.79zM3.18.24L15.58 7.4l-2.58 2.59L2.19.39C2.54.33 2.88.38 3.18.55v-.31z"/></svg>
              <div class="store-badge-text"><span class="store-badge-sub">تحميل من</span><span class="store-badge-name">Google Play</span></div>
            </div>
          </a>
        </div>
      </div>
      <div class="cta-phone-wrapper">
        <div class="cta-yellow-frame"><img src="assets/images/logo4.png" alt="" aria-hidden="true"></div>
        <div class="cta-phone">
          <img src="assets/images/mobileapp.png" alt="صورة تطبيق فور ماب على الجوال" loading="lazy" onerror="this.style.display='none'">
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>