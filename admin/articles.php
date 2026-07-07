
<?php
/**
 * Admin — Articles List
 */
$page_title = 'إدارة المقالات';
include 'partials/header.php';
require_once '../includes/db.php';

// Handle delete
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
    $id = (int)$_GET['id'];
    $imgStmt = $pdo->prepare("SELECT image FROM articles WHERE id = ?");
    $imgStmt->execute([$id]);
    $imgPath = $imgStmt->fetchColumn();
    if ($imgPath) {
        $full = __DIR__ . '/../' . ltrim($imgPath, '/');
        if (file_exists($full) && strpos($full, 'uploads/articles') !== false) unlink($full);
    }
    $pdo->prepare("DELETE FROM articles WHERE id = ?")->execute([$id]);
    header("Location: articles.php?deleted=1");
    exit;
}

$articles = $pdo->query("SELECT * FROM articles ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

$msg = '';
if (isset($_GET['created'])) $msg = 'تم إضافة المقال بنجاح';
if (isset($_GET['updated'])) $msg = 'تم تحديث المقال بنجاح';
if (isset($_GET['deleted'])) $msg = 'تم حذف المقال بنجاح';
?>

<div class="admin-wrapper">
  <?php include 'partials/sidebar.php'; ?>

  <div class="main-content">
    <div class="top-bar">
      <button class="btn-toggle-sidebar d-lg-none" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <h1 class="page-title">إدارة المقالات</h1>
      <div class="top-bar-actions">
        <a href="article-create.php" class="btn btn-primary">
          <i class="bi bi-plus-circle me-2"></i> إضافة مقال
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
            قائمة المقالات
            <span class="badge bg-secondary ms-1"><?php echo count($articles); ?></span>
          </h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width:80px;">الصورة</th>
                  <th>العنوان</th>
                  <th>المقتطف</th>
                  <th style="width:110px;">الحالة</th>
                  <th style="width:130px;">التاريخ</th>
                  <th style="width:110px;" class="text-center">إجراءات</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($articles)): ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                      <i class="bi bi-newspaper fs-3 d-block mb-2 opacity-25"></i>
                      لا توجد مقالات بعد —
                      <a href="article-create.php">أضف الأول</a>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($articles as $a): ?>
                    <tr>
                      <td>
                        <?php if (!empty($a['image'])): ?>
                          <img src="../<?php echo htmlspecialchars(ltrim($a['image'],'/')); ?>"
                               class="service-thumb" alt=""
                               onerror="this.style.display='none'">
                        <?php else: ?>
                          <div class="service-thumb bg-light d-flex align-items-center justify-content-center rounded">
                            <i class="bi bi-image text-muted"></i>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td><strong><?php echo htmlspecialchars($a['title']); ?></strong></td>
                      <td>
                        <span class="text-muted small" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;max-width:260px;">
                          <?php echo htmlspecialchars($a['excerpt'] ?? ''); ?>
                        </span>
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
                      <td class="text-center">
                        <div class="btn-group btn-group-sm">
                          <a href="article-edit.php?id=<?php echo (int)$a['id']; ?>"
                             class="btn btn-outline-primary" title="تعديل">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <button type="button" class="btn btn-outline-danger"
                                  onclick="confirmDelete(<?php echo (int)$a['id']; ?>)" title="حذف">
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
  if (confirm('هل أنت متأكد من حذف هذا المقال؟')) {
    window.location.href = 'articles.php?action=delete&id=' + id;
  }
}
</script>

<?php include 'partials/footer.php'; ?>