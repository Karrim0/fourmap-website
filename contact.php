<?php
/**
 * FourMap - Contact Page
 */

$pageTitle = 'تواصل معنا - فور ماب';
$pageDesc = 'تواصل مع فريق فور ماب للحصول على استشارة هندسية أو للاستفسار عن خدماتنا المتنوعة.';
$pageKeywords = 'تواصل معنا, اتصل بنا, فور ماب, استشارة هندسية';

require_once 'includes/header.php';

// Form handling
$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Basic validation
    if (empty($name) || empty($phone) || empty($message)) {
        $errorMsg = 'الرجاء تعبئة جميع الحقول المطلوبة';
    } else {
        // Here you would send email or save to database
        // For now, just show success message
        $successMsg = 'شكراً لتواصلك معنا! سنرد عليك في أقرب وقت ممكن.';
        
        // Clear form
        $name = $phone = $email = $service = $message = '';
    }
}
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="contact-page-title">
    <div class="container">
        <h1 id="contact-page-title">تواصل <span>معنا</span></h1>
        <div class="page-breadcrumb">
            <a href="index.php">الرئيسية</a> / تواصل معنا
        </div>
    </div>
</section>

<!-- CONTACT SECTION -->
<section class="contact-section" aria-labelledby="contact-intro">
    <div class="container">
        <div class="contact-grid">

            <!-- Contact Info -->
            <div class="contact-info">
                <h2 id="contact-intro">
                    نحن هنا <span>لمساعدتك</span>
                </h2>
                <p>
                    يسعدنا تواصلك معنا للاستفسار عن خدماتنا أو الحصول على استشارة هندسية مجانية.
                    فريقنا جاهز للرد على جميع استفساراتك.
                </p>

                <div class="contact-details">
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div class="contact-detail-text">
                            <strong>العنوان</strong>
                            <span>المملكة العربية السعودية</span>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div class="contact-detail-text">
                            <strong>البريد الإلكتروني</strong>
                            <span>info@fourmap.sa</span>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                        </div>
                        <div class="contact-detail-text">
                            <strong>رقم الجوال</strong>
                            <span dir="ltr">+966 5X XXX XXXX</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrap">
                <h3>أرسل لنا رسالة</h3>

                <?php if ($successMsg): ?>
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <?php echo htmlspecialchars($successMsg); ?>
                </div>
                <?php endif; ?>

                <?php if ($errorMsg): ?>
                <div class="alert alert-error">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <?php echo htmlspecialchars($errorMsg); ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="" id="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">الاسم الكامل <span>*</span></label>
                            <input type="text" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($name ?? ''); ?>" 
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="phone">رقم الجوال <span>*</span></label>
                            <input type="tel" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($phone ?? ''); ?>" 
                                   required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($email ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="service">الخدمة المطلوبة</label>
                            <select id="service" name="service">
                                <option value="">اختر الخدمة</option>
                                <option value="design">التصاميم الهندسية</option>
                                <option value="license">الرخص والتصاريح</option>
                                <option value="consultation">الاستشارات الهندسية</option>
                                <option value="management">إدارة المشاريع</option>
                                <option value="review">مراجعة المخططات</option>
                                <option value="supervision">الإشراف الميداني</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">رسالتك <span>*</span></label>
                        <textarea id="message" name="message" 
                                  required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="form-submit-btn">
                        إرسال الرسالة
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>