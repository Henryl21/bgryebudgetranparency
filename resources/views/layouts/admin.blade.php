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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
        }

        /* === Sidebar & Effects === */
        .sidebar-gradient { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        }
        
        .nav-item { 
            transition: all 0.3s ease; 
            position: relative; 
        }
        
        .nav-item:hover { 
            transform: translateX(5px); 
        }
        
        .nav-item.active { 
            background: rgba(255, 255, 255, 0.15); 
            border-left: 4px solid #ffffff; 
        }
        
        .nav-item.active::before {
            content: ''; 
            position: absolute; 
            right: 0; 
            top: 50%;
            transform: translateY(-50%); 
            width: 0; 
            height: 0;
            border-top: 10px solid transparent; 
            border-bottom: 10px solid transparent;
            border-right: 10px solid #f3f4f6;
        }
        
        .logo-glow { 
            text-shadow: 0 0 20px rgba(255,255,255,0.5); 
        }
        
        .notification-badge {
            position: absolute; 
            top: -2px; 
            right: -2px;
            background: #ef4444; 
            color: white; 
            border-radius: 50%;
            width: 20px; 
            height: 20px; 
            font-size: 10px;
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-weight: bold; 
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse { 
            0%, 100% { transform: scale(1); } 
            50% { transform: scale(1.1); } 
        }

        .nav-section { 
            margin-bottom: 1rem; 
        }
        
        .nav-section-title {
            color: rgba(255,255,255,0.6); 
            font-size: 0.75rem; 
            font-weight: 600;
            text-transform: uppercase; 
            letter-spacing: 0.05em;
            padding: 0 1rem; 
            margin-bottom: 0.5rem;
        }

        /* === Toggle Button === */
        .toggle-btn {
            position: fixed;
            top: 20px;
            left: 10px;
            background: #ffffff;
            border: 3px solid #667eea;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1001;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .toggle-btn:hover { 
            background: #667eea; 
            color: white; 
            transform: scale(1.1); 
        }
        
        .toggle-btn i { 
            font-size: 20px; 
            transition: transform 0.3s ease; 
        }

        /* Drag effect when moving */
        .toggle-btn.dragging {
            opacity: 0.8;
            cursor: grabbing;
            transition: none !important;
        }

        /* === Sidebar === */
        .sidebar { 
            position: fixed;
            left: 0;
            top: 0;
            width: 288px;
            height: 100vh;
            transition: transform 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .sidebar.collapsed { 
            transform: translateX(-288px);
        }

        .sidebar.collapsed ~ .toggle-btn {
            left: 20px;
        }

        .sidebar.collapsed ~ .toggle-btn i { 
            transform: rotate(180deg); 
        }

        /* === Main Content === */
        .main-content {
            margin-left: 288px;
            padding: 2rem;
            width: calc(100% - 288px);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed ~ .main-content {
            margin-left: 0;
            width: 100%;
        }

        /* === Overlay for mobile === */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* === Success Message === */
        .success-message {
            transition: all 0.3s ease;
        }

        /* === Responsive === */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-288px);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar.mobile-open ~ .toggle-btn {
                left: 270px;
            }

            .toggle-btn {
                left: 20px;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .toggle-btn {
                width: 45px;
                height: 45px;
                top: 15px;
            }

            .toggle-btn i {
                font-size: 18px;
            }

            .main-content {
                padding: 1rem;
                padding-top: 5rem;
            }

            .nav-item {
                padding: 0.75rem 1rem !important;
            }

            .nav-section-title {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 260px;
            }

            .sidebar.mobile-open ~ .toggle-btn {
                left: 242px;
            }

            .sidebar.collapsed ~ .toggle-btn {
                left: 20px;
            }

            .toggle-btn {
                width: 40px;
                height: 40px;
            }

            .main-content {
                padding: 0.75rem;
                padding-top: 4.5rem;
            }
        }

        /* Desktop specific - show sidebar by default */
        @media (min-width: 1025px) {
            .sidebar {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Toggle Button -->
    <button class="toggle-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
        <i class="fas fa-bars toggle-icon"></i>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar sidebar-gradient shadow-2xl">
        <div class="p-6 border-b border-white border-opacity-20">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-pie text-white text-xl"></i>
                </div>
                <div class="logo-text">
                    <h1 class="text-white font-bold text-xl logo-glow">eBudget</h1>
                    <p class="text-white text-opacity-80 text-sm">Admin Panel</p>
                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-tachometer-alt text-lg"></i>
                    </div>
                    <div class="nav-text">
                        <div class="font-medium">Dashboard</div>
                        <div class="text-xs text-white text-opacity-60">Overview & Stats</div>
                    </div>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Budget Management</div>
                <a href="{{ route('admin.budget.index') }}" class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    <div class="nav-text">
                        <div class="font-medium">Manage Budget</div>
                        <div class="text-xs text-white text-opacity-60">Budget Planning</div>
                    </div>
                </a>
                <a href="{{ route('admin.expenditure.index') }}" class="nav-item active flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-receipt text-lg"></i>
                    </div>
                    <div class="nav-text">
                        <div class="font-medium">Expenditures</div>
                        <div class="text-xs text-white text-opacity-60">Track Expenses</div>
                    </div>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Administration</div>
                <a href="{{ route('admin.officers.approval') }}" class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 relative flex-shrink-0">
        <i class="fas fa-user-check text-lg"></i>
    
    </div>
    <div class="nav-text">
        <div class="font-medium">Officer Approval</div>
        <div class="text-xs text-white text-opacity-60">Approve Officers</div>
    </div>
</a>

                <a href="{{ route('admin.feedback.index') }}" class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-comments text-lg"></i>
                    </div>
                    <div class="nav-text">
                        <div class="font-medium">Feedback</div>
                        <div class="text-xs text-white text-opacity-60">View & Rate</div>
                    </div>
                </a>

                <a href="{{ route('admin.announcements.index') }}" class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-bullhorn text-lg"></i>
                    </div>
                    <div class="nav-text">
                        <div class="font-medium">Announcements</div>
                        <div class="text-xs text-white text-opacity-60">Manage Posts</div>
                    </div>
                </a>

                <a href="{{ route('admin.barangay_settings.index') }}" class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 flex-shrink-0">
                        <i class="fas fa-cogs text-lg"></i>
                    </div>
                    <div class="nav-text">
                        <div class="font-medium">Settings</div>
                        <div class="text-xs text-white text-opacity-60">Expenditure Reports</div>
                    </div>
                </a>
            </div>
        
<!-- Add this inside your Administration section in the sidebar, after the Settings link -->

<a href="{{ route('admin.users_officers.index') }}"
class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 flex-shrink-0">
        <i class="fas fa-users text-lg"></i>
    </div>
    <div class="nav-text">
        <div class="font-medium">Activity Logs</div>
        <div class="text-xs text-white text-opacity-60">User/officers Management</div>
    </div>
</a>
<a href="{{ route('admin.database') }}" 
   class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white 
          hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group mt-2">
    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center 
                justify-center group-hover:bg-opacity-30 transition-all duration-300 flex-shrink-0">
        <i class="fas fa-database text-lg"></i>
    </div>
    <div class="nav-text">
        <div class="font-medium">Database</div>
        <div class="text-xs text-white text-opacity-60">Backup & Export</div>
    </div>
</a>

        </div>
        
    </aside>

    <main class="main-content">
        @yield('content')
    </main>

    @if (session('success'))
        <div class="success-message fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const isMobile = window.innerWidth <= 1024;

            if (isMobile) {
                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        }

        function handleResize() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const isMobile = window.innerWidth <= 1024;

            if (!isMobile) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                const wasCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (wasCollapsed) sidebar.classList.add('collapsed');
                else sidebar.classList.remove('collapsed');
            } else {
                sidebar.classList.remove('collapsed', 'mobile-open');
                overlay.classList.remove('active');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navItems = document.querySelectorAll('.nav-item');
            handleResize();

            navItems.forEach(item => {
                item.classList.remove('active');
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href.split('/').pop())) item.classList.add('active');
            });

            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 1024) {
                        document.querySelector('.sidebar').classList.remove('mobile-open');
                        document.querySelector('.sidebar-overlay').classList.remove('active');
                    }
                });
            });

            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transform = 'translateX(100%)';
                    setTimeout(() => successMessage.remove(), 300);
                }, 3000);
            }
        });

        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(handleResize, 250);
        });

        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.toggle-btn');
            const isMobile = window.innerWidth <= 1024;

            if (isMobile && 
                sidebar.classList.contains('mobile-open') &&
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target)) {
                toggleSidebar();
            }
        });

        // === Make Toggle Button Draggable ===
        (function makeToggleMovable() {
            const toggleBtn = document.querySelector('.toggle-btn');
            let offsetX, offsetY, isDragging = false;

            toggleBtn.addEventListener('mousedown', startDrag);
            document.addEventListener('mousemove', drag);
            document.addEventListener('mouseup', stopDrag);

            toggleBtn.addEventListener('touchstart', startDrag, { passive: false });
            document.addEventListener('touchmove', drag, { passive: false });
            document.addEventListener('touchend', stopDrag);

            function startDrag(e) {
                e.preventDefault();
                isDragging = true;
                toggleBtn.classList.add('dragging');
                const rect = toggleBtn.getBoundingClientRect();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                offsetX = clientX - rect.left;
                offsetY = clientY - rect.top;
            }

            function drag(e) {
                if (!isDragging) return;
                e.preventDefault();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                const x = clientX - offsetX;
                const y = clientY - offsetY;

                const maxX = window.innerWidth - toggleBtn.offsetWidth;
                const maxY = window.innerHeight - toggleBtn.offsetHeight;
                toggleBtn.style.left = Math.min(Math.max(0, x), maxX) + 'px';
                toggleBtn.style.top = Math.min(Math.max(0, y), maxY) + 'px';
            }

            function stopDrag() {
                if (isDragging) {
                    isDragging = false;
                    toggleBtn.classList.remove('dragging');
                }
            }
        })();
    </script>
</body>
</html>
