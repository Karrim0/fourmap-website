<?php
/**
 * Admin Sidebar
 */
$current_page = basename($_SERVER['PHP_SELF']);

require_once '../includes/db.php';
require_once '../includes/settings.php';

// SEO pending count
$seoPages   = ['home','about','services','contact','consultation'];
$seoPending = 0;
foreach ($seoPages as $sp) {
    if (empty(get_setting($pdo, "seo_{$sp}_title", ''))) $seoPending++;
}
?>

<div class="sidebar" id="sidebar">

  <div class="sidebar-header">
    <h3 class="sidebar-brand">
      <i class="bi bi-hexagon-fill text-warning"></i>
      فور ماب
    </h3>
    <button class="btn-close-sidebar d-lg-none" onclick="toggleSidebar()">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

  <div class="sidebar-menu">

    <a href="dashboard.php"
       class="sidebar-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>">
      <i class="bi bi-speedometer2"></i>
      <span>لوحة التحكم</span>
    </a>

    <!-- المحتوى -->
    <div class="sidebar-label">المحتوى</div>

    <a href="services.php"
       class="sidebar-link <?php echo in_array($current_page, ['services.php','service-create.php','service-edit.php']) ? 'active' : ''; ?>">
      <i class="bi bi-grid-3x3-gap"></i>
      <span>الخدمات</span>
    </a>

    <a href="articles.php"
       class="sidebar-link <?php echo in_array($current_page, ['articles.php','article-create.php','article-edit.php']) ? 'active' : ''; ?>">
      <i class="bi bi-newspaper"></i>
      <span>المقالات</span>
    </a>

    <!-- <a href="partners.php"
       class="sidebar-link <?php echo in_array($current_page, ['partners.php','partner-create.php','partner-edit.php']) ? 'active' : ''; ?>">
      <i class="bi bi-patch-check"></i>
      <span>الاعتمادات</span>
    </a> -->

    <!-- الإعدادات -->
    <div class="sidebar-label">الإعدادات</div>

    <a href="settings.php"
       class="sidebar-link <?php echo $current_page === 'settings.php' ? 'active' : ''; ?>">
      <i class="bi bi-sliders"></i>
      <span>إعدادات الموقع</span>
    </a>

    <a href="seo.php"
       class="sidebar-link <?php echo $current_page === 'seo.php' ? 'active' : ''; ?>">
      <i class="bi bi-search"></i>
      <span>SEO</span>
      <?php if ($seoPending > 0): ?>
        <span class="seo-badge"><?php echo $seoPending; ?></span>
      <?php endif; ?>
    </a>

    <div class="sidebar-divider"></div>

    <a href="../index.php" target="_blank" class="sidebar-link">
      <i class="bi bi-box-arrow-up-left"></i>
      <span>معاينة الموقع</span>
    </a>

    <a href="logout.php" class="sidebar-link" style="color:rgba(239,68,68,0.7);">
      <i class="bi bi-box-arrow-left"></i>
      <span>تسجيل الخروج</span>
    </a>

  </div>

  <div class="sidebar-footer">
    <div class="admin-profile">
      <div class="admin-avatar"><i class="bi bi-person-circle"></i></div>
      <div class="admin-info">
        <div class="admin-name"><?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'المسؤول'); ?></div>
        <div class="admin-role">مدير النظام</div>
      </div>
    </div>
  </div>

</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>