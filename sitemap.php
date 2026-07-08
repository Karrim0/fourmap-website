<?php
/**
 * FourMap - Dynamic Sitemap
 * الرابط: /sitemap.xml
 */
header('Content-Type: application/xml; charset=utf-8');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$domain   = $protocol . '://' . $_SERVER['HTTP_HOST'];

$pages = [
    ['loc' => $domain . '/',                  'priority' => '1.00', 'changefreq' => 'weekly'],
    ['loc' => $domain . '/about.php',         'priority' => '0.80', 'changefreq' => 'monthly'],
    ['loc' => $domain . '/services.php',      'priority' => '0.90', 'changefreq' => 'weekly'],
    ['loc' => $domain . '/contact.php',       'priority' => '0.70', 'changefreq' => 'monthly'],
    ['loc' => $domain . '/consultation.php',  'priority' => '0.85', 'changefreq' => 'monthly'],
];

$today = date('Y-m-d');
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?>
  <url>
    <loc><?php echo htmlspecialchars($page['loc']); ?></loc>
    <lastmod><?php echo $today; ?></lastmod>
    <changefreq><?php echo $page['changefreq']; ?></changefreq>
    <priority><?php echo $page['priority']; ?></priority>
  </url>
<?php endforeach; ?>
</urlset>