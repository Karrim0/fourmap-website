<?php
/**
 * FourMap - Articles Page
 */
$seoPage = 'home'; // fallback

require_once 'includes/db.php';
require_once 'includes/settings.php';
require_once 'includes/header.php';

$articles = $pdo->query("
    SELECT id, title, excerpt, image, created_at
    FROM articles
    WHERE status = 'active'
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="articles-title">
  <div class="container">
    <h1 id="articles-title">المقالات <span>الهندسية</span></h1>
    <div class="page-breadcrumb">
      <a href="index.php">الرئيسية</a> / المقالات
    </div>
  </div>
</section>

<!-- ARTICLES GRID -->
<section style="background: var(--w-warm); padding: 80px 0;">
  <div class="container">

    <?php if (empty($articles)): ?>
      <div class="text-center py-5" style="color: var(--t-muted);">
        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
             style="margin: 0 auto 16px; display:block; opacity:0.25;">
          <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
        </svg>
        <p style="font-size:1.1rem;">لا توجد مقالات منشورة حالياً</p>
      </div>

    <?php else: ?>
      <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px;">

        <?php foreach ($articles as $a): ?>
          <article style="
            background: var(--w);
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: var(--sh-sm);
            border: 1.5px solid var(--b);
            transition: transform var(--ease-bounce), box-shadow var(--ease);
            display: flex;
            flex-direction: column;
          " onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='var(--sh-md)'"
             onmouseout="this.style.transform='';this.style.boxShadow='var(--sh-sm)'">

            <!-- Article Image -->
            <?php if (!empty($a['image'])): ?>
              <a href="article.php?id=<?php echo (int)$a['id']; ?>"
                 style="display:block; height:200px; overflow:hidden;">
                <img src="<?php echo htmlspecialchars($a['image']); ?>"
                     alt="<?php echo htmlspecialchars($a['title']); ?>"
                     loading="lazy"
                     style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s;"
                     onmouseover="this.style.transform='scale(1.06)'"
                     onmouseout="this.style.transform=''"
                     onerror="this.parentElement.style.display='none'">
              </a>
            <?php else: ?>
              <div style="height:180px; background:var(--y-ghost); display:flex; align-items:center; justify-content:center;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--y-dk)" stroke-width="1.2" opacity="0.4">
                  <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                  <polyline points="14 2 14 8 20 8"/>
                </svg>
              </div>
            <?php endif; ?>

            <!-- Article Body -->
            <div style="padding: 22px; flex: 1; display:flex; flex-direction:column;">

              <!-- Date -->
              <div style="font-size:0.78rem; color:var(--t-muted); margin-bottom:10px; display:flex; align-items:center; gap:5px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="var(--y-dk)">
                  <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
                <?php echo date('d / m / Y', strtotime($a['created_at'])); ?>
              </div>

              <!-- Title -->
              <h2 style="
                font-size: 1.05rem;
                font-weight: 700;
                color: var(--t-dark);
                margin-bottom: 10px;
                line-height: 1.5;
              ">
                <a href="article.php?id=<?php echo (int)$a['id']; ?>"
                   style="color:inherit; transition:color var(--ease);"
                   onmouseover="this.style.color='var(--y-dk)'"
                   onmouseout="this.style.color='inherit'">
                  <?php echo htmlspecialchars($a['title']); ?>
                </a>
              </h2>

              <!-- Excerpt -->
              <?php if (!empty($a['excerpt'])): ?>
                <p style="
                  font-size: 0.88rem;
                  color: var(--t-muted);
                  line-height: 1.75;
                  flex: 1;
                  display: -webkit-box;
                  -webkit-line-clamp: 3;
                  -webkit-box-orient: vertical;
                  overflow: hidden;
                  margin-bottom: 18px;
                ">
                  <?php echo htmlspecialchars($a['excerpt']); ?>
                </p>
              <?php endif; ?>

              <!-- Read more -->
              <a href="article.php?id=<?php echo (int)$a['id']; ?>"
                 style="
                   display: inline-flex;
                   align-items: center;
                   gap: 6px;
                   font-size: 0.86rem;
                   font-weight: 700;
                   color: var(--y-dk);
                   margin-top: auto;
                   transition: gap var(--ease);
                 "
                 onmouseover="this.style.gap='10px'"
                 onmouseout="this.style.gap='6px'">
                اقرأ المزيد
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/>
                </svg>
              </a>

            </div>
          </article>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>