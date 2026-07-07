<!-- includes/settings.php -->
<?php
function e($str) {
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

function get_setting(PDO $pdo, string $key, $default = '') {
  static $cache = [];
  if (array_key_exists($key, $cache)) return $cache[$key];

  $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1");
  $stmt->execute([$key]);
  $val = $stmt->fetchColumn();

  $cache[$key] = ($val !== false && $val !== null) ? (string)$val : (string)$default;
  return $cache[$key];
}

function set_setting(PDO $pdo, string $key, string $value, string $type = 'text'): void {
  $stmt = $pdo->prepare("
    INSERT INTO site_settings (setting_key, setting_value, setting_type)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE
      setting_value = VALUES(setting_value),
      setting_type  = VALUES(setting_type)
  ");
  $stmt->execute([$key, $value, $type]);
}

function upload_setting_image(string $inputName, string $uploadDir = 'assets/uploads/settings/', array $allowedExt = ['png','jpg','jpeg','webp','svg'], int $maxBytes = 2097152): ?string {
  if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] === UPLOAD_ERR_NO_FILE) return null;
  if ($_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) return null;

  $ext = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));
  if (!in_array($ext, $allowedExt, true)) return null;

  if (!empty($_FILES[$inputName]['size']) && $_FILES[$inputName]['size'] > $maxBytes) return null;

  $absDir = __DIR__ . '/../' . $uploadDir;
  if (!is_dir($absDir)) mkdir($absDir, 0775, true);

  $fileName = 'logo_' . time() . '_' . rand(1000,9999) . '.' . $ext;
  $target = $absDir . $fileName;

  if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $target)) return null;

  return $uploadDir . $fileName; // يتخزن في DB
}
