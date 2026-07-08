<?php
/**
 * Edit Service Page
 */
$page_title = 'تعديل الخدمة';
include 'partials/header.php';
require_once '../includes/db.php';

$service_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$service_id) { header('Location: services.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
$stmt->execute([$service_id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$service) { header('Location: services.php'); exit; }

$error_message = '';

function uploadServiceImage($file, &$error_message) {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error_message = 'حصل خطأ أثناء رفع الصورة.';
        return null;
    }
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        $error_message = 'صيغة الصورة غير مدعومة.';
        return null;
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        $error_message = 'حجم الصورة أكبر من 5MB.';
        return null;
    }
    $uploadDir = __DIR__ . '/../assets/images/services/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $newName = 'service_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        $error_message = 'فشل حفظ الصورة.';
        return null;
    }
    return 'assets/images/services/' . $newName;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status      = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    if ($title === '' || $description === '') {
        $error_message = 'الرجاء ملء جميع الحقول.';
    } else {
        $newImagePath = uploadServiceImage($_FILES['image'] ?? null, $error_message);
        if ($error_message === '') {
            if ($newImagePath && !empty($service['image'])) {
                $old = __DIR__ . '/../' . $service['image'];
                if (file_exists($old)) unlink($old);
                $imageToSave = $newImagePath;
            } else {
                $imageToSave = $service['image'];
            }
            $stmt = $pdo->prepare("UPDATE services SET title=?, description=?, image=?, status=?, is_featured=? WHERE id=?");
            $stmt->execute([$title, $description, $imageToSave, $status, $is_featured, $service_id]);
            header("Location: services.php?updated=1");
            exit;
        }
    }
}
?>

<div class="admin-wrapper">
    <?php include 'partials/sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <button class="btn-toggle-sidebar d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="page-title">تعديل الخدمة</h1>
            <div class="top-bar-actions">
                <a href="services.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right me-2"></i> العودة للقائمة
                </a>
            </div>
        </div>

        <div class="content-wrapper">

            <?php if ($error_message): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo htmlspecialchars($error_message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">تعديل بيانات الخدمة</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label class="form-label">عنوان الخدمة <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                value="<?php echo htmlspecialchars($service['title']); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">الوصف <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                        </div>

                        <?php if (!empty($service['image'])): ?>
                        <div class="mb-3">
                            <label class="form-label">الصورة الحالية</label><br>
                            <img src="../<?php echo htmlspecialchars($service['image']); ?>"
                                 class="img-thumbnail" style="max-width:220px;"
                                 onerror="this.style.display='none'">
                        </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="form-label">تغيير الصورة (اختياري)</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                            <div class="form-text">الحد الأقصى 2MB — JPG / PNG / WEBP</div>
                            <div class="mt-3" id="imagePreviewContainer" style="display:none;">
                                <img id="imagePreview" src="" alt="معاينة" class="img-thumbnail" style="max-width:300px;">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="active"   <?php echo $service['status']==='active'   ? 'selected' : ''; ?>>نشط</option>
                                    <option value="inactive" <?php echo $service['status']==='inactive' ? 'selected' : ''; ?>>غير نشط</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                        <?php echo !empty($service['is_featured']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label fw-semibold" for="is_featured">
                                        <i class="bi bi-star-fill text-warning me-1"></i>
                                        عرض في الصفحة الرئيسية (مميز)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i> حفظ التعديلات
                            </button>
                            <a href="services.php" class="btn btn-outline-secondary">إلغاء</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>