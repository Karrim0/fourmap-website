<?php
/**
 * FourMap - Services Page
 */

$pageTitle = 'خدماتنا - فور ماب';
$pageDesc = 'اكتشف مجموعة خدماتنا الهندسية الشاملة: تصاميم معمارية، رخص بناء، استشارات هندسية، ومتابعة مشاريع.';
$pageKeywords = 'خدمات هندسية, تصاميم, رخص بناء, استشارات هندسية, فور ماب';

require_once 'includes/header.php';
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="services-page-title">
    <div class="container">
        <h1 id="services-page-title"><span>خدماتنا</span> الهندسية</h1>
        <div class="page-breadcrumb">
            <a href="index.php">الرئيسية</a> / خدماتنا
        </div>
    </div>
</section>

<!-- SERVICES FULL GRID -->
<section class="services-full" aria-labelledby="services-intro-title">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title" id="services-intro-title">ماذا نقدم لك؟</h2>
            <p class="section-subtitle" style="margin-top:14px;">
                طيف واسع من الخدمات الهندسية المتخصصة في مكان واحد
            </p>
        </div>

        <div class="services-full-grid">

            <!-- Service 1 -->
            <article class="service-full-card">
                <div class="service-full-img">
                    <img src="assets/images/03.png" alt="التصاميم الهندسية" loading="lazy">
                </div>
                <div class="service-full-card-body">
                    <h3>التصاميم الهندسية</h3>
                    <p>
                        نقدم خدمات التصميم المعماري والإنشائي بأعلى مستويات الدقة والإبداع،
                        من التصميم الأولي حتى الرسومات التنفيذية الكاملة وفق معايير الكود السعودي للبناء.
                    </p>
                </div>
            </article>

            <!-- Service 2 -->
            <article class="service-full-card">
                <div class="service-full-img">
                    <img src="assets/images/04.png" alt="رخص البناء والتصاريح" loading="lazy">
                </div>
                <div class="service-full-card-body">
                    <h3>الرخص والتصاريح</h3>
                    <p>
                        نساعدك في استخراج جميع التراخيص اللازمة من البلدية وهيئة الجودة والسلامة،
                        ونتابع الطلبات حتى الحصول على الموافقات النهائية بأقل وقت وجهد.
                    </p>
                </div>
            </article>

            <!-- Service 3 -->
            <article class="service-full-card">
                <div class="service-full-img">
                    <img src="assets/images/05.png" alt="الاستشارات الهندسية" loading="lazy">
                </div>
                <div class="service-full-card-body">
                    <h3>الاستشارات الهندسية</h3>
                    <p>
                        فريق من المهندسين الاستشاريين المتخصصين جاهز لمساعدتك في اتخاذ القرارات الهندسية الصحيحة،
                        وتقديم الحلول المناسبة لمشاريعك الإنشائية والمعمارية.
                    </p>
                </div>
            </article>

            <!-- Service 4 -->
            <article class="service-full-card">
                <div class="service-full-img">
                    <img src="assets/images/06.png" alt="إدارة المشاريع" loading="lazy">
                </div>
                <div class="service-full-card-body">
                    <h3>إدارة المشاريع</h3>
                    <p>
                        نوفر خدمة الإشراف ومتابعة تنفيذ المشاريع ميدانياً، مع تقارير دورية تفصيلية
                        تضمن سير العمل وفق الجداول الزمنية والميزانيات المحددة.
                    </p>
                </div>
            </article>

            <!-- Service 5 -->
            <article class="service-full-card">
                <div class="service-full-img">
                    <img src="assets/images/07.png" alt="مراجعة المخططات" loading="lazy">
                </div>
                <div class="service-full-card-body">
                    <h3>مراجعة المخططات</h3>
                    <p>
                        نقدم خدمات مراجعة المخططات الهندسية والتأكد من توافقها مع الكود السعودي
                        واشتراطات البناء، مع تقديم التوصيات والتعديلات اللازمة.
                    </p>
                </div>
            </article>

            <!-- Service 6 -->
            <article class="service-full-card">
                <div class="service-full-img">
                    <img src="assets/images/08.png" alt="الإشراف الميداني" loading="lazy">
                </div>
                <div class="service-full-card-body">
                    <h3>الإشراف الميداني</h3>
                    <p>
                        إشراف هندسي متخصص على مواقع التنفيذ لضمان جودة الأعمال ومطابقتها للمواصفات،
                        مع متابعة دورية وتقارير تفصيلية عن سير العمل.
                    </p>
                </div>
            </article>

        </div>
    </div>
</section>

<!-- CTA STRIP -->
<section class="services-cta" aria-label="دعوة لاتخاذ إجراء">
    <div class="container">
        <div class="services-cta-inner">
            <div class="services-cta-text">
                <h2>هل تحتاج خدمة هندسية الآن؟</h2>
                <p>تواصل معنا وسنكون سعداء بمساعدتك في أقرب وقت</p>
            </div>
            <a href="contact.php" class="services-cta-btn">
                تواصل معنا الآن
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>