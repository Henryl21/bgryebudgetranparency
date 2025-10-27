<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay eBudget Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* === Sidebar & Effects === */
        .sidebar-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .nav-item { transition: all 0.3s ease; position: relative; }
        .nav-item:hover { transform: translateX(5px); }
        .nav-item.active { background: rgba(255, 255, 255, 0.15); border-left: 4px solid #ffffff; }
        .nav-item.active::before {
            content: ''; position: absolute; right: 0; top: 50%;
            transform: translateY(-50%); width: 0; height: 0;
            border-top: 10px solid transparent; border-bottom: 10px solid transparent;
            border-right: 10px solid #f3f4f6;
        }
        .logo-glow { text-shadow: 0 0 20px rgba(255,255,255,0.5); }
        .notification-badge {
            position: absolute; top: -2px; right: -2px;
            background: #ef4444; color: white; border-radius: 50%;
            width: 20px; height: 20px; font-size: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100% {transform: scale(1);} 50% {transform: scale(1.1);} }

        .nav-section { margin-bottom: 1rem; }
        .nav-section-title {
            color: rgba(255,255,255,0.6); font-size: 0.75rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.05em;
            padding: 0 1rem; margin-bottom: 0.5rem;
        }

        /* === Toggle Button === */
        .toggle-btn {
            position: absolute; top: 20px; right: -65px;
            background: #ffffff; border: 3px solid #667eea;
            border-radius: 50%; width: 60px; height: 50px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.3s ease; z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .toggle-btn:hover { background: #667eea; color: white; transform: scale(1.1); }
        .toggle-btn i { font-size: 20px; transition: transform 0.3s ease; }

        /* === Sidebar Animation === */
        .sidebar { width: 288px; transition: width 0.3s ease, transform 0.3s ease; }
        .sidebar.collapsed { width: 0; }

        .sidebar.collapsed .nav-section,
        .sidebar.collapsed .nav-item { display: none; }
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .nav-section-title,
        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .user-info {
            opacity: 0; visibility: hidden; transform: translateX(-20px);
        }
        .sidebar.collapsed .nav-item { justify-content: center; padding: 0 1rem; }
        .sidebar.collapsed .nav-item.active::before { display: none; }
        .sidebar.collapsed .toggle-btn i { transform: rotate(180deg); }
        .nav-text, .logo-text, .user-info { transition: all 0.3s ease; }

        /* === Tooltip for collapsed mode === */
        .tooltip {
            position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
            background: #333; color: white; padding: 8px 12px; border-radius: 6px;
            font-size: 12px; white-space: nowrap; opacity: 0; visibility: hidden;
            transition: all 0.3s ease; z-index: 1000; margin-left: 10px;
        }
        .tooltip::before {
            content: ''; position: absolute; right: 100%; top: 50%;
            transform: translateY(-50%); border: 5px solid transparent;
            border-right-color: #333;
        }
        .sidebar.collapsed .nav-item:hover .tooltip { opacity: 1; visibility: visible; }

        /* === Main Content === */
        .main-content {
            margin-left: 15px;
            transition: margin-left 0.3s ease, width 0.3s ease;
            width: calc(100% - 288px);
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: 0; width: 100%;
        }

        /* === Responsive Fixes === */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed; z-index: 50; height: 100vh;
                transform: translateX(0); box-shadow: 2px 0 10px rgba(0,0,0,0.2);
            }
            .sidebar.collapsed { transform: translateX(-100%); }
            .toggle-btn { right: -55px; top: 10px; width: 50px; height: 45px; }
            .main-content { width: 100%; margin-left: 0; }
        }
    </style>
</head>

<body class="flex bg-gray-100 min-h-screen overflow-x-hidden">

    <!-- Sidebar -->
    <aside class="sidebar sidebar-gradient shadow-2xl min-h-screen relative">
        <!-- Toggle Button -->
        <button class="toggle-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
            <i class="fas fa-bars toggle-icon"></i>
        </button>

        <!-- Logo -->
        <div class="p-6 border-b border-white border-opacity-20">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-pie text-white text-xl"></i>
                </div>
                <div class="logo-text">
                    <h1 class="text-white font-bold text-xl logo-glow">eBudget</h1>
                    <p class="text-white text-opacity-80 text-sm">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                    <i class="fas fa-tachometer-alt text-lg"></i>
                </div>
                <div class="nav-text">
                    <div class="font-medium">Dashboard</div>
                    <div class="text-xs text-white text-opacity-60">Overview & Stats</div>
                </div>
                <div class="tooltip">Dashboard</div>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Budget Management</div>
            <a href="{{ route('admin.budget.index') }}"
               class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                    <i class="fas fa-wallet text-lg"></i>
                </div>
                <div class="nav-text">
                    <div class="font-medium">Manage Budget</div>
                    <div class="text-xs text-white text-opacity-60">Budget Planning</div>
                </div>
                <div class="tooltip">Manage Budget</div>
            </a>
            <a href="{{ route('admin.expenditure.index') }}"
               class="nav-item active flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                    <i class="fas fa-receipt text-lg"></i>
                </div>
                <div class="nav-text">
                    <div class="font-medium">Expenditures</div>
                    <div class="text-xs text-white text-opacity-60">Track Expenses</div>
                </div>
                <div class="tooltip">Expenditures</div>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Administration</div>
            <a href="{{ route('admin.officers.approval') }}"
               class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 relative">
                    <i class="fas fa-user-check text-lg"></i>
                    <div class="notification-badge">3</div>
                </div>
                <div class="nav-text">
                    <div class="font-medium">Officer Approval</div>
                    <div class="text-xs text-white text-opacity-60">Approve Officers</div>
                </div>
                <div class="tooltip">Officer Approval</div>
            </a>

            <!-- Feedback Button -->
            <a href="{{ route('admin.feedback.index') }}"
               class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                    <i class="fas fa-comments text-lg"></i>
                </div>
                <div class="nav-text">
                    <div class="font-medium">Feedback</div>
                    <div class="text-xs text-white text-opacity-60">View & Rate</div>
                </div>
                <div class="tooltip">Feedback</div>
            </a>

            <a href="{{ route('admin.announcements.index') }}"
               class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                    <i class="fas fa-bullhorn text-lg"></i>
                </div>
                <div class="nav-text">
                    <div class="font-medium">Announcements</div>
                    <div class="text-xs text-white text-opacity-60">Manage Posts</div>
                </div>
                <div class="tooltip">Announcements</div>
            </a>

            <a href="{{ route('admin.barangay_settings.index') }}"
               class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                    <i class="fas fa-cogs text-lg"></i>
                </div>
                <div class="nav-text">
                    <div class="font-medium">Settings</div>
                    <div class="text-xs text-white text-opacity-60">Expenditure Reports</div>
                </div>
                <div class="tooltip">Settings</div>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content flex-1 p-6">
        @yield('content')
    </main>

    <!-- SweetAlert / Success Message -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navItems = document.querySelectorAll('.nav-item');
            const sidebar = document.querySelector('.sidebar');

            // Restore sidebar state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
            }

            // Highlight active menu
            navItems.forEach(item => {
                item.classList.remove('active');
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href.split('/').pop())) {
                    item.classList.add('active');
                }
            });

            // Auto-hide success message
            const successMessage = document.querySelector('.fixed.top-4');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transform = 'translateX(100%)';
                    setTimeout(() => successMessage.remove(), 300);
                }, 3000);
            }
        });
    </script>
</body>
</html>
