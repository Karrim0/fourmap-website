<?php
/**
 * Admin Login Page
 */
session_start();

// Already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

require_once '../includes/db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error_message = 'الرجاء إدخال اسم المستخدم وكلمة المرور';
    } else {
        // Fetch admin from DB
        $stmt = $pdo->prepare("SELECT id, name, username, password FROM admins WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            // Regenerate session ID to prevent fixation
            session_regenerate_id(true);

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id']        = $admin['id'];
            $_SESSION['admin_name']      = $admin['name'];
            $_SESSION['admin_username']  = $admin['username'];

            header('Location: dashboard.php');
            exit;
        } else {
            // Generic message — don't reveal whether username or password is wrong
            $error_message = 'اسم المستخدم أو كلمة المرور غير صحيحة';

            // Small delay to slow down brute force
            sleep(1);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - فور ماب</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="login-page">

<div class="login-container">
    <div class="login-card">

        <div class="login-header">
            <div class="login-logo">
                <i class="bi bi-hexagon-fill text-warning"></i>
            </div>
            <h2>فور ماب</h2>
            <p>لوحة التحكم الإدارية</p>
        </div>

        <?php if ($error_message): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
            <span><?php echo htmlspecialchars($error_message); ?></span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <form method="POST" action="" class="login-form" autocomplete="off">

            <div class="mb-3">
                <label for="username" class="form-label">
                    <i class="bi bi-person me-1"></i> اسم المستخدم
                </label>
                <input type="text"
                       class="form-control"
                       id="username"
                       name="username"
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                       placeholder="أدخل اسم المستخدم"
                       required
                       autofocus
                       autocomplete="username">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-1"></i> كلمة المرور
                </label>
                <div class="input-group">
                    <input type="password"
                           class="form-control"
                           id="password"
                           name="password"
                           placeholder="أدخل كلمة المرور"
                           required
                           autocomplete="current-password">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()" tabindex="-1">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-left me-2"></i>
                تسجيل الدخول
            </button>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
</body>
</html>