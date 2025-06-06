<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}

// التحقق من تسجيل الدخول
if (!isset($_SESSION)) {
    session_start();
}

// تحديد الصفحة الحالية
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
?>

<!-- Mobile Menu Toggle -->
<button class="mobile-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-kaaba"></i>
            منصة العمرة
        </div>
        <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem;">نظام إدارة شامل</p>
    </div>
    
    <div class="sidebar-nav">
        <a href="<?php echo BASE_URL; ?>/admin/dashboard.php" 
           class="nav-item <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i>
            الرئيسية
        </a>
        <?php if ($_SESSION['admin_id'] == 1 || isset($permissions['manage_admins'])): ?>
        <a href="<?php echo BASE_URL; ?>/admin/views/admins/index.php" 
           class="nav-item <?php echo $current_dir === 'admins' ? 'active' : ''; ?>">
            <i class="fas fa-users-cog"></i>
            المديرين
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['admin_id'] == 1 || isset($permissions['manage_agencies'])): ?>
        <a href="<?php echo BASE_URL; ?>/admin/views/agencies/index.php"
           class="nav-item <?php echo $current_dir === 'agencies' ? 'active' : ''; ?>">
            <i class="fas fa-building"></i>
            الوكالات
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['admin_id'] == 1 || isset($permissions['manage_pilgrims'])): ?>
        <a href="<?php echo BASE_URL; ?>/admin/views/pilgrims/index.php"
           class="nav-item <?php echo $current_dir === 'pilgrims' ? 'active' : ''; ?>">
            <i class="fas fa-users"></i>
            المعتمرين
        </a>
        <?php endif; ?>
        <?php if ($_SESSION['admin_id'] == 1 || isset($permissions['manage_offers'])): ?>
        <a href="<?php echo BASE_URL; ?>/admin/views/offers/index.php"
           class="nav-item <?php echo $current_dir === 'offers' ? 'active' : ''; ?>">
            <i class="fas fa-tags"></i>
            العروض والباقات
        </a>
        <?php endif; ?>
        <a href="#" class="nav-item">
            <i class="fas fa-clipboard-list"></i>
            الطلبات
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-chart-line"></i>
            التقارير
        </a>
        <a href="<?php echo BASE_URL; ?>/admin/logout.php" class="nav-item">
            <i class="fas fa-sign-out-alt"></i>
            تسجيل الخروج
        </a>
    </div>
</nav>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}

// إغلاق السايدبار عند النقر خارجه
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.mobile-toggle');
    
    if (window.innerWidth <= 768 && 
        !sidebar.contains(event.target) && 
        !toggle.contains(event.target)) {
        sidebar.classList.remove('active');
    }
});

// معالجة تغيير حجم النافذة
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        document.getElementById('sidebar').classList.remove('active');
    }
});
</script>
