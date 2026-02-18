<?php
/**
 * FourMap - Homepage
 */

$pageTitle = 'فور ماب - كل خدماتك الهندسية، بين يديك!';
$pageDesc = 'فور ماب هو مكتبك الهندسي المتنقل - احصل على جميع خدماتك الهندسية بكل سهولة من خلال تطبيقنا في المملكة العربية السعودية.';
$pageKeywords = 'فور ماب, خدمات هندسية, مكتب هندسي, تطبيق هندسي, هندسة, المملكة العربية السعودية, رخص, تصاميم';

require_once 'includes/header.php';
?>

<!-- HERO SECTION -->
<section class="hero-section" aria-labelledby="hero-title">
    <div class="container">
        <div class="hero-inner">

            <!-- Text Content -->
            <div class="hero-text">
                <h1 class="hero-title" id="hero-title">
                    كل خدماتك الهندسية، <span>بين يديك !</span>
                </h1>

                <p class="hero-subtitle">مكتبك الهندسي المتنقل</p>

                <!-- Store badges -->
<div class="hero-buttons">

    <a href="#" class="hero-store-badge" aria-label="تحميل من App Store">
        <img src="assets/images/appstore.png"
             alt="تحميل من App Store"
             loading="eager">
    </a>

    <a href="#" class="hero-store-badge" aria-label="تحميل من Google Play">
        <img src="assets/images/googleplay.png"
             alt="تحميل من Google Play"
             loading="eager">
    </a>

</div>

            </div>

            <!-- Hero Image with Yellow Corner Frame -->
            <div class="hero-image">
                
                <div class="hero-img-wrap">
                    <img src="assets/images/01.png"
                         alt="خوذة هندسية - فور ماب"
                         loading="eager"
                         onerror="this.style.display='none'">
                </div>
            </div>

        </div>
        
    </div>
</section>


<!-- ABOUT SECTION -->
<section class="about-section section-pad" id="about" aria-labelledby="about-title">
    <div class="container">
        
        <!-- Media Box -->
        <div class="about-media-box">
            <img src="assets/images/about.png" 
                 alt="فور ماب - من نحن" 
                 loading="lazy"
                 onerror="this.style.display='none'">
        </div>

        <!-- Title -->
        <div class="text-center" style="margin-bottom:36px;">
            <h2 class="section-title" id="about-title">من نحن؟</h2>
        </div>

        <!-- Text content -->
        <div class="about-text-content">
            <p>
                فور ماب منصة إلكترونية مبتكرة تقدم حلول هندسية وخدمات هندسية متكاملة، دون الحاجة 
                لزيارات مكتبية أو مراجعات متعددة. مصممة خصيصاً لتلبية احتياجات السوق السعودي
            </p>
            <p>
                بسهولة، سرعة وثقه. نسعى لتحويل الأجراءات المعقدة إلى تجارب سلسة، عبر واجهة رقمية
                تمكن الأفراد والشركات من تنفيذ متطلباتهم الهندسية.
            </p>
        </div>
    </div>
</section>


<!-- SERVICES SECTION -->
<section class="services-section" id="services" aria-labelledby="services-title">
  <div class="container-fluid services-wrap">

    <div class="services-header text-center">
      <img id="services-title"
           class="services-title-img"
           src="assets/images/5damtna.png"
           alt="خدماتنا"
           loading="lazy"
           onerror="this.style.display='none'">
    </div>

    <div class="services-strips">

      <div class="service-strip">
        <img src="assets/images/03.png" alt="التصاميم الهندسية" loading="lazy">
        <div class="service-strip-overlay">
          <div class="service-caption">
            <h3 class="service-title">التصاميم الهندسية</h3>
            <p class="service-desc">تصاميم احترافية بمعايير دقيقة وتجهيز كامل للملفات.</p>
          </div>
        </div>
      </div>

      <div class="service-strip">
        <img src="assets/images/04.png" alt="الرخص والتصاريح" loading="lazy">
        <div class="service-strip-overlay">
          <div class="service-caption">
            <h3 class="service-title">الرخص والتصاريح</h3>
            <p class="service-desc">إنجاز إجراءات الرخص والتصاريح بسرعة ووضوح.</p>
          </div>
        </div>
      </div>

      <div class="service-strip">
        <img src="assets/images/05.png" alt="الاستشارات الهندسية" loading="lazy">
        <div class="service-strip-overlay">
          <div class="service-caption">
            <h3 class="service-title">الاستشارات الهندسية</h3>
            <p class="service-desc">استشارات فنية تساعدك تاخد القرار الصح.</p>
          </div>
        </div>
      </div>

      <div class="service-strip">
        <img src="assets/images/06.png" alt="إدارة المشاريع" loading="lazy">
        <div class="service-strip-overlay">
          <div class="service-caption">
            <h3 class="service-title">إدارة المشاريع</h3>
            <p class="service-desc">تنظيم ومتابعة التنفيذ خطوة بخطوة حتى التسليم.</p>
          </div>
        </div>
      </div>

      <div class="service-strip">
        <img src="assets/images/07.png" alt="مراجعة المخططات" loading="lazy">
        <div class="service-strip-overlay">
          <div class="service-caption">
            <h3 class="service-title">مراجعة المخططات</h3>
            <p class="service-desc">مراجعة دقيقة للمخططات لضمان الجودة وتفادي الأخطاء.</p>
          </div>
        </div>
      </div>

      <div class="service-strip">
        <img src="assets/images/08.png" alt="الإشراف الميداني" loading="lazy">
        <div class="service-strip-overlay">
          <div class="service-caption">
            <h3 class="service-title">الإشراف الميداني</h3>
            <p class="service-desc">إشراف ومتابعة ميدانية لضمان مطابقة التنفيذ.</p>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>



<!-- WHY US SECTION -->
<section class="why-section" id="why-us" aria-labelledby="why-title">
    <div class="container">

        <header class="why-header">
            <h2 class="why-title" id="why-title">ليه فور ماب؟</h2>
            <p class="why-subtitle">منصة رقمية موحدة تجمع كل الخدمات الهندسية المهمة في مكان واحد</p>
        </header>

        <div class="why-grid">
            <div class="why-item">
                <div class="why-icon">
                    <img src="assets/images/11.png" alt="سهولة الوصول" loading="lazy">
                </div>
                <h3 class="why-item-title">سهولة الوصول</h3>
                <p class="why-item-text">كل الخدمات متوفرة عبر الجوال في تطبيق واحد</p>
            </div>

            <div class="why-item">
                <div class="why-icon">
                    <img src="assets/images/10.png" alt="مهندسين سعوديين" loading="lazy">
                </div>
                <h3 class="why-item-title">مهندسين سعوديين</h3>
                <p class="why-item-text">خدمات تنفيذ واستشارات عبر محترفين معتمدين</p>
            </div>

            <div class="why-item">
                <div class="why-icon">
                    <img src="assets/images/12.png" alt="تنفيذ سريع وموثوق" loading="lazy">
                </div>
                <h3 class="why-item-title">تنفيذ سريع وموثوق</h3>
                <p class="why-item-text">نظام متابعة فوري من الطلب حتى التسليم</p>
            </div>

            <div class="why-item">
                <div class="why-icon">
                    <img src="assets/images/13.png" alt="توثيق ومصداقية" loading="lazy">
                </div>
                <h3 class="why-item-title">توثيق ومصداقية</h3>
                <p class="why-item-text">كل الإجراءات مرتبطة بجهات موثوقة ومرخصة</p>
            </div>
        </div>

    </div>
</section>


<!-- VISION SECTION -->
<section class="vision" id="vision" aria-labelledby="vision-title">

    <!-- Dark header bar -->
    <div class="vision-topbar">
        <div class="container">
            <div class="vision-topbar-inner">
                <div class="vision-title">
                    <img src="assets/images/visionheader.png" alt="رؤيتنا المستقبلية">
                </div>
            </div>
        </div>
    </div>

    <!-- White content area -->
    <div class="vision-body">
        <div class="container">

            <p class="vision-text">
                نسعى في فور ماب إلى أن نكون المنصة الهندسية الرقمية الرائدة في المملكة، من خلال
                تقديم حلول متكاملة في إدارة المشاريع، التصاميم، وإصدار الرخص وفق أعلى المعايير الفنية.
                نعتمد على الكفاءة الهندسية، التحول الرقمي، وضبط الجودة لضمان تنفيذ المشاريع بدقة وكفاءة واستدامة.
            </p>

            <div class="vision-map">
                <img class="vision-map-img" 
                     src="assets/images/09.png" 
                     alt="خريطة المملكة العربية السعودية - رؤية 2030" 
                     loading="lazy">
            </div>

        </div>
    </div>

</section>


<!-- FINAL CTA SECTION -->
<section class="cta-section" id="cta" aria-labelledby="cta-title">
    <div class="container">
        <div class="cta-inner">

            <!-- CTA Text -->
            <div class="cta-text">
                <h2 id="cta-title">
                    فريقنا من المهندسين <span>المتخصصين</span> جاهز لمساعدتك
                </h2>
                <p>تواصل معنا الآن للحصول على استشارة هندسية</p>
                
                <!-- Store badges -->
<div class="cta-store-badges">
    <a href="#" target="_blank">
        <img src="assets/images/appstore.png"
             alt="تحميل من App Store"
             loading="lazy">
    </a>

    <a href="#" target="_blank">
        <img src="assets/images/googleplay.png"
             alt="تحميل من Google Play"
             loading="lazy">
    </a>
</div>

            </div>

            <!-- Phone Mockup with Yellow Frame -->
            <div class="cta-phone-wrapper">
                <div class="cta-yellow-frame">
                    <img src="assets/images/logo4.png" alt="" aria-hidden="true">
                </div>
                <div class="cta-phone">
                    <img src="assets/images/14.png"
                         alt="صورة تطبيق فور ماب على الجوال"
                         loading="lazy"
                         onerror="this.style.display='none'">
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>