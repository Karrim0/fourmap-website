<?php
/**
 * Admin — Create Article
 */
$page_title = 'إضافة مقال جديد';
include 'partials/header.php';
require_once '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title            = trim($_POST['title']            ?? '');
    $excerpt          = trim($_POST['excerpt']          ?? '');
    $content          = trim($_POST['content']          ?? '');
    $status           = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
    $meta_title       = trim($_POST['meta_title']       ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');

    // لو نفس القيمة التلقائية أو فاضي → نحفظ NULL عشان الـ fallback يشتغل
    if ($meta_title === '' || $meta_title === $title . ' | فور ماب') {
        $meta_title = null;
    }
    if ($meta_description === '' || $meta_description === mb_substr($excerpt, 0, 160)) {
        $meta_description = null;
    }

    if ($title === '' || $content === '') {
        $error = 'العنوان والمحتوى مطلوبان';
    } else {
        $imagePath = null;

        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../assets/uploads/articles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);
            $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];
            if (!in_array($ext, $allowed)) {
                $error = 'صيغة الصورة غير مدعومة';
            } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $error = 'حجم الصورة أكبر من 5MB';
            } else {
                $fileName = 'article_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $imagePath = 'assets/uploads/articles/' . $fileName;
                } else {
                    $error = 'فشل رفع الصورة';
                }
            }
        }

        if ($error === '') {
            $pdo->prepare("
                INSERT INTO articles (title, excerpt, content, image, status, meta_title, meta_description)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ")->execute([$title, $excerpt, $content, $imagePath, $status, $meta_title, $meta_description]);
            header("Location: articles.php?created=1");
            exit;
        }
    }
}

$postTitle   = $_POST['title']            ?? '';
$postExcerpt = $_POST['excerpt']          ?? '';
$postMetaT   = $_POST['meta_title']       ?? '';
$postMetaD   = $_POST['meta_description'] ?? '';
?>

<style>
.seo-preview-card { font-size:0.82rem; }
.seo-char-wrap  { display:flex; align-items:center; gap:8px; margin-top:6px; }
.seo-char-track { flex:1; height:4px; border-radius:99px; background:rgba(0,0,0,0.08); overflow:hidden; }
.seo-char-fill  { height:100%; border-radius:99px; transition:width 0.2s,background 0.2s; }
.seo-char-label { font-size:0.72rem; color:#888; min-width:40px; text-align:left; direction:ltr; }
.google-preview-box {
    background:#fff; border:1px solid #e0e0e0; border-radius:10px;
    padding:12px 14px; margin-top:10px; font-family:Arial,sans-serif;
}
.gp-url   { font-size:0.72rem; color:#3c4043; margin-bottom:3px; }
.gp-title { font-size:0.95rem; color:#1a0dab; font-weight:500; line-height:1.3;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.gp-desc  { font-size:0.78rem; color:#4d5156; line-height:1.5; margin-top:3px;
            display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.seo-badge { display:inline-flex; align-items:center; gap:4px; font-size:0.72rem;
             font-weight:600; padding:2px 8px; border-radius:99px; }
.seo-badge-auto   { background:#fff3cd; color:#856404; border:1px solid #ffc107; }
.seo-badge-custom { background:#d1ecf1; color:#0c5460; border:1px solid #bee5eb; }
.seo-field-edited { border-color:#0d6efd !important; background:#f0f6ff !important; }
.seo-reset-btn {
    font-size:0.7rem; color:#6c757d; border:none; background:none;
    cursor:pointer; padding:0; text-decoration:underline; line-height:1;
}
.seo-reset-btn:hover { color:#dc3545; }
</style>

<div class="admin-wrapper">
  <?php include 'partials/sidebar.php'; ?>

  <div class="main-content">
    <div class="top-bar">
      <button class="btn-toggle-sidebar d-lg-none" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <h1 class="page-title">إضافة مقال جديد</h1>
      <div class="top-bar-actions">
        <a href="articles.php" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-right me-2"></i> العودة
        </a>
      </div>
    </div>

    <div class="content-wrapper">

      <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <?php echo htmlspecialchars($error); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="row g-4">

          <!-- ═══ Main Content ═══ -->
          <div class="col-lg-8">
            <div class="card mb-4">
              <div class="card-header"><h5 class="card-title mb-0">محتوى المقال</h5></div>
              <div class="card-body">

                <div class="mb-3">
                  <label class="form-label">عنوان المقال <span class="text-danger">*</span></label>
                  <input type="text" name="title" id="article-title" class="form-control"
                         value="<?php echo htmlspecialchars($postTitle); ?>"
                         placeholder="اكتب عنواناً واضحاً وجذاباً" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">
                    المقتطف
                    <span class="text-muted fw-normal small">— يظهر في قائمة المقالات والصفحة الرئيسية</span>
                  </label>
                  <textarea name="excerpt" id="article-excerpt" class="form-control" rows="3"
                            placeholder="ملخص قصير للمقال (120-160 حرف)"><?php echo htmlspecialchars($postExcerpt); ?></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label">محتوى المقال <span class="text-danger">*</span></label>
                  <textarea name="content" class="form-control" rows="16"
                            placeholder="اكتب محتوى المقال هنا..."><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                  <div class="form-text">يمكن استخدام HTML بسيط مثل &lt;b&gt; &lt;br&gt; &lt;ul&gt; &lt;li&gt;</div>
                </div>

              </div>
            </div>
          </div>

          <!-- ═══ Sidebar ═══ -->
          <div class="col-lg-4">

            <!-- Publish -->
            <div class="card mb-4">
              <div class="card-header"><h5 class="card-title mb-0">النشر</h5></div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">الحالة</label>
                  <select name="status" class="form-select">
                    <option value="active">منشور</option>
                    <option value="inactive">مسودة</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-check-circle me-2"></i> حفظ المقال
                </button>
              </div>
            </div>

            <!-- Image -->
            <div class="card mb-4">
              <div class="card-header"><h5 class="card-title mb-0">صورة المقال</h5></div>
              <div class="card-body">
                <input type="file" name="image" class="form-control mb-2"
                       accept="image/*" onchange="previewImg(event,'imgPreview')">
                <div class="form-text mb-3">JPG / PNG / WEBP — الحد الأقصى 5MB</div>
                <img id="imgPreview" src="" class="img-fluid rounded"
                     style="display:none; max-height:200px; object-fit:cover; width:100%;">
              </div>
            </div>

            <!-- ═══ SEO Card ═══ -->
            <div class="card seo-preview-card">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">
                  <i class="bi bi-google me-1" style="color:#4285f4;"></i>
                  SEO المقال
                </h5>
                <span class="seo-badge seo-badge-auto" id="seo-badge">
                  <i class="bi bi-magic"></i> تلقائي
                </span>
              </div>
              <div class="card-body">

                <p class="text-muted small mb-3">
                  يُولَّد تلقائياً من العنوان والمقتطف — يمكنك تخصيصه يدوياً.
                </p>

                <!-- Meta Title -->
                <div class="mb-3">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0 small fw-semibold">عنوان SEO</label>
                    <button type="button" class="seo-reset-btn" id="reset-title"
                            style="display:none;" onclick="resetTitle()">↺ إعادة تلقائي</button>
                  </div>
                  <input type="text" name="meta_title" id="meta-title"
                         class="form-control form-control-sm" maxlength="70"
                         value="<?php echo htmlspecialchars($postMetaT); ?>"
                         placeholder="سيُملأ تلقائياً من العنوان...">
                  <div class="seo-char-wrap">
                    <div class="seo-char-track">
                      <div class="seo-char-fill" id="seo-title-bar" style="width:0%;background:#ddd;"></div>
                    </div>
                    <span class="seo-char-label"><span id="seo-title-count">0</span>/70</span>
                  </div>
                </div>

                <!-- Meta Description -->
                <div class="mb-3">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0 small fw-semibold">وصف SEO</label>
                    <button type="button" class="seo-reset-btn" id="reset-desc"
                            style="display:none;" onclick="resetDesc()">↺ إعادة تلقائي</button>
                  </div>
                  <textarea name="meta_description" id="meta-desc"
                            class="form-control form-control-sm" rows="3" maxlength="160"
                            placeholder="سيُملأ تلقائياً من المقتطف..."><?php echo htmlspecialchars($postMetaD); ?></textarea>
                  <div class="seo-char-wrap">
                    <div class="seo-char-track">
                      <div class="seo-char-fill" id="seo-desc-bar" style="width:0%;background:#ddd;"></div>
                    </div>
                    <span class="seo-char-label"><span id="seo-desc-count">0</span>/160</span>
                  </div>
                </div>

                <!-- Google Preview -->
                <div>
                  <div class="small fw-semibold text-muted mb-1">
                    <i class="bi bi-eye me-1"></i> معاينة في Google
                  </div>
                  <div class="google-preview-box">
                    <div class="gp-url">aaadosry.info/fourmap4/article.php?id=...</div>
                    <div class="gp-title" id="gp-title-live">عنوان المقال | فور ماب</div>
                    <div class="gp-desc"  id="gp-desc-live">أضف مقتطفاً للمقال ليظهر هنا...</div>
                  </div>
                </div>

              </div>
            </div>
            <!-- /SEO Card -->

          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
function previewImg(e, id) {
  const file = e.target.files[0];
  if (!file) return;
  const img = document.getElementById(id);
  img.src = URL.createObjectURL(file);
  img.style.display = 'block';
}

const SUFFIX = ' | فور ماب';
let autoTitle   = '';
let autoDesc    = '';
let titleEdited = false;
let descEdited  = false;

function barColor(v, mn, mx) {
  if (v === 0) return '#ddd';
  if (v < mn)  return '#f59e0b';
  if (v <= mx) return '#22c55e';
  return '#ef4444';
}
function updateBar(barId, countId, val, max, min) {
  document.getElementById(barId).style.width      = Math.min(100, Math.round(val/max*100)) + '%';
  document.getElementById(barId).style.background = barColor(val, min, max);
  document.getElementById(countId).textContent    = val;
}
function updatePreview() {
  const mt = document.getElementById('meta-title').value.trim();
  const md = document.getElementById('meta-desc').value.trim();
  document.getElementById('gp-title-live').textContent = mt || (autoTitle ? autoTitle + SUFFIX : 'عنوان المقال | فور ماب');
  document.getElementById('gp-desc-live').textContent  = md || autoDesc || 'أضف مقتطفاً للمقال ليظهر هنا...';
  updateBar('seo-title-bar', 'seo-title-count', mt.length, 70, 50);
  updateBar('seo-desc-bar',  'seo-desc-count',  md.length, 160, 120);
}
function updateBadge() {
  const badge = document.getElementById('seo-badge');
  if (titleEdited || descEdited) {
    badge.innerHTML   = '<i class="bi bi-pencil"></i> مخصص';
    badge.className   = 'seo-badge seo-badge-custom';
  } else {
    badge.innerHTML   = '<i class="bi bi-magic"></i> تلقائي';
    badge.className   = 'seo-badge seo-badge-auto';
  }
}

// عنوان المقال → يحدث meta title تلقائي لو مش معدّل
document.getElementById('article-title').addEventListener('input', function () {
  autoTitle = this.value.trim();
  if (!titleEdited) {
    const full = autoTitle ? autoTitle + SUFFIX : '';
    document.getElementById('meta-title').value = full;
    updateBar('seo-title-bar', 'seo-title-count', full.length, 70, 50);
  }
  updatePreview();
});

// excerpt → يحدث meta desc تلقائي لو مش معدّل
document.getElementById('article-excerpt').addEventListener('input', function () {
  autoDesc = this.value.trim().substring(0, 160);
  if (!descEdited) {
    document.getElementById('meta-desc').value = autoDesc;
    updateBar('seo-desc-bar', 'seo-desc-count', autoDesc.length, 160, 120);
  }
  updatePreview();
});

// تعديل يدوي للـ meta title
document.getElementById('meta-title').addEventListener('input', function () {
  titleEdited = this.value.trim() !== (autoTitle + SUFFIX) && this.value.trim() !== '';
  document.getElementById('reset-title').style.display = titleEdited ? 'inline' : 'none';
  this.classList.toggle('seo-field-edited', titleEdited);
  updatePreview(); updateBadge();
});

// تعديل يدوي للـ meta desc
document.getElementById('meta-desc').addEventListener('input', function () {
  descEdited = this.value.trim() !== autoDesc && this.value.trim() !== '';
  document.getElementById('reset-desc').style.display = descEdited ? 'inline' : 'none';
  this.classList.toggle('seo-field-edited', descEdited);
  updatePreview(); updateBadge();
});

function resetTitle() {
  titleEdited = false;
  document.getElementById('meta-title').value = autoTitle ? autoTitle + SUFFIX : '';
  document.getElementById('meta-title').classList.remove('seo-field-edited');
  document.getElementById('reset-title').style.display = 'none';
  updatePreview(); updateBadge();
}
function resetDesc() {
  descEdited = false;
  document.getElementById('meta-desc').value = autoDesc;
  document.getElementById('meta-desc').classList.remove('seo-field-edited');
  document.getElementById('reset-desc').style.display = 'none';
  updatePreview(); updateBadge();
}

document.addEventListener('DOMContentLoaded', updatePreview);
</script>

<?php include 'partials/footer.php'; ?>