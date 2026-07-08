<?php
/**
 * FourMap - Consultation Page
 */

// ===== SEO من قاعدة البيانات =====
$seoPage = 'consultation';

require_once 'includes/db.php';
require_once 'includes/settings.php';

$waNumber = get_setting($pdo, 'contact_whatsapp', '201044258597');
$toEmail  = get_setting($pdo, 'contact_email', '');

$servicesStmt = $pdo->query("SELECT title FROM services WHERE status='active' ORDER BY id ASC");
$servicesList = $servicesStmt->fetchAll(PDO::FETCH_COLUMN);

require_once 'includes/header.php';
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="consult-title">
  <div class="container">
    <h1 id="consult-title">طلب <span>عرض سعر</span> فوري</h1>
    <div class="page-breadcrumb">
      <a href="index.php">الرئيسية</a> / طلب استشارة
    </div>
  </div>
</section>

<!-- CONSULTATION SECTION -->
<section class="consultation-section">
  <div class="container">
    <div class="consult-grid">

      <!-- Benefits -->
      <div class="consult-benefits">
        <h2>جاهز لبدء <span>مشروعك؟</span></h2>
        <p>فريقنا من المهندسين المتخصصين جاهز لتقديم استشارة أولية مجانية وعرض سعر تنافسي في أسرع وقت.</p>

        <ul class="benefits-list">
          <li><span class="benefit-icon">✓</span> استشارة هندسية أولية مجانية</li>
          <li><span class="benefit-icon">✓</span> أسعار تنافسية وواضحة</li>
          <li><span class="benefit-icon">✓</span> دعم على مدار الساعة</li>
        </ul>

        <a href="https://wa.me/<?php echo $waNumber; ?>?text=<?php echo urlencode('السلام عليكم، أريد طلب استشارة هندسية'); ?>"
           class="consult-wa-direct" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.553 4.122 1.523 5.855L0 24l6.335-1.498A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.894 0-3.668-.497-5.2-1.367l-.374-.217-3.853.911.977-3.762-.243-.389A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
          </svg>
          تواصل مباشرة عبر واتساب
        </a>
      </div>

      <!-- Form -->
      <div class="consult-form-wrap">
        <h3>أرسل تفاصيل مشروعك</h3>

        <form id="consult-form">
          <div class="form-row">
            <div class="form-group">
              <label for="c-name">الاسم <span>*</span></label>
              <input type="text" id="c-name" name="name" required placeholder="اسمك الكريم">
            </div>
            <div class="form-group">
              <label for="c-phone">رقم الجوال <span>*</span></label>
              <input type="tel" id="c-phone" name="phone" required placeholder="05XXXXXXXX">
            </div>
          </div>

          <div class="form-group">
            <label for="c-service">نوع الخدمة المطلوبة</label>
            <select id="c-service" name="service">
              <option value="">اختر الخدمة</option>
              <?php foreach ($servicesList as $svc): ?>
                <option value="<?php echo htmlspecialchars($svc); ?>"><?php echo htmlspecialchars($svc); ?></option>
              <?php endforeach; ?>
              <option value="أخرى">أخرى</option>
            </select>
          </div>

          <div class="form-group">
            <label for="c-details">تفاصيل إضافية</label>
            <textarea id="c-details" name="details" rows="4" placeholder="اكتب أي تفاصيل تخص مشروعك..."></textarea>
          </div>

          <div class="consult-actions">
            <button type="button" class="btn-wa" id="btn-whatsapp">
              <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.553 4.122 1.523 5.855L0 24l6.335-1.498A11.955 11.955 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.894 0-3.668-.497-5.2-1.367l-.374-.217-3.853.911.977-3.762-.243-.389A9.96 9.96 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
              </svg>
              إرسال عبر واتساب
            </button>

            <button type="button" class="btn-email" id="btn-email">
              <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
              </svg>
              إرسال بالإيميل
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</section>

<script>
const waNumber = '<?php echo $waNumber; ?>';
const toEmail  = <?php echo json_encode($toEmail); ?>;

document.getElementById('btn-whatsapp').addEventListener('click', function () {
  const name    = document.getElementById('c-name').value.trim();
  const phone   = document.getElementById('c-phone').value.trim();
  const service = document.getElementById('c-service').value;
  const details = document.getElementById('c-details').value.trim();

  if (!name || !phone) { alert('الرجاء إدخال الاسم ورقم الجوال على الأقل'); return; }

  let msg = `السلام عليكم 👋\nأريد طلب استشارة هندسية\n\nالاسم: ${name}\nالجوال: ${phone}`;
  if (service) msg += `\nالخدمة: ${service}`;
  if (details) msg += `\nالتفاصيل: ${details}`;

  window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`, '_blank');
});

document.getElementById('btn-email').addEventListener('click', function () {
  const name    = document.getElementById('c-name').value.trim();
  const phone   = document.getElementById('c-phone').value.trim();
  const service = document.getElementById('c-service').value;
  const details = document.getElementById('c-details').value.trim();

  if (!name || !phone) { alert('الرجاء إدخال الاسم ورقم الجوال على الأقل'); return; }
  if (!toEmail)        { alert('البريد غير مُحدد حالياً من لوحة التحكم'); return; }

  let body = `السلام عليكم\n\nالاسم: ${name}\nالجوال: ${phone}`;
  if (service) body += `\nالخدمة: ${service}`;
  if (details) body += `\nالتفاصيل: ${details}`;

  window.open(`mailto:${toEmail}?subject=${encodeURIComponent('طلب استشارة - ' + name)}&body=${encodeURIComponent(body)}`, '_self');
});
</script>

<?php require_once 'includes/footer.php'; ?>