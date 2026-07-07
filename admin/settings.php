<?php
$page_title = 'إعدادات الموقع';
include 'partials/header.php';
require_once '../includes/db.php';
require_once '../includes/settings.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // HERO
    set_setting($pdo, 'hero_title_text',      trim($_POST['hero_title_text'] ?? ''),      'text');
    set_setting($pdo, 'hero_title_highlight', trim($_POST['hero_title_highlight'] ?? ''), 'text');
    set_setting($pdo, 'hero_subtitle',        trim($_POST['hero_subtitle'] ?? ''),        'text');
    set_setting($pdo, 'appstore_url',         trim($_POST['appstore_url'] ?? ''),         'url');
    set_setting($pdo, 'googleplay_url',       trim($_POST['googleplay_url'] ?? ''),       'url');

    $heroImgPath = upload_setting_image('hero_image', 'assets/uploads/settings/');
    if ($heroImgPath) set_setting($pdo, 'hero_image', $heroImgPath, 'image');

    // ABOUT (homepage)
    set_setting($pdo, 'about_title', trim($_POST['about_title'] ?? ''), 'text');
    set_setting($pdo, 'about_p1',    trim($_POST['about_p1'] ?? ''),    'textarea');
    set_setting($pdo, 'about_p2',    trim($_POST['about_p2'] ?? ''),    'textarea');

    $aboutImgPath = upload_setting_image('about_image', 'assets/uploads/settings/');
    if ($aboutImgPath) set_setting($pdo, 'about_image', $aboutImgPath, 'image');

    // VISION
    set_setting($pdo, 'vision_text', trim($_POST['vision_text'] ?? ''), 'textarea');

    $visionHeader = upload_setting_image('vision_header_image', 'assets/uploads/settings/');
    if ($visionHeader) set_setting($pdo, 'vision_header_image', $visionHeader, 'image');

    $visionMap = upload_setting_image('vision_map_image', 'assets/uploads/settings/');
    if ($visionMap) set_setting($pdo, 'vision_map_image', $visionMap, 'image');

    // WHY US
    set_setting($pdo, 'why_title',    trim($_POST['why_title'] ?? ''),    'text');
    set_setting($pdo, 'why_subtitle', trim($_POST['why_subtitle'] ?? ''), 'text');

    for ($i = 1; $i <= 4; $i++) {
        set_setting($pdo, "why{$i}_title", trim($_POST["why{$i}_title"] ?? ''), 'text');
        set_setting($pdo, "why{$i}_text",  trim($_POST["why{$i}_text"] ?? ''),  'text');
        $iconPath = upload_setting_image("why{$i}_icon", 'assets/uploads/settings/');
        if ($iconPath) set_setting($pdo, "why{$i}_icon", $iconPath, 'image');
    }

    // ABOUT PAGE
    set_setting($pdo, 'about_page_title_main',        trim($_POST['about_page_title_main'] ?? ''),        'text');
    set_setting($pdo, 'about_page_title_highlight',   trim($_POST['about_page_title_highlight'] ?? ''),   'text');
    set_setting($pdo, 'about_page_breadcrumb_label',  trim($_POST['about_page_breadcrumb_label'] ?? ''),  'text');
    set_setting($pdo, 'about_page_heading_text',      trim($_POST['about_page_heading_text'] ?? ''),      'text');
    set_setting($pdo, 'about_page_heading_highlight', trim($_POST['about_page_heading_highlight'] ?? ''), 'text');
    set_setting($pdo, 'about_page_p1', trim($_POST['about_page_p1'] ?? ''), 'textarea');
    set_setting($pdo, 'about_page_p2', trim($_POST['about_page_p2'] ?? ''), 'textarea');
    set_setting($pdo, 'about_page_p3', trim($_POST['about_page_p3'] ?? ''), 'textarea');

    $aboutPageImg = upload_setting_image('about_page_image', 'assets/uploads/settings/');
    if ($aboutPageImg) set_setting($pdo, 'about_page_image', $aboutPageImg, 'image');

    // ABOUT PAGE STATS
    set_setting($pdo, 'about_stats_1_number', trim($_POST['about_stats_1_number'] ?? ''), 'text');
    set_setting($pdo, 'about_stats_1_label',  trim($_POST['about_stats_1_label'] ?? ''),  'text');
    set_setting($pdo, 'about_stats_2_number', trim($_POST['about_stats_2_number'] ?? ''), 'text');
    set_setting($pdo, 'about_stats_2_label',  trim($_POST['about_stats_2_label'] ?? ''),  'text');
    set_setting($pdo, 'about_stats_3_number', trim($_POST['about_stats_3_number'] ?? ''), 'text');
    set_setting($pdo, 'about_stats_3_label',  trim($_POST['about_stats_3_label'] ?? ''),  'text');

    // FOOTER & CONTACT
    set_setting($pdo, 'footer_about',     trim($_POST['footer_about'] ?? ''),     'textarea');
    set_setting($pdo, 'footer_copyright', trim($_POST['footer_copyright'] ?? ''), 'text');
    set_setting($pdo, 'contact_email',    trim($_POST['contact_email'] ?? ''),    'text');
    set_setting($pdo, 'contact_phone',    trim($_POST['contact_phone'] ?? ''),    'text');
    set_setting($pdo, 'contact_address',  trim($_POST['contact_address'] ?? ''),  'text');
    set_setting($pdo, 'contact_whatsapp', trim($_POST['contact_whatsapp'] ?? ''), 'text');

    // SOCIAL
    set_setting($pdo, 'social_x',         trim($_POST['social_x'] ?? ''),         'url');
    set_setting($pdo, 'social_instagram',  trim($_POST['social_instagram'] ?? ''), 'url');
    set_setting($pdo, 'social_linkedin',   trim($_POST['social_linkedin'] ?? ''),  'url');
    set_setting($pdo, 'social_youtube',    trim($_POST['social_youtube'] ?? ''),   'url');

    // LOGO
    if (!empty($_FILES['site_logo']['name'])) {
        $uploadDir = __DIR__ . '/../assets/uploads/settings/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);
        $ext = strtolower(pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION));
        $allowed = ['png','jpg','jpeg','webp','svg'];
        if (!in_array($ext, $allowed, true)) {
            $error = 'صيغة اللوجو غير مدعومة';
        } else {
            $fileName = 'logo_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $uploadDir . $fileName)) {
                set_setting($pdo, 'site_logo', 'assets/uploads/settings/' . $fileName, 'image');
            } else {
                $error = 'فشل رفع اللوجو';
            }
        }
    }

    if ($error === '') {
        header("Location: settings.php?success=1");
        exit;
    }
}

// ——— Load all settings ———
$siteLogo    = get_setting($pdo, 'site_logo',    'assets/images/logo-map.png');
$footerAbout = get_setting($pdo, 'footer_about', '');
$copyright   = get_setting($pdo, 'footer_copyright', '© {{year}} فور ماب — جميع الحقوق محفوظة');
$email       = get_setting($pdo, 'contact_email',   '');
$phone       = get_setting($pdo, 'contact_phone',   '');
$address     = get_setting($pdo, 'contact_address', '');
$whatsapp    = get_setting($pdo, 'contact_whatsapp', '');
$socialX     = get_setting($pdo, 'social_x',        '#');
$socialInsta = get_setting($pdo, 'social_instagram','#');
$socialLinked= get_setting($pdo, 'social_linkedin', '#');
$socialYt    = get_setting($pdo, 'social_youtube',  '#');

$heroTitleText      = get_setting($pdo, 'hero_title_text',      'كل خدماتك الهندسية،');
$heroTitleHighlight = get_setting($pdo, 'hero_title_highlight', 'بين يديك !');
$heroSubtitle       = get_setting($pdo, 'hero_subtitle',        'مكتبك الهندسي المتنقل');
$appStoreUrl        = get_setting($pdo, 'appstore_url',  '#');
$googlePlayUrl      = get_setting($pdo, 'googleplay_url','#');
$heroImage          = get_setting($pdo, 'hero_image',    'assets/images/01.png');

$aboutTitle = get_setting($pdo, 'about_title', 'من نحن؟');
$aboutP1    = get_setting($pdo, 'about_p1',    '');
$aboutP2    = get_setting($pdo, 'about_p2',    '');
$aboutImage = get_setting($pdo, 'about_image', 'assets/images/about.png');

$visionText        = get_setting($pdo, 'vision_text',         '');
$visionHeaderImage = get_setting($pdo, 'vision_header_image', 'assets/images/visionheader.png');
$visionMapImage    = get_setting($pdo, 'vision_map_image',    'assets/images/09.png');

$whyTitle    = get_setting($pdo, 'why_title',    'ليه فور ماب؟');
$whySubtitle = get_setting($pdo, 'why_subtitle', 'منصة رقمية موحدة');

$defaultIcons  = [1=>'assets/images/11.png', 2=>'assets/images/10.png', 3=>'assets/images/12.png', 4=>'assets/images/13.png'];
$defaultTitles = [1=>'سهولة الوصول', 2=>'مهندسين سعوديين', 3=>'تنفيذ سريع وموثوق', 4=>'توثيق ومصداقية'];
$defaultTexts  = [1=>'كل الخدمات متوفرة عبر الجوال', 2=>'خدمات واستشارات عبر محترفين', 3=>'نظام متابعة فوري', 4=>'إجراءات مرتبطة بجهات موثوقة'];
$why = [];
for ($i = 1; $i <= 4; $i++) {
    $why[$i] = [
        'icon'  => get_setting($pdo, "why{$i}_icon",  $defaultIcons[$i]),
        'title' => get_setting($pdo, "why{$i}_title", $defaultTitles[$i]),
        'text'  => get_setting($pdo, "why{$i}_text",  $defaultTexts[$i]),
    ];
}

$aboutPageTitleMain       = get_setting($pdo, 'about_page_title_main',       'من');
$aboutPageTitleHighlight  = get_setting($pdo, 'about_page_title_highlight',  'نحن');
$aboutPageBreadcrumb      = get_setting($pdo, 'about_page_breadcrumb_label', 'من نحن');
$aboutPageHeadingText     = get_setting($pdo, 'about_page_heading_text',     'نحن');
$aboutPageHeadingHighlight= get_setting($pdo, 'about_page_heading_highlight','فور ماب');
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
?>

<div class="admin-wrapper">
  <?php include 'partials/sidebar.php'; ?>

  <div class="main-content">
    <div class="top-bar">
      <button class="btn-toggle-sidebar d-lg-none" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <h1 class="page-title">إعدادات الموقع</h1>
    </div>

    <div class="content-wrapper">

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <i class="bi bi-check-circle-fill me-2"></i> تم حفظ الإعدادات بنجاح
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">

        <!-- ======= TABS NAV ======= -->
        <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
          <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-general"><i class="bi bi-sliders me-1"></i> عام</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-hero"><i class="bi bi-house me-1"></i> الهيرو</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-about-home"><i class="bi bi-info-circle me-1"></i> من نحن (رئيسي)</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-vision"><i class="bi bi-eye me-1"></i> الرؤية</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-whyus"><i class="bi bi-patch-question me-1"></i> ليه فور ماب</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-about-page"><i class="bi bi-file-person me-1"></i> صفحة من نحن</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-footer"><i class="bi bi-layout-sidebar-inset-reverse me-1"></i> الفوتر والتواصل</button></li>
        </ul>

        <div class="tab-content">

          <!-- ===== TAB: عام ===== -->
          <div class="tab-pane fade show active" id="tab-general">
            <div class="card">
              <div class="card-header"><h5 class="card-title mb-0">إعدادات عامة</h5></div>
              <div class="card-body">

                <div class="mb-4">
                  <label class="form-label fw-semibold">لوجو الموقع</label>
                  <input type="file" name="site_logo" class="form-control" accept="image/*" onchange="previewImg(event,'logoPreview')">
                  <div class="form-text">PNG / SVG بخلفية شفافة مفضل</div>
                  <div class="mt-3">
                    <img id="logoPreview"
                         src="../<?php echo htmlspecialchars(ltrim($siteLogo,'/')); ?>"
                         class="img-thumbnail" style="max-width:160px;"
                         onerror="this.style.display='none'">
                  </div>
                </div>

                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">رابط App Store</label>
                    <input type="url" name="appstore_url" class="form-control" value="<?php echo htmlspecialchars($appStoreUrl); ?>" placeholder="https://apps.apple.com/...">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">رابط Google Play</label>
                    <input type="url" name="googleplay_url" class="form-control" value="<?php echo htmlspecialchars($googlePlayUrl); ?>" placeholder="https://play.google.com/...">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="bi bi-whatsapp me-1"></i> رقم واتساب</label>
                    <input type="text" name="contact_whatsapp" class="form-control" value="<?php echo htmlspecialchars($whatsapp); ?>" placeholder="201044258597">
                    <div class="form-text">بدون + أو مسافات — مثال: 201044258597</div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- ===== TAB: الهيرو ===== -->
          <div class="tab-pane fade" id="tab-hero">
            <div class="card">
              <div class="card-header"><h5 class="card-title mb-0">قسم الهيرو - الصفحة الرئيسية</h5></div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">العنوان الرئيسي</label>
                    <input type="text" name="hero_title_text" class="form-control" value="<?php echo htmlspecialchars($heroTitleText); ?>">
                    <div class="form-text">مثال: كل خدماتك الهندسية،</div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">الكلمة المميزة (أصفر)</label>
                    <input type="text" name="hero_title_highlight" class="form-control" value="<?php echo htmlspecialchars($heroTitleHighlight); ?>">
                    <div class="form-text">مثال: بين يديك !</div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">العنوان الفرعي</label>
                    <input type="text" name="hero_subtitle" class="form-control" value="<?php echo htmlspecialchars($heroSubtitle); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">صورة الهيرو (اختياري)</label>
                    <input type="file" name="hero_image" class="form-control" accept="image/*" onchange="previewImg(event,'heroImagePreview')">
                    <div class="mt-3">
                      <img id="heroImagePreview"
                           src="../<?php echo htmlspecialchars(ltrim($heroImage,'/')); ?>"
                           class="img-thumbnail" style="max-width:220px;"
                           onerror="this.style.display='none'">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ===== TAB: من نحن (رئيسي) ===== -->
          <div class="tab-pane fade" id="tab-about-home">
            <div class="card">
              <div class="card-header"><h5 class="card-title mb-0">قسم "من نحن" - الصفحة الرئيسية</h5></div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">عنوان القسم</label>
                    <input type="text" name="about_title" class="form-control" value="<?php echo htmlspecialchars($aboutTitle); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">صورة القسم (اختياري)</label>
                    <input type="file" name="about_image" class="form-control" accept="image/*" onchange="previewImg(event,'aboutImagePreview')">
                    <div class="mt-3">
                      <img id="aboutImagePreview"
                           src="../<?php echo htmlspecialchars(ltrim($aboutImage,'/')); ?>"
                           class="img-thumbnail" style="max-width:220px;"
                           onerror="this.style.display='none'">
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">الفقرة الأولى</label>
                    <textarea name="about_p1" class="form-control" rows="4"><?php echo htmlspecialchars($aboutP1); ?></textarea>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">الفقرة الثانية</label>
                    <textarea name="about_p2" class="form-control" rows="4"><?php echo htmlspecialchars($aboutP2); ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ===== TAB: الرؤية ===== -->
          <div class="tab-pane fade" id="tab-vision">
            <div class="card">
              <div class="card-header"><h5 class="card-title mb-0">قسم الرؤية المستقبلية</h5></div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">صورة عنوان الرؤية (اختياري)</label>
                    <input type="file" name="vision_header_image" class="form-control" accept="image/*" onchange="previewImg(event,'visionHeaderPreview')">
                    <div class="mt-3">
                      <img id="visionHeaderPreview"
                          src="../<?php echo htmlspecialchars(ltrim($visionHeaderImage,'/')); ?>"
                          class="img-thumbnail" style="max-width:260px;"
                          onerror="this.style.display='none'">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">صورة الخريطة (اختياري)</label>
                    <input type="file" name="vision_map_image" class="form-control" accept="image/*" onchange="previewImg(event,'visionMapPreview')">
                    <div class="mt-3">
                      <img id="visionMapPreview"
                          src="../<?php echo htmlspecialchars(ltrim($visionMapImage,'/')); ?>"
                          class="img-thumbnail" style="max-width:260px;"
                          onerror="this.style.display='none'">
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">نص الرؤية</label>
                    <textarea name="vision_text" class="form-control" rows="6"><?php echo htmlspecialchars($visionText); ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ===== TAB: ليه فور ماب ===== -->
          <div class="tab-pane fade" id="tab-whyus">
            <div class="card">
              <div class="card-header"><h5 class="card-title mb-0">قسم "ليه فور ماب؟"</h5></div>
              <div class="card-body">
                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">عنوان القسم</label>
                    <input type="text" name="why_title" class="form-control" value="<?php echo htmlspecialchars($whyTitle); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold">الوصف المختصر</label>
                    <input type="text" name="why_subtitle" class="form-control" value="<?php echo htmlspecialchars($whySubtitle); ?>">
                  </div>
                </div>

                <?php for ($i = 1; $i <= 4; $i++): ?>
                  <div class="card mb-3 border">
                    <div class="card-body">
                      <h6 class="mb-3 text-muted">العنصر رقم <?php echo $i; ?></h6>
                      <div class="row g-3 align-items-start">
                        <div class="col-md-3">
                          <label class="form-label fw-semibold">الأيقونة</label>
                          <input type="file" name="why<?php echo $i; ?>_icon" class="form-control" accept="image/*"
                                 onchange="previewImg(event,'whyIconPreview<?php echo $i; ?>')">
                          <div class="mt-2">
                            <img id="whyIconPreview<?php echo $i; ?>"
                                 src="../<?php echo htmlspecialchars(ltrim($why[$i]['icon'],'/')); ?>"
                                 class="img-thumbnail" style="max-width:100px;"
                                 onerror="this.style.display='none'">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label fw-semibold">العنوان</label>
                          <input type="text" name="why<?php echo $i; ?>_title" class="form-control"
                                 value="<?php echo htmlspecialchars($why[$i]['title']); ?>">
                        </div>
                        <div class="col-md-5">
                          <label class="form-label fw-semibold">الوصف</label>
                          <input type="text" name="why<?php echo $i; ?>_text" class="form-control"
                                 value="<?php echo htmlspecialchars($why[$i]['text']); ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endfor; ?>
              </div>
            </div>
          </div>

          <!-- ===== TAB: صفحة من نحن ===== -->
          <div class="tab-pane fade" id="tab-about-page">
            <div class="card">
              <div class="card-header"><h5 class="card-title mb-0">محتوى صفحة "من نحن"</h5></div>
              <div class="card-body">
                <h6 class="mb-3 text-muted">البانر العلوي</h6>
                <div class="row g-3 mb-4">
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">عنوان البانر (الجزء الأول)</label>
                    <input type="text" name="about_page_title_main" class="form-control" value="<?php echo htmlspecialchars($aboutPageTitleMain); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">الكلمة المميزة</label>
                    <input type="text" name="about_page_title_highlight" class="form-control" value="<?php echo htmlspecialchars($aboutPageTitleHighlight); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Breadcrumb</label>
                    <input type="text" name="about_page_breadcrumb_label" class="form-control" value="<?php echo htmlspecialchars($aboutPageBreadcrumb); ?>">
                  </div>
                </div>

                <h6 class="mb-3 text-muted">المحتوى الرئيسي</h6>
                <div class="row g-3 mb-4">
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">عنوان المحتوى (الجزء الأول)</label>
                    <input type="text" name="about_page_heading_text" class="form-control" value="<?php echo htmlspecialchars($aboutPageHeadingText); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">الكلمة المميزة</label>
                    <input type="text" name="about_page_heading_highlight" class="form-control" value="<?php echo htmlspecialchars($aboutPageHeadingHighlight); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">صورة الصفحة (اختياري)</label>
                    <input type="file" name="about_page_image" class="form-control" accept="image/*" onchange="previewImg(event,'aboutPageImagePreview')">
                    <div class="mt-2">
                      <img id="aboutPageImagePreview"
                           src="../<?php echo htmlspecialchars(ltrim($aboutPageImage,'/')); ?>"
                           class="img-thumbnail" style="max-width:200px;"
                           onerror="this.style.display='none'">
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">الفقرة الأولى</label>
                    <textarea name="about_page_p1" class="form-control" rows="3"><?php echo htmlspecialchars($aboutPageP1); ?></textarea>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">الفقرة الثانية</label>
                    <textarea name="about_page_p2" class="form-control" rows="3"><?php echo htmlspecialchars($aboutPageP2); ?></textarea>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-semibold">الفقرة الثالثة</label>
                    <textarea name="about_page_p3" class="form-control" rows="3"><?php echo htmlspecialchars($aboutPageP3); ?></textarea>
                  </div>
                </div>

                <h6 class="mb-3 text-muted">الإحصائيات</h6>
                <div class="row g-3">
                  <?php
                  $stats = [
                      1 => [$aboutStat1Number, $aboutStat1Label],
                      2 => [$aboutStat2Number, $aboutStat2Label],
                      3 => [$aboutStat3Number, $aboutStat3Label],
                  ];
                  foreach ($stats as $n => [$num, $lbl]): ?>
                  <div class="col-md-4">
                    <div class="card border">
                      <div class="card-body">
                        <label class="form-label fw-semibold">الرقم <?php echo $n; ?></label>
                        <input type="text" name="about_stats_<?php echo $n; ?>_number" class="form-control mb-2" value="<?php echo htmlspecialchars($num); ?>">
                        <label class="form-label fw-semibold">الوصف</label>
                        <input type="text" name="about_stats_<?php echo $n; ?>_label" class="form-control" value="<?php echo htmlspecialchars($lbl); ?>">
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>

              </div>
            </div>
          </div>

          <!-- ===== TAB: الفوتر والتواصل ===== -->
          <div class="tab-pane fade" id="tab-footer">
            <div class="card">
              <div class="card-header"><h5 class="card-title mb-0">الفوتر ومعلومات التواصل</h5></div>
              <div class="card-body">

                <div class="mb-4">
                  <label class="form-label fw-semibold">وصف الفوتر</label>
                  <textarea name="footer_about" class="form-control" rows="4"><?php echo htmlspecialchars($footerAbout); ?></textarea>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-semibold">نص حقوق النشر</label>
                  <input type="text" name="footer_copyright" class="form-control" value="<?php echo htmlspecialchars($copyright); ?>">
                  <div class="form-text">اكتب <code>{{year}}</code> لتحديث السنة تلقائياً</div>
                </div>

                <h6 class="mb-3 text-muted">معلومات التواصل</h6>
                <div class="row g-3 mb-4">
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                    <input type="email" name="contact_email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">رقم الهاتف</label>
                    <input type="text" name="contact_phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">العنوان</label>
                    <input type="text" name="contact_address" class="form-control" value="<?php echo htmlspecialchars($address); ?>">
                  </div>
                </div>

                <h6 class="mb-3 text-muted">روابط السوشيال ميديا</h6>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-twitter-x me-1"></i> X (Twitter)</label>
                    <input type="url" name="social_x" class="form-control" value="<?php echo htmlspecialchars($socialX); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-instagram me-1"></i> Instagram</label>
                    <input type="url" name="social_instagram" class="form-control" value="<?php echo htmlspecialchars($socialInsta); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-linkedin me-1"></i> LinkedIn</label>
                    <input type="url" name="social_linkedin" class="form-control" value="<?php echo htmlspecialchars($socialLinked); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-tiktok me-1"></i> TikTok</label>
                    <input type="url" name="social_youtube" class="form-control" value="<?php echo htmlspecialchars($socialYt); ?>">
                  </div>
                </div>

              </div>
            </div>
          </div>

        </div><!-- /tab-content -->

        <!-- Save button -->
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-primary btn-lg px-5">
            <i class="bi bi-check-circle me-2"></i> حفظ الإعدادات
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
function previewImg(e, previewId) {
    const file = e.target.files[0];
    if (!file) return;
    const img = document.getElementById(previewId);
    if (!img) return;
    img.src = URL.createObjectURL(file);
    img.style.display = 'inline-block';
}

document.addEventListener('DOMContentLoaded', function () {
    const saved = localStorage.getItem('settingsTab');
    if (saved) {
        const el = document.querySelector('[data-bs-target="' + saved + '"]');
        if (el) new bootstrap.Tab(el).show();
    }
    document.querySelectorAll('#settingsTabs button').forEach(function (btn) {
        btn.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem('settingsTab', e.target.getAttribute('data-bs-target'));
        });
    });
});
</script>

<?php include 'partials/footer.php'; ?>