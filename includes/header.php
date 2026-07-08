<?php
/**
 * FourMap - Header Include
 * Transparent nav + Dynamic SEO from DB
 */

// ===== Language Session =====
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

$lang        = $_SESSION['lang'] ?? 'ar';
$dir         = $lang === 'ar' ? 'rtl' : 'ltr';
$htmlLang    = $lang;
$switchLang  = $lang === 'ar' ? 'en' : 'ar';
$switchLabel = $lang === 'ar' ? 'EN' : 'ع';
$switchTitle = $lang === 'ar' ? 'English' : 'عربي';

$currentPage = basename($_SERVER['PHP_SELF']);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/settings.php';

// ===== SEO — يتحدد من كل صفحة أو يسحب من DB =====
// كل صفحة بتحدد $seoPage قبل include header
// مثال: $seoPage = 'home'; في index.php
if (!isset($seoPage)) {
    $map = [
        'index.php'        => 'home',
        'about.php'        => 'about',
        'services.php'     => 'services',
        'contact.php'      => 'contact',
        'consultation.php' => 'consultation',
        'articles.php'     => 'articles',
        'article.php'      => 'article',
    ];
    $seoPage = $map[$currentPage] ?? 'home';
}

// سحب SEO من DB — مع fallback لو الحقل فاضي
// article مش بيسحب من DB — SEO بيجي من المقال نفسه
if ($seoPage !== 'article') {
    $seoTitle       = get_setting($pdo, "seo_{$seoPage}_title",       '');
    $seoDescription = get_setting($pdo, "seo_{$seoPage}_description", '');
    $seoKeywords    = get_setting($pdo, "seo_{$seoPage}_keywords",    '');
} else {
    $seoTitle       = '';
    $seoDescription = '';
    $seoKeywords    = '';
}

// Fallback defaults لو لسه ما اتملتش من لوحة التحكم
$defaults = [
    'home' => [
        'title'       => 'فور ماب - مكتبك الهندسي المتنقل',
        'description' => 'فور ماب منصة هندسية رقمية تقدم خدمات إصدار الرخص والتصاميم والإشراف الهندسي في المملكة العربية السعودية.',
        'keywords'    => 'فور ماب, خدمات هندسية, رخص بناء, تصاميم معمارية, المملكة العربية السعودية',
    ],
    'about' => [
        'title'       => 'من نحن - فور ماب',
        'description' => 'تعرف على فور ماب، المنصة الهندسية الرقمية الرائدة في المملكة العربية السعودية.',
        'keywords'    => 'من نحن, فور ماب, مكتب هندسي, خدمات هندسية',
    ],
    'services' => [
        'title'       => 'خدماتنا - فور ماب',
        'description' => 'اكتشف خدمات فور ماب الهندسية: رخص البناء، التصاميم المعمارية، الإشراف الهندسي والاستشارات.',
        'keywords'    => 'خدمات هندسية, رخص بناء, تصاميم, إشراف هندسي, فور ماب',
    ],
    'contact' => [
        'title'       => 'تواصل معنا - فور ماب',
        'description' => 'تواصل مع فريق فور ماب للحصول على خدماتك الهندسية.',
        'keywords'    => 'تواصل, فور ماب, استفسار, خدمات هندسية',
    ],
    'consultation' => [
        'title'       => 'طلب استشارة - فور ماب',
        'description' => 'احصل على استشارة هندسية متخصصة من فريق فور ماب المعتمد.',
        'keywords'    => 'استشارة هندسية, فور ماب, مهندس معتمد',
    ],
    'articles' => [
        'title'       => 'المقالات الهندسية - فور ماب',
        'description' => 'مقالات هندسية متخصصة من فريق فور ماب في المملكة العربية السعودية.',
        'keywords'    => 'مقالات هندسية, فور ماب, مقالات بناء, استشارات هندسية',
    ],
];

if ($seoPage !== 'article') {
    if (empty($seoTitle))       $seoTitle       = $defaults[$seoPage]['title']       ?? 'فور ماب';
    if (empty($seoDescription)) $seoDescription = $defaults[$seoPage]['description'] ?? '';
    if (empty($seoKeywords))    $seoKeywords    = $defaults[$seoPage]['keywords']    ?? '';
}

// SEO المقال الواحد — يجي من $articleSeo اللي بتتحدد في article.php
if ($seoPage === 'article' && isset($articleSeo)) {
    $seoTitle       = $articleSeo['title']       ?? 'فور ماب';
    $seoDescription = $articleSeo['description'] ?? '';
    $seoKeywords    = '';
}

// Fallback أخير لو article.php ما حددش $articleSeo
if ($seoPage === 'article' && empty($seoTitle)) {
    $seoTitle = 'مقال هندسي - فور ماب';
}

// دعم override يدوي من الصفحة نفسها (للصفحات الخاصة)
if (isset($pageTitle))    $seoTitle       = $pageTitle;
if (isset($pageDesc))     $seoDescription = $pageDesc;
if (isset($pageKeywords)) $seoKeywords    = $pageKeywords;

// Logo
$siteLogo = get_setting($pdo, 'site_logo', 'assets/images/thislogo.png');

// Canonical URL
$protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$canonical = $protocol . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');

// OG Image — للمقال بيستخدم صورة المقال لو موجودة
$ogImage = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/assets/images/thislogo.png';
if ($seoPage === 'article' && isset($articleSeo['image']) && !empty($articleSeo['image'])) {
    $ogImage = $articleSeo['image'];
}

// ===== Tracking IDs — تُسحب من DB مرة واحدة =====
$fbPixel   = get_setting($pdo, 'facebook_pixel',        '');
$gaId      = get_setting($pdo, 'google_analytics',      '');
$gscVerify = get_setting($pdo, 'google_search_console', '');
?>
<!DOCTYPE html>
<html lang="<?php echo $htmlLang; ?>" dir="<?php echo $dir; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#f5c518">

    <!-- ===== SEO Core ===== -->
    <title><?php echo htmlspecialchars($seoTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($seoDescription); ?>">
    <meta name="keywords"    content="<?php echo htmlspecialchars($seoKeywords); ?>">
    <link rel="canonical"    href="<?php echo htmlspecialchars($canonical); ?>">

    <!-- ===== Open Graph ===== -->
    <meta property="og:type"        content="<?php echo $seoPage === 'article' ? 'article' : 'website'; ?>">
    <meta property="og:title"       content="<?php echo htmlspecialchars($seoTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($seoDescription); ?>">
    <meta property="og:url"         content="<?php echo htmlspecialchars($canonical); ?>">
    <meta property="og:locale"      content="<?php echo $lang === 'ar' ? 'ar_SA' : 'en_US'; ?>">
    <meta property="og:site_name"   content="فور ماب | FourMap">
    <meta property="og:image"       content="<?php echo htmlspecialchars($ogImage); ?>">

    <!-- ===== Twitter Card ===== -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?php echo htmlspecialchars($seoTitle); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($seoDescription); ?>">
    <meta name="twitter:image"       content="<?php echo htmlspecialchars($ogImage); ?>">

    <!-- ===== Favicon ===== -->
    <link rel="icon" type="image/x-icon" href="assets/images/thislogo.png">

    <!-- ===== Fonts ===== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ===== Styles ===== -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- ===== Google Search Console Verification ===== -->
    <?php if (!empty($gscVerify)): ?>
    <meta name="google-site-verification" content="<?php echo htmlspecialchars($gscVerify); ?>">
    <?php endif; ?>

    <!-- ===== Google Analytics ===== -->
    <?php if (!empty($gaId)): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($gaId); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo htmlspecialchars($gaId); ?>');
    </script>
    <?php endif; ?>

</head>
<body class="<?php echo ($currentPage === 'index.php') ? 'is-home' : 'is-inner'; ?>">

<!-- ===== Facebook Pixel ===== -->
<?php if (!empty($fbPixel)): ?>
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo htmlspecialchars($fbPixel); ?>');
    fbq('track', 'PageView');
</script>
<noscript>
    <img height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id=<?php echo htmlspecialchars($fbPixel); ?>&ev=PageView&noscript=1"/>
</noscript>
<?php endif; ?>

<header class="site-header" id="site-header">
    <div class="container">
        <nav class="nav-inner" role="navigation">

            <!-- LOGO -->
            <div class="nav-logo">
                <a href="index.php">
                    <img src="<?php echo htmlspecialchars($siteLogo); ?>"
                         alt="FourMap Logo"
                         width="46" height="46"
                         onerror="this.style.display='none'">
                </a>
            </div>

            <!-- CENTER MENU -->
            <ul class="nav-menu" id="nav-menu" role="menubar">
                <li>
                    <a href="index.php" <?php if ($currentPage === 'index.php') echo 'class="active"'; ?>>
                        <?php echo $lang === 'ar' ? 'الرئيسية' : 'Home'; ?>
                    </a>
                </li>
                <li>
                    <a href="about.php" <?php if ($currentPage === 'about.php') echo 'class="active"'; ?>>
                        <?php echo $lang === 'ar' ? 'من نحن' : 'About Us'; ?>
                    </a>
                </li>
                <li>
                    <a href="services.php" <?php if ($currentPage === 'services.php') echo 'class="active"'; ?>>
                        <?php echo $lang === 'ar' ? 'خدماتنا' : 'Services'; ?>
                    </a>
                </li>
                <li>
                    <a href="articles.php" <?php if (in_array($currentPage, ['articles.php', 'article.php'])) echo 'class="active"'; ?>>
                        <?php echo $lang === 'ar' ? 'المقالات' : 'Articles'; ?>
                    </a>
                </li>
                <li>
                    <a href="contact.php" <?php if ($currentPage === 'contact.php') echo 'class="active"'; ?>>
                        <?php echo $lang === 'ar' ? 'تواصل معنا' : 'Contact'; ?>
                    </a>
                </li>
                <li>
                    <a href="consultation.php" <?php if ($currentPage === 'consultation.php') echo 'class="active"'; ?>>
                        <?php echo $lang === 'ar' ? 'طلب استشارة' : 'Consultation'; ?>
                    </a>
                </li>
            </ul>

            <!-- RIGHT ACTIONS -->
            <div class="nav-actions">
                <button class="nav-hamburger" id="nav-hamburger"
                        aria-label="<?php echo $lang === 'ar' ? 'فتح القائمة' : 'Open menu'; ?>"
                        aria-expanded="false"
                        aria-controls="nav-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </nav>
    </div>
</header>