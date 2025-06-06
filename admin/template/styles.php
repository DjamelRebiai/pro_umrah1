<style>
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
}

body {
    font-family: 'Cairo', sans-serif;
    background: #f8f9fa;
    min-height: 100vh;
}

/* Sidebar Styles */
.sidebar {
    position: fixed;
    right: 0;
    top: 0;
    width: 280px;
    height: 100vh;
    background: var(--sidebar-bg);
    z-index: 1000;
    transition: all 0.3s ease;
}

.main-content {
    margin-right: 280px;
    padding: 2rem;
    transition: all 0.3s ease;
}

/* Card Styles */
.card {
    background: var(--card-bg);
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

/* Table Styles */
.table {
    margin-bottom: 0;
}

.table th {
    background: var(--primary-gradient);
    color: white;
    font-weight: 600;
    border: none;
}

/* Form Styles */
.form-control {
    border-radius: 8px;
    border: 1px solid var(--border-color);
    padding: 0.75rem 1rem;
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
    z-index: 1050;
}

.modal.show {
    display: block;
}

.modal-content {
    background: var(--card-bg);
    border-radius: 15px;
    max-width: 500px;
    margin: 2rem auto;
    padding: 2rem;
}

/* Alert Styles */
.alert {
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
    border: none;
}

.alert-success {
    background: var(--success-gradient);
    color: white;
}

.alert-danger {
    background: var(--danger-gradient);
    color: white;
}

/* Button Styles */
.btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-gradient);
    color: white;
}

.btn-danger {
    background: var(--danger-gradient);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(100%);
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .main-content {
        margin-right: 0;
        padding: 1rem;
    }
}
</style>
