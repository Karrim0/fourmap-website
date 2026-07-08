<?php
/**
 * FourMap Admin — SEO Management Page
 */
$page_title = 'إعدادات SEO';
include 'partials/header.php';
require_once '../includes/db.php';
require_once '../includes/settings.php';

// ─ Save ─
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seoPages = ['home', 'about', 'services', 'contact', 'consultation', 'articles'];
    foreach ($seoPages as $sp) {
        set_setting($pdo, "seo_{$sp}_title",       trim($_POST["seo_{$sp}_title"] ?? ''),       'text');
        set_setting($pdo, "seo_{$sp}_description", trim($_POST["seo_{$sp}_description"] ?? ''), 'textarea');
        set_setting($pdo, "seo_{$sp}_keywords",    trim($_POST["seo_{$sp}_keywords"] ?? ''),    'textarea');
    }
    set_setting($pdo, 'facebook_pixel',        trim($_POST['facebook_pixel']        ?? ''), 'text');
    set_setting($pdo, 'google_analytics',      trim($_POST['google_analytics']      ?? ''), 'text');
    set_setting($pdo, 'google_search_console', trim($_POST['google_search_console'] ?? ''), 'text');
    header("Location: seo.php?success=1");
    exit;
}

// ─ Load ─
$seoPages = ['home', 'about', 'services', 'contact', 'consultation', 'articles'];

$seoLabels = [
    'home'         => ['icon' => 'bi-house',      'label' => 'الرئيسية',   'url' => ''],
    'about'        => ['icon' => 'bi-info-circle','label' => 'من نحن',     'url' => 'about.php'],
    'services'     => ['icon' => 'bi-grid',       'label' => 'خدماتنا',    'url' => 'services.php'],
    'contact'      => ['icon' => 'bi-envelope',   'label' => 'تواصل معنا', 'url' => 'contact.php'],
    'consultation' => ['icon' => 'bi-chat-dots',  'label' => 'استشارة',    'url' => 'consultation.php'],
    'articles'     => ['icon' => 'bi-newspaper',  'label' => 'المقالات',   'url' => 'articles.php'],
];

$seoData = [];
foreach ($seoPages as $sp) {
    $seoData[$sp] = [
        'title'       => get_setting($pdo, "seo_{$sp}_title",       ''),
        'description' => get_setting($pdo, "seo_{$sp}_description", ''),
        'keywords'    => get_setting($pdo, "seo_{$sp}_keywords",    ''),
    ];
}

$doneCount = 0;
foreach ($seoData as $d) {
    if (!empty($d['title']) && !empty($d['description'])) $doneCount++;
}
$totalCount = count($seoPages);
$progress   = round(($doneCount / $totalCount) * 100);
$siteUrl    = 'https://aaadosry.info/fourmap4/';
?>

<style>
/* ══ SEO Tabs Nav ══ */
.seo-tabs-nav {
    display: flex;
    gap: 6px;
    background: var(--body-bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 6px;
    margin-bottom: 24px;
    overflow-x: auto;
    scrollbar-width: none;
}
.seo-tabs-nav::-webkit-scrollbar { display: none; }

.seo-tab-btn {
    flex: 1;
    min-width: 90px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    padding: 10px 12px;
    border: 1.5px solid transparent;
    border-radius: var(--radius);
    background: transparent;
    color: var(--muted);
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--ease);
    position: relative;
    white-space: nowrap;
    font-family: "Cairo", sans-serif;
}
.seo-tab-btn i { font-size: 1.1rem; }

.seo-tab-btn .tab-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    position: absolute;
    top: 7px; left: 50%;
    transform: translateX(-50%);
    display: none;
}
.seo-tab-btn.has-dot .tab-dot  { display: block; background: var(--warning); }
.seo-tab-btn.done-dot .tab-dot { display: block; background: var(--success); }

.seo-tab-btn:hover {
    background: var(--card-bg);
    border-color: var(--border);
    color: var(--text);
}
.seo-tab-btn.active {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--dark);
    font-weight: 700;
    box-shadow: 0 4px 14px rgba(245,197,24,0.3);
}
.seo-tab-btn.active .tab-dot { background: var(--dark) !important; }

/* ══ Tab Panels ══ */
.seo-tab-panel         { display: none; }
.seo-tab-panel.active  { display: block; }

/* ══ Field Card ══ */
.seo-field-card {
    background: var(--card-bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 20px 22px;
    margin-bottom: 14px;
    transition: border-color var(--ease);
}
.seo-field-card:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(245,197,24,0.08);
}

.seo-field-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.seo-field-label i        { color: var(--warning); font-size: 0.9rem; }
.seo-field-label .ms-auto { font-weight: 500; text-transform: none; letter-spacing: 0; font-size: 0.78rem; }

/* ══ Char Bar ══ */
.char-bar-wrap {
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.char-bar-track {
    flex: 1;
    height: 4px;
    border-radius: 99px;
    background: var(--border);
    overflow: hidden;
}
.char-bar-fill {
    height: 100%;
    border-radius: 99px;
    background: var(--border);
    transition: width 0.2s, background 0.2s;
}
.char-label {
    font-size: 0.75rem;
    color: var(--muted);
    min-width: 44px;
    text-align: left;
    direction: ltr;
}

/* ══ Google Preview ══ */
.google-preview-wrap {
    background: var(--body-bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 20px 22px;
    margin-bottom: 14px;
}
.google-preview-wrap .seo-field-label { margin-bottom: 12px; }
.google-preview-inner {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 14px 16px;
    font-family: Arial, sans-serif;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.gp-url   { font-size: 0.74rem; color: #188038; margin-bottom: 3px; }
.gp-title {
    font-size: 1rem; color: #1a0dab; font-weight: 600; line-height: 1.35;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 4px;
}
.gp-desc  {
    font-size: 0.82rem; color: #4d5156; line-height: 1.55;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}

/* ══ Tracking Cards ══ */
.tracking-card {
    background: var(--card-bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 22px;
    margin-bottom: 14px;
    transition: border-color var(--ease);
}
.tracking-card:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(245,197,24,0.08);
}
.tracking-field-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ══ Progress Ring ══ */
.progress-ring-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--card-bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 12px 18px;
}
.progress-ring-label { font-size: 0.85rem; color: var(--muted); line-height: 1.4; }
.progress-ring-label strong { display: block; color: var(--text); font-size: 1rem; font-weight: 800; }

/* ══ Responsive ══ */
@media (max-width: 576px) {
    .seo-tab-btn { min-width: 72px; font-size: 0.75rem; padding: 8px; }
}
</style>

<div class="admin-wrapper">
  <?php include 'partials/sidebar.php'; ?>

  <div class="main-content">

    <div class="top-bar">
      <button class="btn-toggle-sidebar d-lg-none" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
      </button>
      <h1 class="page-title">إعدادات SEO</h1>
      <div class="top-bar-actions">
        <a href="../index.php" target="_blank" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-box-arrow-up-left me-1"></i> معاينة الموقع
        </a>
      </div>
    </div>

    <div class="content-wrapper">

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
          <i class="bi bi-check-circle-fill"></i>
          <span>تم الحفظ بنجاح</span>
          <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <!-- Header Row -->
      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
          <h2 class="mb-1" style="font-size:1.1rem; font-weight:800;">إعدادات SEO</h2>
          <p class="text-muted mb-0" style="font-size:0.85rem;">عنوان ووصف وكلمات كل صفحة لمحركات البحث</p>
        </div>
        <!-- Progress -->
        <div class="progress-ring-wrap">
          <div style="
            width:46px; height:46px; border-radius:50%; flex-shrink:0;
            background: conic-gradient(var(--primary) <?php echo $progress; ?>%, var(--border) 0%);
            display:flex; align-items:center; justify-content:center;
          ">
            <div style="
              width:34px; height:34px; background:var(--card-bg);
              border-radius:50%; display:flex; align-items:center; justify-content:center;
              font-weight:800; font-size:0.62rem; color:var(--text);
            "><?php echo $progress; ?>%</div>
          </div>
          <div class="progress-ring-label">
            <strong><?php echo $doneCount; ?>/<?php echo $totalCount; ?></strong>
            صفحات مكتملة
          </div>
        </div>
      </div>

      <form method="POST">

        <!-- Pages Tab Nav -->
        <div class="seo-tabs-nav" role="tablist">
          <?php foreach ($seoPages as $idx => $sp):
            $info     = $seoLabels[$sp];
            $isDone   = !empty($seoData[$sp]['title']) && !empty($seoData[$sp]['description']);
            $hasAny   = !empty($seoData[$sp]['title']) || !empty($seoData[$sp]['description']);
            $dotClass = $isDone ? 'done-dot' : ($hasAny ? 'has-dot' : '');
          ?>
          <button type="button"
                  class="seo-tab-btn <?php echo $dotClass; ?> <?php echo $idx === 0 ? 'active' : ''; ?>"
                  data-tab="<?php echo $sp; ?>" role="tab">
            <div class="tab-dot"></div>
            <i class="bi <?php echo $info['icon']; ?>"></i>
            <?php echo $info['label']; ?>
          </button>
          <?php endforeach; ?>

          <!-- Tracking Tab -->
          <button type="button" class="seo-tab-btn" data-tab="tracking" role="tab">
            <div class="tab-dot"></div>
            <i class="bi bi-bar-chart-line"></i>
            تتبع
          </button>
        </div>

        <!-- Page Panels -->
        <?php foreach ($seoPages as $idx => $sp):
          $info     = $seoLabels[$sp];
          $data     = $seoData[$sp];
          $titleLen = mb_strlen($data['title']);
          $descLen  = mb_strlen($data['description']);
        ?>
        <div class="seo-tab-panel <?php echo $idx === 0 ? 'active' : ''; ?>" id="panel-<?php echo $sp; ?>">

          <!-- Title -->
          <div class="seo-field-card">
            <div class="seo-field-label">
              <i class="bi bi-type-h1"></i>
              عنوان الصفحة
              <span class="ms-auto text-muted">يظهر في نتائج Google — 50-60 حرف مثالي</span>
            </div>
            <input type="text"
                   name="seo_<?php echo $sp; ?>_title"
                   class="form-control seo-title-field"
                   maxlength="70"
                   value="<?php echo htmlspecialchars($data['title']); ?>"
                   placeholder="مثال: فور ماب | خدمات هندسية في السعودية"
                   data-page="<?php echo $sp; ?>">
            <div class="char-bar-wrap">
              <div class="char-bar-track">
                <div class="char-bar-fill" id="title-bar-<?php echo $sp; ?>"
                     style="width:<?php echo min(100, round($titleLen/70*100)); ?>%"></div>
              </div>
              <span class="char-label">
                <span class="cc-title-<?php echo $sp; ?>"><?php echo $titleLen; ?></span>/70
              </span>
            </div>
          </div>

          <!-- Description -->
          <div class="seo-field-card">
            <div class="seo-field-label">
              <i class="bi bi-card-text"></i>
              وصف الصفحة
              <span class="ms-auto text-muted">يظهر تحت العنوان — 120-160 حرف مثالي</span>
            </div>
            <textarea name="seo_<?php echo $sp; ?>_description"
                      class="form-control seo-desc-field"
                      rows="3" maxlength="170"
                      placeholder="وصف مختصر يشجع الزائر على الضغط..."
                      data-page="<?php echo $sp; ?>"><?php echo htmlspecialchars($data['description']); ?></textarea>
            <div class="char-bar-wrap">
              <div class="char-bar-track">
                <div class="char-bar-fill" id="desc-bar-<?php echo $sp; ?>"
                     style="width:<?php echo min(100, round($descLen/170*100)); ?>%"></div>
              </div>
              <span class="char-label">
                <span class="cc-desc-<?php echo $sp; ?>"><?php echo $descLen; ?></span>/170
              </span>
            </div>
          </div>

          <!-- Keywords -->
          <div class="seo-field-card">
            <div class="seo-field-label">
              <i class="bi bi-tags"></i>
              كلمات مفتاحية
              <span class="ms-auto text-muted">مفصولة بفاصلة</span>
            </div>
            <textarea name="seo_<?php echo $sp; ?>_keywords"
                      class="form-control" rows="2"
                      placeholder="فور ماب, خدمات هندسية, رخص بناء"><?php echo htmlspecialchars($data['keywords']); ?></textarea>
          </div>

          <!-- Google Preview -->
          <div class="google-preview-wrap">
            <div class="seo-field-label">
              <i class="bi bi-google" style="color:#4285f4;"></i>
              معاينة في Google
            </div>
            <div class="google-preview-inner">
              <div class="gp-url"><?php echo $siteUrl . $info['url']; ?></div>
              <div class="gp-title seo-preview-title" data-page="<?php echo $sp; ?>">
                <?php echo htmlspecialchars($data['title'] ?: 'أضف العنوان...'); ?>
              </div>
              <div class="gp-desc seo-preview-desc" data-page="<?php echo $sp; ?>">
                <?php echo htmlspecialchars($data['description'] ?: 'أضف الوصف لتظهر هنا...'); ?>
              </div>
            </div>
          </div>

        </div>
        <?php endforeach; ?>

        <!-- Tracking Panel -->
        <div class="seo-tab-panel" id="panel-tracking">

          <div class="tracking-card">
            <div class="tracking-field-label">
              <i class="bi bi-facebook" style="color:#1877f2; font-size:1rem;"></i>
              Facebook Pixel ID
            </div>
            <div class="input-group">
              <input type="text" name="facebook_pixel" id="fb-pixel-input"
                     class="form-control"
                     value="<?php echo htmlspecialchars(get_setting($pdo, 'facebook_pixel', '')); ?>"
                     placeholder="XXXXXXXXXXXXXXXXXX">
              <button type="button" class="btn btn-outline-secondary px-3" onclick="checkFbPixel()">
                <i class="bi bi-check-lg"></i>
              </button>
            </div>
            <div id="fb-pixel-msg" class="mt-2" style="display:none; font-size:0.82rem;"></div>
          </div>

          <div class="tracking-card">
            <div class="tracking-field-label">
              <i class="bi bi-bar-chart-fill" style="color:var(--warning); font-size:1rem;"></i>
              Google Analytics ID
            </div>
            <div class="input-group">
              <input type="text" name="google_analytics" id="ga-input"
                     class="form-control"
                     value="<?php echo htmlspecialchars(get_setting($pdo, 'google_analytics', '')); ?>"
                     placeholder="G-XXXXXXXXXX">
              <button type="button" class="btn btn-outline-secondary px-3" onclick="checkGa()">
                <i class="bi bi-check-lg"></i>
              </button>
            </div>
            <div id="ga-msg" class="mt-2" style="display:none; font-size:0.82rem;"></div>
          </div>

          <div class="tracking-card">
            <div class="tracking-field-label">
              <i class="bi bi-search" style="color:var(--warning); font-size:1rem;"></i>
              Google Search Console
            </div>
            <input type="text" name="google_search_console" class="form-control"
                   value="<?php echo htmlspecialchars(get_setting($pdo, 'google_search_console', '')); ?>"
                   placeholder="كود التحقق...">
          </div>

        </div>

        <!-- Save Bar -->
        <div class="d-flex justify-content-between align-items-center mt-4 pt-2">
          <a href="settings.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i> الإعدادات العامة
          </a>
          <button type="submit" class="btn btn-primary px-5">
            <i class="bi bi-check-circle me-2"></i> حفظ
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
// ── Tab switching ──
document.querySelectorAll('.seo-tab-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.seo-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.seo-tab-panel').forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        const panel = document.getElementById('panel-' + this.dataset.tab);
        if (panel) panel.classList.add('active');
    });
});

// ── Char bar color ──
function barColor(val, min, max) {
    if (val === 0)  return '#e8eaed';
    if (val < min)  return '#f59e0b';
    if (val <= max) return '#10b981';
    return '#ef4444';
}

function updateTitleBar(page, len) {
    const bar = document.getElementById('title-bar-' + page);
    const lbl = document.querySelector('.cc-title-' + page);
    if (!bar || !lbl) return;
    bar.style.width      = Math.min(100, Math.round(len / 70 * 100)) + '%';
    bar.style.background = barColor(len, 50, 60);
    lbl.textContent      = len;
}

function updateDescBar(page, len) {
    const bar = document.getElementById('desc-bar-' + page);
    const lbl = document.querySelector('.cc-desc-' + page);
    if (!bar || !lbl) return;
    bar.style.width      = Math.min(100, Math.round(len / 170 * 100)) + '%';
    bar.style.background = barColor(len, 120, 160);
    lbl.textContent      = len;
}

// ── Init on load ──
document.querySelectorAll('.seo-title-field').forEach(function(inp) {
    const page = inp.dataset.page;
    updateTitleBar(page, inp.value.length);
    inp.addEventListener('input', function() {
        updateTitleBar(page, this.value.length);
        const el = document.querySelector('.seo-preview-title[data-page="' + page + '"]');
        if (el) el.textContent = this.value.trim() || 'أضف العنوان...';
    });
});

document.querySelectorAll('.seo-desc-field').forEach(function(inp) {
    const page = inp.dataset.page;
    updateDescBar(page, inp.value.length);
    inp.addEventListener('input', function() {
        updateDescBar(page, this.value.length);
        const el = document.querySelector('.seo-preview-desc[data-page="' + page + '"]');
        if (el) el.textContent = this.value.trim() || 'أضف الوصف لتظهر هنا...';
    });
});

// ── Tracking validators ──
function checkFbPixel() {
    const val = document.getElementById('fb-pixel-input').value.trim();
    const msg = document.getElementById('fb-pixel-msg');
    msg.style.display = 'block';
    if (!val) { msg.innerHTML = '<span class="text-muted">الحقل فارغ</span>'; return; }
    msg.innerHTML = /^\d{10,20}$/.test(val)
        ? '<i class="bi bi-check-circle-fill text-success me-1"></i><span class="text-success">يبدو صحيحاً ✓</span>'
        : '<i class="bi bi-exclamation-triangle-fill text-warning me-1"></i><span class="text-warning">Pixel ID: أرقام فقط، 10–20 رقم</span>';
}

function checkGa() {
    const val = document.getElementById('ga-input').value.trim();
    const msg = document.getElementById('ga-msg');
    msg.style.display = 'block';
    if (!val) { msg.innerHTML = '<span class="text-muted">الحقل فارغ</span>'; return; }
    msg.innerHTML = (/^G-[A-Z0-9]{4,}$/.test(val) || /^UA-\d+-\d+$/.test(val))
        ? '<i class="bi bi-check-circle-fill text-success me-1"></i><span class="text-success">يبدو صحيحاً ✓</span>'
        : '<i class="bi bi-exclamation-triangle-fill text-warning me-1"></i><span class="text-warning">الصيغة المعتادة: G-XXXXXXXXXX</span>';
}
</script>

<?php include 'partials/footer.php'; ?>