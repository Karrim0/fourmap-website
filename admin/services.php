<?php
/**
 * Services List Page
 */
$page_title = 'إدارة الخدمات';
include 'partials/header.php';
require_once '../includes/db.php';

// Handle delete BEFORE fetching data
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delete_id = (int)$_GET['id'];

    $imgStmt = $pdo->prepare("SELECT image FROM services WHERE id = ?");
    $imgStmt->execute([$delete_id]);
    $imgPath = $imgStmt->fetchColumn();
    if ($imgPath) {
        $fullPath = __DIR__ . '/../' . ltrim($imgPath, '/');
        if (file_exists($fullPath)) unlink($fullPath);
    }

    $pdo->prepare("DELETE FROM services WHERE id = ?")->execute([$delete_id]);
    header("Location: services.php?deleted=1");
    exit;
}

// Fetch from services table (NOT partners)
$services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

$msg = '';
if (isset($_GET['created']))  $msg = "تم إضافة الخدمة بنجاح";
if (isset($_GET['deleted']))  $msg = "تم حذف الخدمة بنجاح";
if (isset($_GET['updated']))  $msg = "تم تحديث الخدمة بنجاح";
?>

<div class="admin-wrapper">
    <?php include 'partials/sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <button class="btn-toggle-sidebar d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="page-title">إدارة الخدمات</h1>
            <div class="top-bar-actions">
                <a href="service-create.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i> إضافة خدمة جديدة
                </a>
            </div>
        </div>

        <div class="content-wrapper">

            <?php if ($msg): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo htmlspecialchars($msg); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        قائمة الخدمات
                        <span class="badge bg-secondary ms-1"><?php echo count($services); ?></span>
                    </h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th style="width:90px;">الصورة</th>
                                    <th>العنوان</th>
                                    <th>الوصف</th>
                                    <th style="width:100px; text-align:center;">مميز</th>
                                    <th style="width:100px;">الحالة</th>
                                    <th style="width:120px; text-align:center;">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($services)): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                        لا توجد خدمات بعد —
                                        <a href="service-create.php">أضف الأولى</a>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($services as $s): ?>
                                <tr>
                                    <td class="text-muted small"><?php echo (int)$s['id']; ?></td>
                                    <td>
                                        <?php if (!empty($s['image'])): ?>
                                        <img src="../<?php echo htmlspecialchars(ltrim($s['image'],'/')); ?>"
                                             class="service-thumb" alt=""
                                             onerror="this.style.display='none'">
                                        <?php else: ?>
                                        <div class="service-thumb bg-light d-flex align-items-center justify-content-center rounded">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($s['title']); ?></strong></td>
                                    <td>
                                        <span class="text-muted small" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;max-width:280px;">
                                            <?php echo htmlspecialchars($s['description']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($s['is_featured'])): ?>
                                            <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>مميز</span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($s['status'] === 'active'): ?>
                                            <span class="badge bg-success">نشط</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">غير نشط</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="service-edit.php?id=<?php echo (int)$s['id']; ?>"
                                               class="btn btn-outline-primary" title="تعديل">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger"
                                                    onclick="confirmDelete(<?php echo (int)$s['id']; ?>)"
                                                    title="حذف">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('هل أنت متأكد من حذف هذه الخدمة؟')) {
        window.location.href = 'services.php?action=delete&id=' + id;
    }
}
</script>

<?php include 'partials/footer.php'; ?>