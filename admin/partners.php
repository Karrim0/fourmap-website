<?php
$page_title = 'إدارة الاعتمادات';
include 'partials/header.php';
require_once '../includes/db.php';

// Handle delete BEFORE fetching
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
    $id = (int)$_GET['id'];

    // Delete image file
    $imgStmt = $pdo->prepare("SELECT image FROM partners WHERE id = ?");
    $imgStmt->execute([$id]);
    $imgPath = $imgStmt->fetchColumn();
    if ($imgPath) {
        $fullPath = __DIR__ . '/../' . ltrim($imgPath, '/');
        if (file_exists($fullPath)) unlink($fullPath);
    }

    $pdo->prepare("DELETE FROM partners WHERE id = ?")->execute([$id]);
    header("Location: partners.php?deleted=1");
    exit;
}

// Fetch from partners table
$partners = $pdo->query("SELECT * FROM partners ORDER BY sort_order ASC, id DESC")->fetchAll(PDO::FETCH_ASSOC);

$msg = '';
if (isset($_GET['success'])) $msg = 'تم إضافة الاعتماد بنجاح';
if (isset($_GET['deleted'])) $msg = 'تم حذف الاعتماد بنجاح';
if (isset($_GET['updated'])) $msg = 'تم تحديث الاعتماد بنجاح';
?>

<div class="admin-wrapper">
  <?php include 'partials/sidebar.php'; ?>

  <div class="main-content">
    <div class="top-bar">
      <button class="btn-toggle-sidebar d-lg-none" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <h1 class="page-title">إدارة الاعتمادات</h1>
      <div class="top-bar-actions">
        <a href="partner-create.php" class="btn btn-primary">
          <i class="bi bi-plus-circle me-2"></i> إضافة اعتماد
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
            قائمة الاعتمادات
            <span class="badge bg-secondary ms-1"><?php echo count($partners); ?></span>
          </h5>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width:50px;">#</th>
                  <th style="width:110px;">اللوجو</th>
                  <th>الاسم</th>
                  <th style="width:100px;">الترتيب</th>
                  <th style="width:110px;">الحالة</th>
                  <th style="width:120px;" class="text-center">إجراءات</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($partners)): ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                      <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                      لا توجد اعتمادات بعد —
                      <a href="partner-create.php">أضف الأول</a>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($partners as $p): ?>
                    <tr>
                      <td class="text-muted small"><?php echo (int)$p['id']; ?></td>
                      <td>
                        <?php if (!empty($p['image'])): ?>
                          <img src="../<?php echo htmlspecialchars(ltrim($p['image'], '/')); ?>"
                               class="service-thumb" alt=""
                               style="object-fit:contain; background:#f8f9fa;"
                               onerror="this.style.display='none'">
                        <?php else: ?>
                          <div class="service-thumb bg-light d-flex align-items-center justify-content-center rounded">
                            <i class="bi bi-image text-muted"></i>
                          </div>
                        <?php endif; ?>
                      </td>
                      <td><strong><?php echo htmlspecialchars($p['name']); ?></strong></td>
                      <td><?php echo (int)$p['sort_order']; ?></td>
                      <td>
                        <?php if ($p['status'] === 'active'): ?>
                          <span class="badge bg-success">نشط</span>
                        <?php else: ?>
                          <span class="badge bg-secondary">غير نشط</span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                        <div class="btn-group btn-group-sm">
                          <a href="partner-edit.php?id=<?php echo (int)$p['id']; ?>"
                             class="btn btn-outline-primary" title="تعديل">
                            <i class="bi bi-pencil"></i>
                          </a>
                          <button type="button" class="btn btn-outline-danger"
                                  onclick="confirmDelete(<?php echo (int)$p['id']; ?>)"
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
  if (confirm('هل أنت متأكد من حذف هذا الاعتماد؟')) {
    window.location.href = 'partners.php?action=delete&id=' + id;
  }
}
</script>

<?php include 'partials/footer.php'; ?>