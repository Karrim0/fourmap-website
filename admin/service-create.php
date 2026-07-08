<?php
/**
 * Create New Service Page
 */
$page_title = 'إضافة خدمة جديدة';
include 'partials/header.php';
require_once '../includes/db.php';

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
        $error_message = 'صيغة الصورة غير مدعومة. استخدم JPG / PNG / WEBP فقط.';
        return null;
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        $error_message = 'حجم الصورة كبير. الحد الأقصى 5MB.';
        return null;
    }
    $uploadDir = __DIR__ . '/../assets/images/services/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $newName = 'service_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        $error_message = 'فشل حفظ الصورة على السيرفر.';
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
        $error_message = 'الرجاء ملء العنوان والوصف.';
    } else {
        $imagePath = uploadServiceImage($_FILES['image'] ?? null, $error_message);
        if ($error_message === '') {
            $stmt = $pdo->prepare("INSERT INTO services (title, description, image, status, is_featured) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $imagePath, $status, $is_featured]);
            header('Location: services.php?created=1');
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
            <h1 class="page-title">إضافة خدمة جديدة</h1>
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
                    <h5 class="card-title mb-0">معلومات الخدمة</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label for="title" class="form-label">عنوان الخدمة <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">وصف الخدمة <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">صورة الخدمة</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                            <div class="form-text">الحد الأقصى 2MB — JPG / PNG / WEBP</div>
                            <div class="mt-3" id="imagePreviewContainer" style="display:none;">
                                <img id="imagePreview" src="" alt="معاينة" class="img-thumbnail" style="max-width:300px;">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="status" class="form-label">حالة الخدمة</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" selected>نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                                    <label class="form-check-label fw-semibold" for="is_featured">
                                        <i class="bi bi-star-fill text-warning me-1"></i>
                                        عرض في الصفحة الرئيسية (مميز)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i> حفظ الخدمة
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