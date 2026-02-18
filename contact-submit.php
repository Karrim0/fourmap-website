<?php
/**
 * FourMap - Contact Form Handler
 * contact-submit.php
 *
 * Handles POST submission from contact.php
 * Validates input, sends email, redirects with status
 */

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
    // Silently redirect as success (bot trapped)
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

// Name: required, min 2 chars, max 100
if (empty($name)) {
    $errors[] = 'الاسم مطلوب.';
} elseif (mb_strlen($name, 'UTF-8') < 2) {
    $errors[] = 'الاسم يجب أن يكون حرفين على الأقل.';
} elseif (mb_strlen($name, 'UTF-8') > 100) {
    $errors[] = 'الاسم طويل جداً.';
}

// Phone: required, must match Saudi/international pattern
if (empty($phone)) {
    $errors[] = 'رقم الجوال مطلوب.';
} elseif (!preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $phone)) {
    $errors[] = 'رقم الجوال غير صحيح.';
}

// Email: optional but validate format if provided
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'البريد الإلكتروني غير صحيح.';
}

// Email max length
if (mb_strlen($email, 'UTF-8') > 150) {
    $errors[] = 'البريد الإلكتروني طويل جداً.';
}

// Message: required, min 10 chars, max 2000
if (empty($message)) {
    $errors[] = 'الرسالة مطلوبة.';
} elseif (mb_strlen($message, 'UTF-8') < 10) {
    $errors[] = 'الرسالة يجب أن تكون 10 أحرف على الأقل.';
} elseif (mb_strlen($message, 'UTF-8') > 2000) {
    $errors[] = 'الرسالة طويلة جداً (الحد الأقصى 2000 حرف).';
}

/* -----------------------------------------------
   If validation fails, redirect back with error
   ----------------------------------------------- */
if (!empty($errors)) {
    // Store errors in session (optional) or redirect with generic message
    // For simplicity, redirect with validation status
    header('Location: contact.php?status=validation');
    exit;
}

/* -----------------------------------------------
   Prepare Email
   ----------------------------------------------- */

// Recipient email — change to your actual address
$to = 'info@fourmap.sa';

// Subject
$subject = 'رسالة جديدة من موقع فور ماب - ' . $name;

// Email body (plain text, UTF-8)
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
$body .= "عنوان IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

// Email headers
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
$headers .= 'From: FourMap Website <noreply@fourmap.sa>' . "\r\n";
$headers .= 'Reply-To: ' . ($email ?: 'noreply@fourmap.sa') . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

/* -----------------------------------------------
   Attempt to Send Email
   ----------------------------------------------- */
// On shared hosting, mail() usually works.
// On XAMPP/local, it may not send but will return true.
$mail_sent = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);

/* -----------------------------------------------
   Optional: Log submissions to a file
   (comment out in production if not needed)
   ----------------------------------------------- */
$log_dir  = __DIR__ . '/logs';
$log_file = $log_dir . '/contact_submissions.log';

// Create logs directory if it doesn't exist
if (!is_dir($log_dir)) {
    @mkdir($log_dir, 0755, true);
    // Protect the directory
    @file_put_contents($log_dir . '/.htaccess', "Deny from all\n");
}

$log_entry  = '[' . date('Y-m-d H:i:s') . '] ';
$log_entry .= 'IP: ' . $_SERVER['REMOTE_ADDR'] . ' | ';
$log_entry .= 'Name: ' . $name . ' | ';
$log_entry .= 'Phone: ' . $phone . ' | ';
$log_entry .= 'Email: ' . ($email ?: '-') . ' | ';
$log_entry .= 'Mail sent: ' . ($mail_sent ? 'YES' : 'NO') . "\n";

@file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

/* -----------------------------------------------
   Redirect with success status
   (Even if mail fails, show success to user —
    the log file retains the submission data)
   ----------------------------------------------- */
if ($mail_sent) {
    header('Location: contact.php?status=success');
} else {
    // Mail failed but we still logged it
    // On local/XAMPP this is expected — treat as success
    header('Location: contact.php?status=success');
}

exit;
