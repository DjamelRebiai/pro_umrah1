<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    --dark-bg: #1a1d29;
    --card-bg: #ffffff;
    --sidebar-bg: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
    --text-primary: #2d3748;
    --text-secondary: #718096;
    --border-color: #e2e8f0;
    --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-heavy: 0 20px 60px rgba(0, 0, 0, 0.15);
}

body {
    font-family: 'Cairo', sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    overflow-x: hidden;
}

/* Sidebar */
.sidebar {
    position: fixed;
    right: 0;
    top: 0;
    width: 280px;
    height: 100vh;
    background: var(--sidebar-bg);
    z-index: 1000;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-heavy);
}

.sidebar-header {
    padding: 2rem;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.logo {
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.logo i {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 2rem;
}

.sidebar-nav {
    padding: 1rem 0;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 1rem 2rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
    position: relative;
}

.nav-item:hover, .nav-item.active {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border-left-color: #667eea;
}

.nav-item i {
    margin-left: 1rem;
    font-size: 1.2rem;
    width: 20px;
}

/* Main Content */
.main-content {
    margin-right: 280px;
    padding: 2rem;
    min-height: 100vh;
}

/* Mobile Menu Toggle */
.mobile-toggle {
    display: none;
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1001;
    background: var(--primary-gradient);
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 12px;
    font-size: 1.2rem;
    cursor: pointer;
}

@media (max-width: 768px) {
    .mobile-toggle {
        display: block;
    }
    
    .sidebar {
        transform: translateX(100%);
    }

    .sidebar.active {
        transform: translateX(0);
    }

    .main-content {
        margin-right: 0;
    }
}

/* Components */
.card {
    background: var(--card-bg);
    border-radius: 20px;
    box-shadow: var(--shadow-light);
    margin-bottom: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-gradient);
    color: white;
}

.btn-success {
    background: var(--success-gradient);
    color: white;
}

.btn-danger {
    background: var(--danger-gradient);
    color: white;
}

/* Table Styles */
.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table th {
    background: var(--primary-gradient);
    color: white;
    font-weight: 600;
    padding: 1rem;
    text-align: right;
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 2000;
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 2rem;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
}

/* Alert Messages */
.alert {
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.alert-success {
    background: rgba(79, 172, 254, 0.1);
    color: #4facfe;
    border: 1px solid #4facfe;
}

.alert-danger {
    background: rgba(255, 154, 158, 0.1);
    color: #ff9a9e;
    border: 1px solid #ff9a9e;
}

/* Header Styles */
.header {
    background: var(--card-bg);
    padding: 2rem;
    border-radius: 20px;
    box-shadow: var(--shadow-light);
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    opacity: 0.05;
    z-index: 1;
}

.header-content {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.welcome-text h1 {
    color: var(--text-primary);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-text p {
    color: var(--text-secondary);
    font-size: 1rem;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-control {
    display: block;
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: var(--text-primary);
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #667eea;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Checkbox Styles */
.checkbox-container {
    display: block;
    position: relative;
    padding-right: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 0.9rem;
    user-select: none;
}

.checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkbox-container input:checked ~ .checkmark {
    background: var(--primary-gradient);
    border-color: transparent;
}

.checkbox-container .checkmark {
    position: absolute;
    top: 0;
    right: 0;
    height: 20px;
    width: 20px;
    background-color: #fff;
    border: 2px solid var(--border-color);
    border-radius: 4px;
    transition: all 0.3s ease;
}

/* Custom Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card, .header {
    animation: slideIn 0.3s ease-out forwards;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }
}
</style>
