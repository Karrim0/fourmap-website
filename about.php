<?php
/**
 * FourMap - About Page
 */

$pageTitle = 'من نحن | فور ماب - المكتب الهندسي المتنقل';
$pageDesc = 'تعرف على فريق فور ماب ورسالتنا في تقديم خدمات هندسية متكاملة رقمياً في المملكة العربية السعودية.';
$pageKeywords = 'من نحن, فور ماب, فريق العمل, رؤية 2030, خدمات هندسية';

require_once 'includes/header.php';
?>

<!-- PAGE HERO BANNER -->
<section class="page-hero" aria-labelledby="page-title">
    <div class="container">
        <h1 id="page-title">من <span>نحن</span></h1>
        <p class="page-breadcrumb">
            <a href="index.php">الرئيسية</a>
            &nbsp;&rsaquo;&nbsp;
            من نحن
        </p>
    </div>
</section>


<!-- ABOUT FULL SECTION -->
<section class="about-full" aria-labelledby="about-main-title">
    <div class="container">
        <div class="about-full-grid">

            <!-- Text Side -->
            <div class="about-full-text">
                <h2 id="about-main-title">
                    نحن <span>فور ماب</span>
                </h2>
                <p>
                    فور ماب هو منصة هندسية رقمية متكاملة أُسست بهدف توفير الخدمات الهندسية المتنوعة للمواطنين والمقيمين
                    في المملكة العربية السعودية، بطريقة سهلة، سريعة، وموثوقة من خلال تطبيق ذكي متعدد المنصات.
                </p>
                <p>
                    نؤمن في فور ماب بأن الوصول إلى الخدمة الهندسية المتخصصة يجب ألا يكون معقداً أو مكلفاً،
                    لذلك نعمل على ربط العملاء بأفضل المهندسين المعتمدين في مختلف التخصصات،
                    وتقديم الخدمة في أقل وقت وبأعلى جودة.
                </p>
                <p>
                    تأسست المنصة في إطار دعم رؤية 2030 لتحقيق التحول الرقمي في قطاع الإنشاء والبناء،
                    وتمكين المهندسين السعوديين من تقديم خدماتهم عبر قنوات رقمية متطورة.
                </p>
            </div>

            <!-- Image Side -->
            <div class="about-img-wrap">
                <img src="assets/images/05.png"
                     alt="فريق فور ماب الهندسي"
                     width="520"
                     height="400"
                     loading="lazy">
            </div>

        </div>

        <!-- Stats Row -->
        <div class="about-stats">
            <div class="stat-card">
                <div class="stat-number">+500</div>
                <div class="stat-label">مشروع منجز</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">+200</div>
                <div class="stat-label">مهندس معتمد</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">+3000</div>
                <div class="stat-label">عميل سعيد</div>
            </div>
        </div>

    </div>
</section>


<!-- MISSION & VALUES SECTION -->
<section class="mission-section" aria-labelledby="mission-title">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title white" id="mission-title">رسالتنا وقيمنا</h2>
        </div>
        <div class="mission-grid">

            <!-- Mission -->
            <div class="mission-card">
                <div class="mission-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="#1a1a1a">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                    </svg>
                </div>
                <h3>رسالتنا</h3>
                <p>
                    تمكين الأفراد والشركات من الحصول على خدمات هندسية متميزة بسهولة ويسر عبر منصة رقمية متكاملة.
                </p>
            </div>

            <!-- Vision -->
            <div class="mission-card">
                <div class="mission-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="#1a1a1a">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </div>
                <h3>رؤيتنا</h3>
                <p>
                    أن نكون المرجع الأول والمنصة الأكثر موثوقية في الخدمات الهندسية الرقمية على مستوى المملكة والمنطقة.
                </p>
            </div>

            <!-- Values -->
            <div class="mission-card">
                <div class="mission-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="#1a1a1a">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                </div>
                <h3>قيمنا</h3>
                <p>
                    الجودة، النزاهة، الابتكار، والتركيز على العميل — هذه القيم هي الأساس الذي نبني عليه كل ما نقدمه.
                </p>
            </div>

        </div>
    </div>
</section>


<!-- TEAM SECTION -->
<section class="team-section" aria-labelledby="team-title">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title" id="team-title">فريق العمل</h2>
            <p class="section-subtitle" style="margin-top:14px;">
                نخبة من المهندسين المتخصصين والمحترفين يعملون بشغف لخدمتك
            </p>
        </div>

        <div class="team-grid">

            <!-- Member 1 -->
            <div class="team-card">
                <div class="team-card-img" aria-hidden="true">
                    <span class="team-placeholder">👷</span>
                </div>
                <div class="team-card-body">
                    <h3>م. أحمد العتيبي</h3>
                    <span>المدير التنفيذي</span>
                    <p>مهندس مدني بخبرة تزيد عن 15 عاماً في مشاريع البنية التحتية.</p>
                </div>
            </div>

            <!-- Member 2 -->
            <div class="team-card">
                <div class="team-card-img" aria-hidden="true">
                    <span class="team-placeholder">👷</span>
                </div>
                <div class="team-card-body">
                    <h3>م. سارة الزهراني</h3>
                    <span>رئيسة قسم التصاميم</span>
                    <p>متخصصة في التصميم المعماري والداخلي بأكثر من 10 سنوات من الخبرة.</p>
                </div>
            </div>

            <!-- Member 3 -->
            <div class="team-card">
                <div class="team-card-img" aria-hidden="true">
                    <span class="team-placeholder">👷</span>
                </div>
                <div class="team-card-body">
                    <h3>م. فهد الدوسري</h3>
                    <span>مدير المشاريع</span>
                    <p>متخصص في إدارة المشاريع الإنشائية الكبرى وضمان الجودة.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>