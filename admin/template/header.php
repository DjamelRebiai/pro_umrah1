<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}

// التحقق من تسجيل الدخول
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/views/auth/login.php');
    exit;
}

// تحديد اللغة
$lang = isset($_GET['lang']) && $_GET['lang'] === 'fr' ? 'fr' : 'ar';

// جلب معلومات المدير
$stmt = $pdo->prepare('SELECT * FROM admins WHERE id = ?');
$stmt->execute([$_SESSION['admin_id']]);
$admin = $stmt->fetch();

// جلب صلاحيات المدير
$stmt = $pdo->prepare('SELECT permission_key FROM admin_permissions WHERE admin_id = ?');
$stmt->execute([$_SESSION['admin_id']]);
$permissions = [];
while ($row = $stmt->fetch()) {
    $permissions[$row['permission_key']] = true;
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo $lang === 'ar' ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'لوحة التحكم - منصة العمرة'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <?php require_once __DIR__ . '/shared-styles.php'; ?>
</head>
<body>
    <?php require_once __DIR__ . '/shared-sidebar.php'; ?>
