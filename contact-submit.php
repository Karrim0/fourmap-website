<?php
/**
 * FourMap - Contact Form Handler
 * contact-submit.php
 *
 * Handles POST submission from contact.php
 * Validates input, sends email, redirects with status
 */

require_once 'includes/db.php';
require_once 'includes/settings.php';

/* -----------------------------------------------
   Only allow POST requests
   ----------------------------------------------- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

/* -----------------------------------------------
   Honeypot anti-spam check
   ----------------------------------------------- */
if (!empty($_POST['website'])) {
    header('Location: contact.php?status=success');
    exit;
}

/* -----------------------------------------------
   Helper: Sanitize input
   ----------------------------------------------- */
function clean_input(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/* -----------------------------------------------
   Collect & Sanitize Form Fields
   ----------------------------------------------- */
$name    = clean_input($_POST['name']    ?? '');
$phone   = clean_input($_POST['phone']   ?? '');
$email   = clean_input($_POST['email']   ?? '');
$message = clean_input($_POST['message'] ?? '');

/* -----------------------------------------------
   Server-Side Validation
   ----------------------------------------------- */
$errors = [];

if (empty($name)) {
    $errors[] = 'الاسم مطلوب.';
} elseif (mb_strlen($name, 'UTF-8') < 2) {
    $errors[] = 'الاسم يجب أن يكون حرفين على الأقل.';
} elseif (mb_strlen($name, 'UTF-8') > 100) {
    $errors[] = 'الاسم طويل جداً.';
}

if (empty($phone)) {
    $errors[] = 'رقم الجوال مطلوب.';
} elseif (!preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $phone)) {
    $errors[] = 'رقم الجوال غير صحيح.';
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'البريد الإلكتروني غير صحيح.';
}

if (mb_strlen($email, 'UTF-8') > 150) {
    $errors[] = 'البريد الإلكتروني طويل جداً.';
}

if (empty($message)) {
    $errors[] = 'الرسالة مطلوبة.';
} elseif (mb_strlen($message, 'UTF-8') < 10) {
    $errors[] = 'الرسالة يجب أن تكون 10 أحرف على الأقل.';
} elseif (mb_strlen($message, 'UTF-8') > 2000) {
    $errors[] = 'الرسالة طويلة جداً (الحد الأقصى 2000 حرف).';
}

if (!empty($errors)) {
    header('Location: contact.php?status=validation');
    exit;
}

/* -----------------------------------------------
   Recipient Email from Admin Panel (DB)
   ----------------------------------------------- */
$to = get_setting($pdo, 'contact_email', '');

// لازم يكون موجود وصحيح
if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.php?status=error');
    exit;
}

/* -----------------------------------------------
   Prepare Email
   ----------------------------------------------- */
$subject = 'رسالة جديدة من موقع فور ماب - ' . $name;

$body  = "رسالة جديدة من نموذج التواصل في موقع فور ماب\n";
$body .= "==============================================\n\n";
$body .= "الاسم: "   . $name  . "\n";
$body .= "الجوال: "  . $phone . "\n";
$body .= "البريد: "  . ($email ?: 'لم يُذكر') . "\n\n";
$body .= "الرسالة:\n";
$body .= "----------\n";
$body .= $message . "\n\n";
$body .= "==============================================\n";
$body .= "تاريخ الإرسال: " . date('Y-m-d H:i:s') . "\n";
$body .= "عنوان IP: " . ($_SERVER['REMOTE_ADDR'] ?? '-') . "\n";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
$headers .= 'From: FourMap Website <noreply@fourmap.sa>' . "\r\n";
$headers .= 'Reply-To: ' . ($email ?: 'noreply@fourmap.sa') . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

/* -----------------------------------------------
   Attempt to Send Email
   ----------------------------------------------- */
$mail_sent = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);

/* -----------------------------------------------
   Log submissions
   ----------------------------------------------- */
$log_dir  = __DIR__ . '/logs';
$log_file = $log_dir . '/contact_submissions.log';

if (!is_dir($log_dir)) {
    @mkdir($log_dir, 0755, true);
    @file_put_contents($log_dir . '/.htaccess', "Deny from all\n");
}

$log_entry  = '[' . date('Y-m-d H:i:s') . '] ';
$log_entry .= 'IP: ' . ($_SERVER['REMOTE_ADDR'] ?? '-') . ' | ';
$log_entry .= 'To: ' . $to . ' | ';
$log_entry .= 'Name: ' . $name . ' | ';
$log_entry .= 'Phone: ' . $phone . ' | ';
$log_entry .= 'Email: ' . ($email ?: '-') . ' | ';
$log_entry .= 'Mail sent: ' . ($mail_sent ? 'YES' : 'NO') . "\n";

@file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

/* -----------------------------------------------
   Redirect
   ----------------------------------------------- */
header('Location: contact.php?status=' . ($mail_sent ? 'success' : 'error'));
exit;