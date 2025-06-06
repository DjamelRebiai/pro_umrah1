<?php
// Activation des erreurs pour le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../includes/db.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/views/auth/login.php');
    exit;
}

// التحقق من الصلاحيات
$admin_id = $_SESSION['admin_id'];
$stmt = $pdo->prepare('SELECT * FROM admins WHERE id = ?');
$stmt->execute([$admin_id]);
$current_admin = $stmt->fetch();

// التحقق من صلاحيات إدارة المدراء
$stmt = $pdo->prepare('SELECT * FROM admin_permissions WHERE admin_id = ? AND permission_key = ?');
$stmt->execute([$admin_id, 'manage_admins']);
$admin_permission = $stmt->fetch();

$can_manage_admins = ($current_admin['id'] == 1) || 
                    ($admin_permission && $admin_permission['allow_view']);

if (!$can_manage_admins) {
    header('Location: ' . BASE_URL . '/admin/dashboard.php');
    exit;
}

// معالجة العمليات POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                if (isset($_POST['username'], $_POST['full_name'], $_POST['email'], $_POST['password'])) {
                    try {
                        // التحقق من عدم تكرار اسم المستخدم
                        $stmt = $pdo->prepare('SELECT id FROM admins WHERE username = ?');
                        $stmt->execute([$_POST['username']]);
                        if ($stmt->fetch()) {
                            $_SESSION['error'] = "اسم المستخدم موجود مسبقاً";
                        } else {
                            // إضافة المدير الجديد
                            $stmt = $pdo->prepare('INSERT INTO admins (username, password, full_name, email) VALUES (?, ?, ?, ?)');
                            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            $stmt->execute([
                                $_POST['username'],
                                $hashed_password,
                                $_POST['full_name'],
                                $_POST['email']
                            ]);
                            
                            // إضافة الصلاحيات
                            $new_admin_id = $pdo->lastInsertId();
                            if (isset($_POST['permissions']) && is_array($_POST['permissions'])) {
                                $stmt = $pdo->prepare('INSERT INTO admin_permissions (admin_id, permission_key, allow_view, allow_add, allow_edit, allow_delete) VALUES (?, ?, true, true, true, true)');
                                foreach ($_POST['permissions'] as $permission) {
                                    $stmt->execute([$new_admin_id, $permission]);
                                }
                            }
                            $_SESSION['success'] = "تمت إضافة المدير بنجاح";
                        }
                    } catch (PDOException $e) {
                        $_SESSION['error'] = "حدث خطأ أثناء إضافة المدير: " . $e->getMessage();
                    }
                }
                break;

            case 'delete':
                if (isset($_POST['admin_id']) && $_POST['admin_id'] != 1) {
                    try {
                        $stmt = $pdo->prepare('DELETE FROM admins WHERE id = ? AND id != 1');
                        $stmt->execute([$_POST['admin_id']]);
                        $_SESSION['success'] = "تم حذف المدير بنجاح";
                    } catch (PDOException $e) {
                        $_SESSION['error'] = "حدث خطأ أثناء حذف المدير";
                    }
                }
                break;
        }
    }
}

// جلب قائمة المدراء
$stmt = $pdo->query('SELECT a.*, 
    (SELECT COUNT(*) FROM admin_permissions WHERE admin_id = a.id) as permissions_count 
    FROM admins a ORDER BY a.id');
$admins = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المدراء - منصة العمرة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <?php require_once __DIR__ . '/../../template/shared-styles.php'; ?>
</head>
<body>
    <?php require_once __DIR__ . '/../../template/shared-sidebar.php'; ?>
    
    <!-- Main Content -->
<main class="main-content">
    <div class="header">
        <div class="header-content">
            <div class="welcome-text">
                <h1>إدارة المدراء</h1>
                <p>إضافة وتعديل وحذف المدراء</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="openModal('adminModal')">
                    <i class="fas fa-plus"></i> إضافة مدير جديد
                </button>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المستخدم</th>
                            <th>الاسم الكامل</th>
                            <th>البريد الإلكتروني</th>
                            <th>عدد الصلاحيات</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admin['id']); ?></td>
                            <td><?php echo htmlspecialchars($admin['username']); ?></td>
                            <td><?php echo htmlspecialchars($admin['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($admin['email'] ?? ''); ?></td>
                            <td><?php echo $admin['permissions_count']; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($admin['created_at'])); ?></td>
                            <td>
                                <?php if ($admin['id'] != 1): ?>
                                <button class="btn btn-primary btn-sm" onclick="editAdmin(<?php echo $admin['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="post" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المدير؟')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal for Adding/Editing Admin -->
<div class="modal" id="adminModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">إضافة مدير جديد</h2>
            <button type="button" class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form id="admin-form" method="post">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="username">اسم المستخدم</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="full_name">الاسم الكامل</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label>الصلاحيات</label>
                <div class="permissions-container">
                    <label class="checkbox-container">
                        <input type="checkbox" name="permissions[]" value="manage_agencies">
                        إدارة الوكالات
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="permissions[]" value="manage_pilgrims">
                        إدارة المعتمرين
                    </label>
                    <label class="checkbox-container">
                        <input type="checkbox" name="permissions[]" value="manage_offers">
                        إدارة العروض
                    </label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script>
// تنشيط السايدبار وإدارة الصفحات
document.addEventListener('DOMContentLoaded', function() {
    // إظهار رسائل النجاح والخطأ
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    });
});

// إدارة المودال
function openModal(id) {
    document.getElementById(id).classList.add('show');
}

function closeModal() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.classList.remove('show');
    });
}

// تعديل المدير
function editAdmin(id) {
    // تحويل المستخدم إلى صفحة التعديل
    window.location.href = `edit.php?id=${id}`;
}

// إغلاق المودال عند النقر خارجه
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        closeModal();
    }
}
</script>

    <?php require_once __DIR__ . '/../../template/footer.php'; ?>
</body>
</html>