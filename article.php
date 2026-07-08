<?php
/**
 * FourMap - Single Article Page
 */
require_once 'includes/db.php';
require_once 'includes/settings.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { header('Location: articles.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ? AND status = 'active'");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$article) { header('Location: articles.php'); exit; }

// Related articles (أحدث 3 مقالات غير الحالي)
$relStmt = $pdo->prepare("
    SELECT id, title, excerpt, image, created_at
    FROM articles
    WHERE status = 'active' AND id != ?
    ORDER BY id DESC
    LIMIT 3
");
$relStmt->execute([$id]);
$related = $relStmt->fetchAll(PDO::FETCH_ASSOC);

// ===== SEO ديناميكي =====
// لو فيه meta مخصص → يستخدمه، لو لأ → يرجع للعنوان والـ excerpt تلقائي
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

$seoPage    = 'article';
$articleSeo = [
    'title'       => !empty($article['meta_title'])
                        ? $article['meta_title']
                        : $article['title'] . ' | فور ماب',
    'description' => !empty($article['meta_description'])
                        ? $article['meta_description']
                        : (!empty($article['excerpt'])
                            ? mb_substr($article['excerpt'], 0, 160)
                            : mb_substr(strip_tags($article['content']), 0, 160)),
    'image'       => !empty($article['image'])
                        ? $protocol . '://' . $_SERVER['HTTP_HOST'] . '/' . ltrim($article['image'], '/')
                        : '',
];

require_once 'includes/header.php';
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="article-title">
  <div class="container">
    <h1 id="article-title" style="font-size: clamp(1.4rem, 3vw, 2.2rem);">
      <?php echo htmlspecialchars($article['title']); ?>
    </h1>
    <div class="page-breadcrumb">
      <a href="index.php">الرئيسية</a> /
      <a href="articles.php">المقالات</a> /
      <?php echo htmlspecialchars(mb_substr($article['title'], 0, 30)); ?>...
    </div>
  </div>
</section>

<!-- ARTICLE CONTENT -->
<section style="background: var(--w); padding: 72px 0 80px;">
  <div class="container">
    <div class="article-layout-grid" style="display:grid; grid-template-columns: 1fr 320px; gap: 48px; align-items: start;">

      <!-- Main Article -->
      <article>

        <!-- Meta -->
        <div style="display:flex; align-items:center; gap:16px; margin-bottom:28px; padding-bottom:20px; border-bottom:1.5px solid var(--b);">
          <div style="display:flex; align-items:center; gap:6px; font-size:0.85rem; color:var(--t-muted);">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="var(--y-dk)">
              <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <?php echo date('d / m / Y', strtotime($article['created_at'])); ?>
          </div>
          <a href="articles.php"
             style="display:inline-flex; align-items:center; gap:5px; font-size:0.82rem; color:var(--t-muted); background:var(--w-cream); padding:4px 12px; border-radius:var(--r-pill); border:1px solid var(--b); transition:var(--ease);"
             onmouseover="this.style.borderColor='var(--y)'; this.style.color='var(--y-dk)'"
             onmouseout="this.style.borderColor='var(--b)'; this.style.color='var(--t-muted)'">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
              <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
            </svg>
            العودة للمقالات
          </a>
        </div>

        <!-- Featured Image -->
        <?php if (!empty($article['image'])): ?>
          <div style="border-radius:var(--r-xl); overflow:hidden; margin-bottom:36px; box-shadow:var(--sh-md);">
            <img src="<?php echo htmlspecialchars($article['image']); ?>"
                 alt="<?php echo htmlspecialchars($article['title']); ?>"
                 style="width:100%; max-height:420px; object-fit:cover; display:block;"
                 onerror="this.parentElement.style.display='none'">
          </div>
        <?php endif; ?>

        <!-- Content -->
        <div style="font-size:1.05rem; line-height:2; color:var(--t-body);" class="article-content">
          <?php echo nl2br(htmlspecialchars($article['content'])); ?>
        </div>

      </article>

      <!-- Sidebar -->
      <aside>
        <?php if (!empty($related)): ?>
        <div style="
          background: var(--w-cream);
          border-radius: var(--r-lg);
          padding: 24px;
          border: 1.5px solid var(--b);
          position: sticky;
          top: calc(var(--nav-h) + 24px);
        ">
          <h3 style="font-size:1rem; font-weight:700; color:var(--t-dark); margin-bottom:20px; padding-bottom:12px; border-bottom:2px solid var(--y);">
            مقالات ذات صلة
          </h3>
          <div style="display:flex; flex-direction:column; gap:18px;">
            <?php foreach ($related as $r): ?>
              <a href="article.php?id=<?php echo (int)$r['id']; ?>"
                 style="display:flex; gap:12px; text-decoration:none; color:inherit;"
                 onmouseover="this.querySelector('h4').style.color='var(--y-dk)'"
                 onmouseout="this.querySelector('h4').style.color='var(--t-dark)'">
                <?php if (!empty($r['image'])): ?>
                  <div style="width:72px; height:60px; border-radius:var(--r-sm); overflow:hidden; flex-shrink:0;">
                    <img src="<?php echo htmlspecialchars($r['image']); ?>"
                         alt=""
                         style="width:100%; height:100%; object-fit:cover;"
                         onerror="this.parentElement.style.display='none'">
                  </div>
                <?php endif; ?>
                <div style="flex:1;">
                  <h4 style="font-size:0.88rem; font-weight:700; color:var(--t-dark); line-height:1.4; margin-bottom:4px; transition:color var(--ease); display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    <?php echo htmlspecialchars($r['title']); ?>
                  </h4>
                  <span style="font-size:0.75rem; color:var(--t-muted);">
                    <?php echo date('d/m/Y', strtotime($r['created_at'])); ?>
                  </span>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </aside>

    </div>
  </div>
</section>

<style>
@media (max-width: 900px) {
  .article-layout-grid { grid-template-columns: 1fr !important; }
}
.article-content p  { margin-bottom: 1.2em; }
.article-content h2 { font-size:1.3rem; font-weight:700; margin:1.5em 0 0.7em; color:var(--t-dark); }
.article-content h3 { font-size:1.1rem; font-weight:700; margin:1.2em 0 0.5em; color:var(--t-dark); }
.article-content ul, .article-content ol { padding-right:1.5em; margin-bottom:1em; }
.article-content li { margin-bottom:0.4em; }
.article-content strong { color: var(--t-dark); }
</style>

<?php require_once 'includes/footer.php'; ?>