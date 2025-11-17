<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay eBudget Transparency</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #1e5799 0%, #2989d8 50%, #7db9e8 100%);
            min-height: 100vh;
            padding-bottom: 30px;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #3949ab 100%);
            color: white;
            padding: 15px 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            border-bottom: 4px solid #ffd700;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brgy-logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #1a237e;
            font-size: 0.7rem;
            text-align: center;
            padding: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            border: 3px solid #ffd700;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 0.5px;
        }

        .profile-wrapper {
            position: relative;
        }

        #profile-button {
            background: white;
            border: 3px solid #ffd700;
            cursor: pointer;
            padding: 3px;
            border-radius: 50%;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        #profile-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.5);
        }

        #profile-button img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: block;
        }

        #profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 70px;
            background: white;
            border: 2px solid #1a237e;
            border-radius: 8px;
            min-width: 180px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 100;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            overflow: hidden;
        }

        #profile-dropdown.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        #profile-dropdown a,
        #profile-dropdown button {
            display: block;
            width: 100%;
            padding: 12px 16px;
            text-decoration: none;
            color: #1a237e;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s;
            font-weight: 500;
        }

        #profile-dropdown a:hover,
        #profile-dropdown button:hover {
            background: #e8eaf6;
            color: #1a237e;
        }

        /* Main */
        main {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        section {
            background: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-left: 5px solid #1a237e;
        }

        section h2 {
            color: #1a237e;
            font-size: 1.8rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #ffd700;
            font-weight: 700;
        }

        section h3 {
            color: #283593;
            font-size: 1.3rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        section h4 {
            color: #3949ab;
            font-size: 1.1rem;
            margin-bottom: 12px;
            font-weight: 600;
        }

        /* Budget Summary Cards */
        .budget-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .budget-card {
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(26, 35, 126, 0.3);
            border: 3px solid #ffd700;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .budget-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(26, 35, 126, 0.4);
        }

        .budget-card h3 {
            color: white;
            font-size: 1rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        .budget-amount {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .budget-card.spent {
            background: linear-gradient(135deg, #c62828 0%, #e53935 100%);
        }

        .budget-card.remaining {
            background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        }

        /* Filter Section */
        .filter-section {
            background: #e8eaf6;
            border-left: 5px solid #ffd700;
        }

        .filter-section h4 {
            color: #1a237e;
        }

        .filter-section ul {
            list-style: none;
            margin: 15px 0;
        }

        .filter-section li {
            padding: 8px 0;
            color: #283593;
            font-weight: 500;
        }

        .filter-section a {
            display: inline-block;
            padding: 10px 20px;
            background: #1a237e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: 600;
            transition: background 0.3s, transform 0.2s;
        }

        .filter-section a:hover {
            background: #283593;
            transform: translateX(5px);
        }

        /* Charts */
        .chart-wrapper {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }

        .chart-stats {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: #e8eaf6;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        .chart-stats strong {
            color: #1a237e;
            font-size: 1.3rem;
        }

        /* Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        table thead {
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
            color: white;
        }

        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            color: #333;
        }

        table tbody tr {
            transition: background 0.2s;
        }

        table tbody tr:hover {
            background: #e8eaf6;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Feedback Modal */
        #feedback-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(26, 35, 126, 0.7);
            z-index: 1000;
            overflow-y: auto;
            backdrop-filter: blur(3px);
        }

        #feedback-modal > div {
            background: white;
            max-width: 650px;
            margin: 50px auto;
            padding: 35px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            border: 3px solid #ffd700;
        }

        #feedback-modal h3 {
            color: #1a237e;
            font-size: 1.8rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #ffd700;
        }

        #feedback-modal h4 {
            color: #283593;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        #close-feedback-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #e53935;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: white;
            width: 40px;
            height: 40px;
            line-height: 1;
            border-radius: 50%;
            transition: background 0.2s, transform 0.2s;
        }

        #close-feedback-modal:hover {
            background: #c62828;
            transform: rotate(90deg);
        }

        #feedback-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1a237e;
        }

        #feedback-form textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.3s;
        }

        #feedback-form textarea:focus {
            outline: none;
            border-color: #1a237e;
        }

        #feedback-form button {
            padding: 12px 25px;
            margin-top: 15px;
            margin-right: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.3s, transform 0.2s;
        }

        #submit-feedback-btn {
            background: #2e7d32;
            color: white;
        }

        #submit-feedback-btn:hover {
            background: #1b5e20;
            transform: translateY(-2px);
        }

        #cancel-feedback {
            background: #757575;
            color: white;
        }

        #cancel-feedback:hover {
            background: #616161;
            transform: translateY(-2px);
        }

        #feedback-messages {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Success Message */
        .success-message {
            background: #c8e6c9;
            color: #1b5e20;
            padding: 15px;
            border: 2px solid #81c784;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        /* Philippine Flag Accent */
        .ph-accent {
            height: 5px;
            background: linear-gradient(to right, #0038a8 0%, #0038a8 50%, #ce1126 50%, #ce1126 100%);
            margin-bottom: 20px;
            border-radius: 3px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                padding: 12px 15px;
            }

            .header-container {
                justify-content: center;
            }

            .header-left {
                width: 100%;
                justify-content: center;
                text-align: center;
            }

            .brgy-logo {
                width: 50px;
                height: 50px;
                font-size: 0.6rem;
            }

            header h1 {
                font-size: 1.3rem;
            }

            main {
                padding: 0 15px;
                margin: 20px auto;
            }

            section {
                padding: 20px 15px;
            }

            section h2 {
                font-size: 1.5rem;
            }

            .budget-summary {
                grid-template-columns: 1fr;
            }

            .budget-amount {
                font-size: 1.7rem;
            }

            .chart-wrapper {
                max-width: 100%;
                padding: 15px;
            }

            #profile-button img {
                width: 40px;
                height: 40px;
            }

            #feedback-modal > div {
                margin: 20px;
                padding: 25px 20px;
            }

            table th,
            table td {
                padding: 10px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            header h1 {
                font-size: 1.1rem;
            }

            .brgy-logo {
                width: 45px;
                height: 45px;
            }

            section h2 {
                font-size: 1.3rem;
            }

            section h3 {
                font-size: 1.1rem;
            }

            .budget-amount {
                font-size: 1.5rem;
            }

            #feedback-form button {
                width: 100%;
                margin-right: 0;
                margin-bottom: 10px;
            }

            .filter-section a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
<header>
    <div class="header-container flex items-center justify-between p-4 bg-white shadow">
        <!-- Left side: Barangay Icon + Title -->
        <div class="header-left flex items-center gap-4">
            <!-- Barangay Icon (House + People inside circle) -->
            <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-green-100 border-2 border-green-500 shadow-md">
                <i class="fa-solid fa-house text-green-600 text-3xl"></i>
                <i class="fa-solid fa-users absolute text-green-800 text-xs translate-y-3"></i>
            </div>

            <div class="flex flex-col">
               
                <h1 class="text-3xl font-bold text-gray-800 leading-tight">Barangay eBudget Transparency</h1>
            </div>
        </div>

        <!-- Right side: Profile -->
      <div class="profile-wrapper relative">
    <button id="profile-button" class="flex items-center focus:outline-none group">
        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/default-avatar.png') }}" 
             alt="{{ $user->full_name }}" 
             class="w-12 h-12 rounded-full object-cover border-2 border-green-400 shadow-md transition-transform transform hover:scale-110">
    </button>

    <!-- Dropdown -->
    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">

    <!-- ⭐ Feedback Button -->
<a href="{{ route('user.feedback.index') }}"
   class="w-full text-left px-4 py-2 text-blue-700 font-medium hover:bg-blue-100 rounded-lg 
          transition flex items-center gap-2">
    <i class="fa-solid fa-comment-dots text-blue-600"></i>
    Feedback
</a>

        <a href="{{ route('user.profile.edit') }}" 
           class="block px-4 py-2 text-gray-700 hover:bg-green-100 rounded-lg transition">
            Profile
        </a>

        <form action="{{ route('user.logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg transition">
                Logout
            </button>
        </form>
    </div>
</div>

</header>

<!-- Font Awesome CDN -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


    <!-- Feedback Modal -->
    <div id="feedback-modal">
        <div>
            <button id="close-feedback-modal">×</button>
            <h3>Feedback</h3>
            <div class="ph-accent"></div>

            <div>
                <h4>Submit Your Feedback</h4>
                <div id="feedback-messages" style="display: none;"></div>
                <form id="feedback-form" action="{{ route('user.feedback.store') }}" method="POST">
                    @csrf
                    <label for="feedback-message">Your Feedback:</label>
                    <textarea id="feedback-message" name="message" rows="5" placeholder="Share your thoughts..." required>{{ old('message') }}</textarea>
                    <br>
                    <button id="cancel-feedback" type="button">Cancel</button>
                    <button id="submit-feedback-btn" type="submit">Submit</button>
                </form>
            </div>

            <div style="margin-top: 30px;">
                <h4>Recent Feedback</h4>
                <div id="user-feedback-display">
                    <p>Loading your feedback...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main -->
    <main>
        @if (request('month') || request('year') || request('category'))
            <section class="filter-section">
                <h4>Active Filters:</h4>
                <ul>
                    @if (request('month'))
                        <li>📅 Month: {{ \Carbon\Carbon::create()->month(request('month'))->format('F') }}</li>
                    @endif
                    @if (request('year'))
                        <li>📆 Year: {{ request('year') }}</li>
                    @endif
                    @if (request('category'))
                        <li>🏷️ Category: {{ request('category') }}</li>
                    @endif
                </ul>
                <a href="{{ route('admin.dashboard') }}">🗑️ Clear All Filters</a>
            </section>
        @endif

        <!-- Budget Summary -->
        <div class="budget-summary">
            <div class="budget-card">
                <h3>💰 Total Budget</h3>
                <div class="budget-amount">₱{{ number_format($totalBudget, 2) }}</div>
            </div>
            <div class="budget-card spent">
                <h3>💸 Total Spent</h3>
                <div class="budget-amount">₱{{ number_format($totalSpent, 2) }}</div>
            </div>
            <div class="budget-card remaining">
                <h3>💵 Remaining</h3>
                <div class="budget-amount">₱{{ number_format($totalRemaining, 2) }}</div>
            </div>
        </div>

        <!-- Charts -->
        <section>
            <h3>📊 Budget Overview</h3>
            <div class="ph-accent"></div>
            <div class="chart-wrapper">
                <canvas id="budgetOverviewChart"></canvas>
            </div>
            <p class="chart-stats">
                Total Spent: <strong id="spentPercentage">{{ $totalBudget > 0 ? number_format(($totalSpent / $totalBudget) * 100, 1) : 0 }}%</strong> | 
                Remaining: <strong id="remainingPercentage">{{ $totalBudget > 0 ? number_format(($totalRemaining / $totalBudget) * 100, 1) : 0 }}%</strong>
            </p>
        </section>

        <section>
            <h3>📈 Spending by Category</h3>
            <div class="ph-accent"></div>
            <div class="chart-wrapper">
                <canvas id="categoryChart"></canvas>
            </div>
        </section>

        <!-- Announcements -->
        <section>
            <h2>📢 Announcements</h2>
            <div class="ph-accent"></div>
            @if (session('success'))
                <div class="success-message">✅ {{ session('success') }}</div>
            @endif

            @if ($announcements && $announcements->count())
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Date Posted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($announcements as $announcement)
                                <tr>
                                    <td><strong>{{ $announcement->title }}</strong></td>
                                    <td>{!! nl2br(e($announcement->content)) !!}</td>
                                    <td>{{ $announcement->published_at ? $announcement->published_at->format('F j, Y') : $announcement->created_at->format('F j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color: #757575; font-style: italic;">No announcements yet.</p>
            @endif
        </section>
    </main>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        const budgetChart = @json($budgetChart ?? ['labels' => [], 'data' => []]);
        const totalBudget = {{ $totalBudget ?? 0 }};
        const totalSpent = {{ $totalSpent ?? 0 }};
        const totalRemaining = {{ $totalRemaining ?? 0 }};

        const budgetOverviewChart = new Chart(document.getElementById('budgetOverviewChart'), {
            type: 'doughnut',
            data: {
                labels: ['Total Spent', 'Remaining Budget'],
                datasets: [{
                    data: [totalSpent, totalRemaining > 0 ? totalRemaining : 0],
                    backgroundColor: ['#e53935', '#43a047'],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: { 
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: 15
                        }
                    }
                }
            }
        });

        if (budgetChart.labels && budgetChart.labels.length > 0) {
            const categoryChart = new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: budgetChart.labels,
                    datasets: [{ 
                        label: 'Amount (₱)', 
                        data: budgetChart.data, 
                        backgroundColor: '#1a237e',
                        borderColor: '#ffd700',
                        borderWidth: 2
                    }]
                },
                options: { 
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        }

        function updateBudgetCharts(newTotalBudget, newTotalSpent, newTotalRemaining) {
            budgetOverviewChart.data.datasets[0].data = [newTotalSpent, newTotalRemaining];
            budgetOverviewChart.update();
        }

        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout-form').submit();
            }
        }

        // Profile dropdown with animation effect
        const profileButton = document.getElementById('profile-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('show');
            }
        });

        // Feedback modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('feedback-modal');
            const openBtn = document.getElementById('open-feedback-modal');
            const closeBtn = document.getElementById('close-feedback-modal');
            const cancelBtn = document.getElementById('cancel-feedback');
            const form = document.getElementById('feedback-form');
            const messagesDiv = document.getElementById('feedback-messages');

            if (openBtn) {
                openBtn.addEventListener('click', function() {
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                    loadUserFeedbacks();
                });
            }

            function closeModal() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
                form.reset();
                messagesDiv.style.display = 'none';
            }

            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });
        });

        function loadUserFeedbacks() {
            // Placeholder function - implement your feedback loading logic
        }
    </script>
</body>
</html>