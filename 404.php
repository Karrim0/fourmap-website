<?php
/**
 * FourMap - 404 Not Found
 */
http_response_code(404);

$seoPage = '404'; // مش موجود في DB — هيستخدم الـ defaults

require_once 'includes/header.php';
?>

<section style="
  min-height: 70vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: calc(var(--nav-h) + 60px) 24px 80px;
  background: var(--w-cream);
">
  <div style="
    width: 80px; height: 80px;
    background: var(--y);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    font-size: 2rem;
  ">
    🔍
  </div>

  <h1 style="
    font-size: clamp(1.8rem, 4vw, 3rem);
    font-weight: 700;
    color: var(--t-dark);
    margin-bottom: 12px;
  ">
    الصفحة غير موجودة
  </h1>

  <p style="
    color: var(--t-muted);
    font-size: 1.05rem;
    margin-bottom: 36px;
    max-width: 420px;
  ">
    الرابط الذي تبحث عنه غير موجود أو تم نقله. جرب العودة للصفحة الرئيسية.
  </p>

  <a href="index.php" style="
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
    background: var(--y);
    color: var(--t-dark);
    font-weight: 700;
    font-size: 0.98rem;
    border-radius: var(--r-pill);
    text-decoration: none;
    transition: transform 0.25s, box-shadow 0.25s;
  "
  onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(245,197,24,0.35)'"
  onmouseout="this.style.transform=''; this.style.boxShadow=''">
    العودة للرئيسية
    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
      <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
    </svg>
  </a>
</section>

<?php require_once 'includes/footer.php'; ?>