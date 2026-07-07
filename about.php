<?php
/**
 * FourMap - About Page
 */

// ===== SEO من قاعدة البيانات =====
$seoPage = 'about';

require_once 'includes/db.php';
require_once 'includes/settings.php';

$aboutPageTitleMain      = get_setting($pdo, 'about_page_title_main',       'من');
$aboutPageTitleHighlight = get_setting($pdo, 'about_page_title_highlight',  'نحن');
$aboutPageBreadcrumb     = get_setting($pdo, 'about_page_breadcrumb_label', 'من نحن');
$aboutPageHeadingText      = get_setting($pdo, 'about_page_heading_text',      'نحن');
$aboutPageHeadingHighlight = get_setting($pdo, 'about_page_heading_highlight', 'فور ماب');
$aboutPageP1    = get_setting($pdo, 'about_page_p1', '');
$aboutPageP2    = get_setting($pdo, 'about_page_p2', '');
$aboutPageP3    = get_setting($pdo, 'about_page_p3', '');
$aboutPageImage = get_setting($pdo, 'about_page_image', 'assets/images/05.png');

$aboutStat1Number = get_setting($pdo, 'about_stats_1_number', '+500');
$aboutStat1Label  = get_setting($pdo, 'about_stats_1_label',  'مشروع منجز');
$aboutStat2Number = get_setting($pdo, 'about_stats_2_number', '+200');
$aboutStat2Label  = get_setting($pdo, 'about_stats_2_label',  'مهندس معتمد');
$aboutStat3Number = get_setting($pdo, 'about_stats_3_number', '+3000');
$aboutStat3Label  = get_setting($pdo, 'about_stats_3_label',  'عميل سعيد');

require_once 'includes/header.php';
?>

<!-- PAGE HERO BANNER -->
<section class="page-hero" aria-labelledby="page-title">
  <div class="container">
    <h1 id="page-title"><?php echo e($aboutPageTitleMain); ?> <span><?php echo e($aboutPageTitleHighlight); ?></span></h1>
    <p class="page-breadcrumb">
      <a href="index.php">الرئيسية</a>
      &nbsp;&rsaquo;&nbsp;
      <?php echo e($aboutPageBreadcrumb); ?>
    </p>
  </div>
</section>

<!-- ABOUT FULL SECTION -->
<section class="about-full" aria-labelledby="about-main-title">
  <div class="container">
    <div class="about-full-grid">

      <div class="about-full-text">
        <h2 id="about-main-title">
          <?php echo e($aboutPageHeadingText); ?> <span><?php echo e($aboutPageHeadingHighlight); ?></span>
        </h2>
        <p><?php echo e($aboutPageP1); ?></p>
        <p><?php echo e($aboutPageP2); ?></p>
        <p><?php echo e($aboutPageP3); ?></p>
      </div>

      <div class="about-img-wrap">
        <img src="<?php echo e($aboutPageImage); ?>"
             alt="فريق فور ماب الهندسي"
             width="520" height="400"
             loading="lazy"
             onerror="this.style.display='none'">
      </div>

    </div>

    <!-- Stats -->
    <div class="about-stats">
      <div class="stat-card">
        <div class="stat-number"><?php echo e($aboutStat1Number); ?></div>
        <div class="stat-label"><?php echo e($aboutStat1Label); ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo e($aboutStat2Number); ?></div>
        <div class="stat-label"><?php echo e($aboutStat2Label); ?></div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo e($aboutStat3Number); ?></div>
        <div class="stat-label"><?php echo e($aboutStat3Label); ?></div>
      </div>
    </div>

  </div>
</section>

<!-- MISSION -->
<section class="mission-section" aria-labelledby="mission-title">
  <div class="container">
    <div class="text-center">
      <h2 class="section-title" id="mission-title">رسالتنا وقيمنا</h2>
    </div>
    <div class="mission-grid">

      <div class="mission-card">
        <div class="mission-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="#1a1a1a">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
          </svg>
        </div>
        <h3>رسالتنا</h3>
        <p>تقديم تجربة هندسية منظمة تعتمد على إجراءات رقمية منضبطة، تحقق التوازن بين الجودة والسرعة ضمن إطار مهني موثوق</p>
      </div>

      <div class="mission-card">
        <div class="mission-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="#1a1a1a">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
          </svg>
        </div>
        <h3>رؤيتنا</h3>
        <p>أن نكون نموذجاً رائداً في تنظيم وإدارة الأعمال الهندسية رقمياً داخل المملكة العربية السعودية، بما ينسجم مع مستهدفات رؤية المملكة 2030</p>
      </div>

      <div class="mission-card">
        <div class="mission-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="#1a1a1a">
            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
          </svg>
        </div>
        <h3>قيمنا</h3>
        <p>الجودة، النزاهة، الابتكار، والتركيز على العميل — هذه القيم هي الأساس الذي نبني عليه كل ما نقدمه.</p>
      </div>

    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>