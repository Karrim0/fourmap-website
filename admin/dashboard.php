<?php
/**
 * Admin Dashboard Page
 */
$page_title = 'لوحة التحكم';
include 'partials/header.php';
require_once '../includes/db.php';

// ——— Stats ———
$totalServices    = (int) $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$activeServices   = (int) $pdo->query("SELECT COUNT(*) FROM services WHERE status='active'")->fetchColumn();
$featuredServices = (int) $pdo->query("SELECT COUNT(*) FROM services WHERE is_featured=1")->fetchColumn();
$totalPartners    = (int) $pdo->query("SELECT COUNT(*) FROM partners WHERE status='active'")->fetchColumn();
$totalArticles    = (int) $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$activeArticles   = (int) $pdo->query("SELECT COUNT(*) FROM articles WHERE status='active'")->fetchColumn();

// ——— Recent services ———
$recentServices = $pdo->query("
    SELECT id, title, status, is_featured FROM services ORDER BY id DESC LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// ——— Recent articles ———
$recentArticles = $pdo->query("
    SELECT id, title, status, created_at FROM articles ORDER BY id DESC LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-wrapper">
    <?php include 'partials/sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <button class="btn-toggle-sidebar d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="page-title">لوحة التحكم</h1>
            <div class="top-bar-actions">
                <a href="../index.php" target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-box-arrow-up-left me-1"></i> معاينة الموقع
                </a>
            </div>
        </div>

        <div class="content-wrapper">

            <!-- ═══ Stat Cards ═══ -->
            <div class="row g-3 mb-4">

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card stat-primary">
                        <div class="stat-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                        <div class="stat-content">
                            <div class="stat-value"><?php echo $totalServices; ?></div>
                            <div class="stat-label">إجمالي الخدمات</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card stat-success">
                        <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                        <div class="stat-content">
                            <div class="stat-value"><?php echo $activeServices; ?></div>
                            <div class="stat-label">خدمات نشطة</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card stat-warning">
                        <div class="stat-icon"><i class="bi bi-newspaper"></i></div>
                        <div class="stat-content">
                            <div class="stat-value"><?php echo $totalArticles; ?></div>
                            <div class="stat-label">
                                إجمالي المقالات
                                <?php if ($activeArticles < $totalArticles): ?>
                                    <span class="d-block" style="font-size:0.75rem; color:var(--muted);">
                                        <?php echo $activeArticles; ?> منشور
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <!-- ═══ Quick Actions ═══ -->
            <div class="card mb-4">
                <div class="card-header"><h5 class="card-title mb-0">إجراءات سريعة</h5></div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="service-create.php" class="quick-action-btn">
                            <i class="bi bi-plus-circle"></i>
                            <span>إضافة خدمة</span>
                        </a>
                        <a href="article-create.php" class="quick-action-btn">
                            <i class="bi bi-file-earmark-plus"></i>
                            <span>إضافة مقال</span>
                        </a>

                        <a href="settings.php" class="quick-action-btn">
                            <i class="bi bi-gear"></i>
                            <span>الإعدادات</span>
                        </a>
                        <a href="seo.php" class="quick-action-btn">
                            <i class="bi bi-search"></i>
                            <span>إعدادات SEO</span>
                        </a>
                        <a href="../index.php" target="_blank" class="quick-action-btn">
                            <i class="bi bi-eye"></i>
                            <span>معاينة الموقع</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ═══ Recent Tables ═══ -->
            <div class="row g-3">

                <!-- آخر الخدمات -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">آخر الخدمات</h5>
                            <a href="services.php" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                        </div>
                        <div class="card-body p-0">
                            <?php if (!empty($recentServices)): ?>
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>الخدمة</th>
                                        <th style="width:90px;">الحالة</th>
                                        <th style="width:60px;">مميز</th>
                                        <th style="width:60px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentServices as $s): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($s['title']); ?></strong></td>
                                        <td>
                                            <?php if ($s['status'] === 'active'): ?>
                                                <span class="badge bg-success">نشط</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">غير نشط</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (!empty($s['is_featured'])): ?>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="service-edit.php?id=<?php echo (int)$s['id']; ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <div class="text-center text-muted p-4">
                                    <i class="bi bi-grid-3x3-gap fs-3 d-block mb-2 opacity-25"></i>
                                    لا توجد خدمات بعد —
                                    <a href="service-create.php">أضف الأولى</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- آخر المقالات -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">آخر المقالات</h5>
                            <a href="articles.php" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                        </div>
                        <div class="card-body p-0">
                            <?php if (!empty($recentArticles)): ?>
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>المقال</th>
                                        <th style="width:90px;">الحالة</th>
                                        <th style="width:100px;">التاريخ</th>
                                        <th style="width:60px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentArticles as $a): ?>
                                    <tr>
                                        <td>
                                            <strong style="display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;">
                                                <?php echo htmlspecialchars($a['title']); ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <?php if ($a['status'] === 'active'): ?>
                                                <span class="badge bg-success">منشور</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">مسودة</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-muted small">
                                            <?php echo date('Y/m/d', strtotime($a['created_at'])); ?>
                                        </td>
                                        <td>
                                            <a href="article-edit.php?id=<?php echo (int)$a['id']; ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <div class="text-center text-muted p-4">
                                    <i class="bi bi-newspaper fs-3 d-block mb-2 opacity-25"></i>
                                    لا توجد مقالات بعد —
                                    <a href="article-create.php">أضف الأول</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div><!-- /row -->

        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>