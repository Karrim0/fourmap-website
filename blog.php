<?php
/**
 * FourMap - Blog Page
 */

$pageTitle = 'المدونة - فور ماب';
$pageDesc = 'اقرأ أحدث المقالات والأخبار الهندسية، ونصائح البناء والتصميم من فريق فور ماب المتخصص.';
$pageKeywords = 'مدونة هندسية, مقالات هندسية, نصائح بناء, فور ماب, هندسة';

include 'includes/header.php';

$blog_posts = [
    [
        'id' => 1,
        'tag' => 'هندسة مدنية',
        'title' => '5 أشياء يجب معرفتها قبل البدء في بناء منزلك',
        'excerpt' => 'التخطيط الجيد هو نصف النجاح في أي مشروع بناء، تعرف على أهم العوامل التي ستحدد مسار مشروعك من البداية.',
        'date' => '12 فبراير 2025',
        'author' => 'م. أحمد العتيبي',
        'img' => 'assets/images/01.png',
    ],
    [
        'id' => 2,
        'tag' => 'رخص البناء',
        'title' => 'كيفية استخراج رخصة البناء في المملكة العربية السعودية خطوة بخطوة',
        'excerpt' => 'دليلك الشامل لفهم إجراءات استخراج رخص البناء من البلديات، والمتطلبات والوثائق اللازمة لكل نوع.',
        'date' => '8 فبراير 2025',
        'author' => 'م. فهد الدوسري',
        'img' => 'assets/images/08.png',
    ],
    [
        'id' => 3,
        'tag' => 'رؤية 2030',
        'title' => 'كيف تساهم رؤية 2030 في تطوير القطاع الهندسي والإنشائي',
        'excerpt' => 'نظرة تحليلية على المبادرات الحكومية ضمن رؤية 2030 وأثرها على قطاع الإنشاء والتطوير العمراني في المملكة.',
        'date' => '1 فبراير 2025',
        'author' => 'م. سارة الزهراني',
        'img' => 'assets/images/03.png',
    ],
    [
        'id' => 4,
        'tag' => 'تصميم معماري',
        'title' => 'أحدث اتجاهات التصميم المعماري في منازل عام 2025',
        'excerpt' => 'استكشف أبرز التوجهات المعمارية العالمية التي تُشكل ملامح التصميم الحديث للمنازل والمباني السكنية.',
        'date' => '25 يناير 2025',
        'author' => 'م. سارة الزهراني',
        'img' => 'assets/images/04.png',
    ],
    [
        'id' => 5,
        'tag' => 'إدارة مشاريع',
        'title' => 'أهمية الإشراف الهندسي الميداني في ضمان جودة التنفيذ',
        'excerpt' => 'يؤدي المشرف الهندسي دوراً محورياً في ضمان تطابق التنفيذ مع التصاميم والمواصفات الفنية المعتمدة.',
        'date' => '18 يناير 2025',
        'author' => 'م. فهد الدوسري',
        'img' => 'assets/images/05.png',
    ],
    [
        'id' => 6,
        'tag' => 'تقنية',
        'title' => 'مستقبل التكنولوجيا في قطاع الإنشاء: BIM والذكاء الاصطناعي',
        'excerpt' => 'كيف تُغير تقنيات نمذجة معلومات البناء (BIM) والذكاء الاصطناعي طريقة تصميم وتنفيذ المشاريع الإنشائية.',
        'date' => '10 يناير 2025',
        'author' => 'م. أحمد العتيبي',
        'img' => 'assets/images/06.png',
    ],
];
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="blog-page-title">
    <div class="container">
        <h1 id="blog-page-title">مدوّنة <span>فور ماب</span></h1>
        <div class="page-breadcrumb">
            <a href="index.php">الرئيسية</a> / المدونة
        </div>
    </div>
</section>

<!-- BLOG POSTS GRID -->
<section class="blog-section" aria-labelledby="blog-grid-title">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title" id="blog-grid-title">آخر المقالات</h2>
            <p class="section-subtitle" style="margin-top:14px;">
                مقالات هندسية متخصصة يكتبها فريقنا من الخبراء
            </p>
        </div>

        <div class="blog-grid">
            <?php foreach ($blog_posts as $post): ?>
            <article class="blog-card">

                <div class="blog-card-img">
                    <img src="<?php echo htmlspecialchars($post['img']); ?>"
                         alt="<?php echo htmlspecialchars($post['title']); ?>"
                         loading="lazy">
                </div>

                <div class="blog-card-body">
                    <span class="blog-card-tag"><?php echo htmlspecialchars($post['tag']); ?></span>
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars($post['excerpt']); ?></p>

                    <div class="blog-card-meta">
                        <span class="blog-date">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                            </svg>
                            <?php echo htmlspecialchars($post['date']); ?>
                        </span>
                        <a href="#" class="blog-read-more" 
                           aria-label="اقرأ المزيد عن <?php echo htmlspecialchars($post['title']); ?>">
                            اقرأ المزيد
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="blog-pagination">
            <a href="#" class="pagination-item active">1</a>
            <a href="#" class="pagination-item">2</a>
            <a href="#" class="pagination-item">3</a>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>