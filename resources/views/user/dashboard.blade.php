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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        /* Header Styles */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-title h1 {
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            color: #667eea;
            margin-bottom: 0.3rem;
        }

        .header-title p {
            font-size: clamp(0.8rem, 2vw, 1rem);
            color: #666;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .profile-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 3px solid #667eea;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .profile-img:hover {
            transform: scale(1.1);
        }

        button {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        button:active {
            transform: translateY(0);
        }

        #open-feedback-modal {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        button[onclick="confirmLogout()"] {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        /* Main Container */
        main {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Budget Cards */
        .budget-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .budget-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .budget-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .budget-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .budget-card h3 {
            color: #888;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .budget-card p {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 700;
            color: #667eea;
        }

        /* Charts Section */
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .chart-card h3 {
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .chart-wrapper {
            position: relative;
            height: 320px;
        }

        /* Announcements */
.announcements {
  background: white;
  padding: 2rem;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  margin-bottom: 2rem;
  overflow: hidden;
}

.announcements h2 {
  color: #333;
  margin-bottom: 1.5rem;
  font-size: 1.8rem;
  display: flex;
  align-items: center;
  gap: 10px;
}

.announcements h2 i {
  color: #764ba2;
}

/* Table Styling */
table {
  width: 100%;
  border-collapse: collapse;
  overflow-x: auto;
  display: block;
}

table thead {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

table th {
  color: white;
  padding: 1rem;
  text-align: left;
  font-weight: 600;
  white-space: nowrap;
}

table td {
  padding: 1rem;
  border-bottom: 1px solid #e0e0e0;
  color: #333;
}

table tbody tr {
  transition: background 0.3s ease;
}

table tbody tr:hover {
  background: #f5f5f5;
}

/* Desktop Fix */
@media (min-width: 768px) {
  table {
    display: table;
  }
}

/* Optional: Add gradient border background for card */
.announcements {
  border: 1px solid transparent;
  background-clip: padding-box;
  position: relative;
}

.announcements::before {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 20px;
  padding: 2px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  -webkit-mask: linear-gradient(white 0 0) content-box, linear-gradient(white 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;
  pointer-events: none;
}
    

        /* Modal */
        #feedback-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .modal-header h3 {
            font-size: 1.5rem;
            color: #333;
        }

        #close-feedback-modal {
            background: none;
            border: none;
            font-size: 2rem;
            color: #999;
            cursor: pointer;
            padding: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        #close-feedback-modal:hover {
            background: #f5f5f5;
            color: #333;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feedback-form-section, .feedback-list-section {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 15px;
        }

        .feedback-form-section h4, .feedback-list-section h4 {
            margin-bottom: 1rem;
            color: #333;
        }

        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            transition: border 0.3s ease;
            resize: vertical;
        }

        textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        #cancel-feedback {
            background: #e0e0e0;
            color: #333;
        }

        #submit-feedback-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .feedback-item {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .feedback-item:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .feedback-item p {
            color: #333;
            margin-bottom: 0.5rem;
        }

        .feedback-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
        }

        .feedback-meta small {
            color: #888;
        }

        .delete-btn {
            background: #f5576c;
            color: white;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        /* Filters */
        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .filters h4 {
            margin-bottom: 1rem;
            color: #333;
        }

        .filters ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .filters li {
            background: #667eea;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .filters a {
            background: #f5576c;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .filters a:hover {
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                padding: 1rem;
            }

            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .budget-summary {
                grid-template-columns: 1fr;
            }

            .charts-container {
                grid-template-columns: 1fr;
            }

            .modal-body {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 0.85rem;
            }

            table th, table td {
                padding: 0.5rem;
            }
        }

        /* Loading Animation */
        .loading {
            text-align: center;
            color: #888;
            padding: 2rem;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Success Message */
        .success-message {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            animation: slideDown 0.5s ease-out;
        }

        #feedback-messages {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        #feedback-messages.success {
            background: #d4edda;
            color: #155724;
        }

        #feedback-messages.error {
            background: #f8d7da;
            color: #721c24;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="header-title">
                <h1>🏛️ Barangay eBudget Transparency</h1>
                <p>Public Budget Information Portal</p>
            </div>
            
            <div class="header-actions">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->full_name }}" class="profile-img">
                <button id="open-feedback-modal">💬 Feedback</button>
                <button onclick="confirmLogout()">🚪 Logout</button>
            </div>
        </div>
    </header>

    <!-- Feedback Modal -->
    <div id="feedback-modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>💬 Feedback</h3>
                <button id="close-feedback-modal">×</button>
            </div>

            <div class="modal-body">
                <div class="feedback-form-section">
                    <h4>Submit Your Feedback</h4>
                    <div id="feedback-messages" style="display: none;"></div>
                    <form id="feedback-form" action="{{ route('user.feedback.store') }}" method="POST">
                        @csrf
                        <label for="feedback-message">Your Feedback</label>
                        <textarea id="feedback-message" name="message" rows="5" placeholder="Share your thoughts, suggestions, or report any issues..." required>{{ old('message') }}</textarea>
                        
                        <div class="form-actions">
                            <button id="cancel-feedback" type="button">Cancel</button>
                            <button id="submit-feedback-btn" type="submit">Submit Feedback</button>
                        </div>
                    </form>
                </div>

                <div class="feedback-list-section">
                    <h4>Recent Feedback</h4>
                    <div id="user-feedback-display">
                        <div class="loading">
                            <div class="spinner"></div>
                            <p>Loading your feedback...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <!-- Active Filters -->
        @if (request('month') || request('year') || request('category'))
            <section class="filters">
                <h4>🔍 Active Filters:</h4>
                <ul>
                    @if (request('month'))
                        <li>📅 Month: {{ \Carbon\Carbon::create()->month(request('month'))->format('F') }}</li>
                    @endif
                    @if (request('year'))
                        <li>📅 Year: {{ request('year') }}</li>
                    @endif
                    @if (request('category'))
                        <li>📂 Category: {{ request('category') }}</li>
                    @endif
                </ul>
                <a href="{{ route('admin.dashboard') }}">✖️ Clear All Filters</a>
            </section>
        @endif

        <!-- Budget Summary -->
        <section class="budget-summary">
            <div class="budget-card">
                <h3>💰 Total Budget</h3>
                <p>₱{{ number_format($totalBudget, 2) }}</p>
            </div>
            <div class="budget-card">
                <h3>💸 Total Spent</h3>
                <p style="color: #f5576c;">₱{{ number_format($totalSpent, 2) }}</p>
            </div>
            <div class="budget-card">
                <h3>💵 Remaining Budget</h3>
                <p style="color: {{ $totalRemaining < 0 ? '#f5576c' : '#11998e' }};">₱{{ number_format($totalRemaining, 2) }}</p>
            </div>
        </section>

        <!-- Charts -->
        <section class="charts-container">
            <div class="chart-card">
                <h3>📊 Budget Overview</h3>
                <div class="chart-wrapper">
                    <canvas id="budgetOverviewChart"></canvas>
                </div>
                <p style="text-align: center; margin-top: 1rem; color: #666;">
                    Total Spent: <strong id="spentPercentage">{{ $totalBudget > 0 ? number_format(($totalSpent / $totalBudget) * 100, 1) : 0 }}%</strong> | 
                    Remaining: <strong id="remainingPercentage">{{ $totalBudget > 0 ? number_format(($totalRemaining / $totalBudget) * 100, 1) : 0 }}%</strong>
                </p>
            </div>

            <div class="chart-card">
                <h3>📈 Spending by Category</h3>
                <div class="chart-wrapper">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </section>

        <!-- Announcements -->
        <section class="announcements">
            <h2>📢 Announcements</h2>

            @if (session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            @if ($announcements && $announcements->count())
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
                                <td>{!! nl2br(e(Str::limit($announcement->content, 100))) !!}</td>
                                <td>{{ $announcement->published_at ? $announcement->published_at->format('F j, Y') : $announcement->created_at->format('F j, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #888; padding: 2rem;">No announcements have been posted yet.</p>
            @endif
        </section>
    </main>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Data from backend
        const budgetChart = @json($budgetChart ?? ['labels' => [], 'data' => []]);
        const totalBudget = {{ $totalBudget ?? 0 }};
        const totalSpent = {{ $totalSpent ?? 0 }};
        const totalRemaining = {{ $totalRemaining ?? 0 }};

        // Budget Overview Chart
        const budgetOverviewChart = new Chart(document.getElementById('budgetOverviewChart'), {
            type: 'doughnut',
            data: {
                labels: ['Total Spent', 'Remaining Budget'],
                datasets: [{
                    data: [totalSpent, totalRemaining > 0 ? totalRemaining : 0],
                    backgroundColor: [
                        'rgba(245, 87, 108, 0.8)',
                        totalRemaining < 0 ? 'rgba(220, 38, 38, 0.8)' : 'rgba(17, 153, 142, 0.8)'
                    ],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const percentage = totalBudget > 0 ? ((value / totalBudget) * 100).toFixed(1) : 0;
                                return context.label + ': ₱' + value.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Category Chart
        if (budgetChart.labels && budgetChart.labels.length > 0) {
            const categoryChart = new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: budgetChart.labels,
                    datasets: [{
                        label: 'Amount (₱)',
                        data: budgetChart.data,
                        backgroundColor: [
                            'rgba(102, 126, 234, 0.8)',
                            'rgba(245, 87, 108, 0.8)',
                            'rgba(17, 153, 142, 0.8)',
                            'rgba(118, 75, 162, 0.8)',
                            'rgba(240, 147, 251, 0.8)',
                            'rgba(56, 239, 125, 0.8)'
                        ],
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        } else {
            document.getElementById('categoryChart').parentElement.innerHTML = '<p style="text-align: center; color: #888; padding: 2rem;">No category data available</p>';
        }

        // Update charts function
        function updateBudgetCharts(newTotalBudget, newTotalSpent, newTotalRemaining) {
            budgetOverviewChart.data.datasets[0].data = [newTotalSpent, newTotalRemaining > 0 ? newTotalRemaining : 0];
            budgetOverviewChart.update();
            
            const spentPercentage = newTotalBudget > 0 ? ((newTotalSpent / newTotalBudget) * 100).toFixed(1) : 0;
            const remainingPercentage = newTotalBudget > 0 ? ((newTotalRemaining / newTotalBudget) * 100).toFixed(1) : 0;
            
            document.getElementById('spentPercentage').textContent = spentPercentage + '%';
            document.getElementById('remainingPercentage').textContent = remainingPercentage + '%';
        }

        window.updateBudgetCharts = updateBudgetCharts;

        // Logout
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout-form').submit();
            }
        }

        // Feedback Modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('feedback-modal');
            const openBtn = document.getElementById('open-feedback-modal');
            const closeBtn = document.getElementById('close-feedback-modal');
            const cancelBtn = document.getElementById('cancel-feedback');
            const form = document.getElementById('feedback-form');
            const messagesDiv = document.getElementById('feedback-messages');

            openBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                loadUserFeedbacks();
            });

            function closeModal() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
                form.reset();
                messagesDiv.style.display = 'none';
            }

            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);

                messagesDiv.textContent = 'Submitting...';
                messagesDiv.className = '';
                messagesDiv.style.display = 'block';

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messagesDiv.textContent = data.message;
                        messagesDiv.className = 'success';
                        form.reset();
                        loadUserFeedbacks();
                        setTimeout(() => {
                            messagesDiv.style.display = 'none';
                        }, 3000);
                    } else {
                        messagesDiv.textContent = data.message || 'An error occurred';
                        messagesDiv.className = 'error';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    messagesDiv.textContent = 'An error occurred';
                    messagesDiv.className = 'error';
                });
            });
        });

        function loadUserFeedbacks() {
            const feedbackDisplay = document.getElementById('user-feedback-display');
            feedbackDisplay.innerHTML = '<div class="loading"><div class="spinner"></div><p>Loading...</p></div>';

            fetch('{{ route('user.feedback.index') }}?ajax=1', {
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            })
            .then(response => response.json())
            .then(data => {
                if (data.feedbacks && data.feedbacks.length > 0) {
                    let html = '';
                    data.feedbacks.forEach(feedback => {
                        const date = new Date(feedback.created_at).toLocaleDateString();
                        html += `
                            <div class="feedback-item">
                                <p>${feedback.message}</p>
                                <div class="feedback-meta">
                                    <small>📅 ${date}</small>
                                    <button class="delete-btn" onclick="deleteFeedback(${feedback.id})">🗑️ Delete</button>
                                </div>
                            </div>
                        `;
                    });
                    feedbackDisplay.innerHTML = html;
                } else {
                    feedbackDisplay.innerHTML = '<p style="text-align: center; color: #888; padding: 2rem;">No feedback submitted yet.</p>';
                }
            })
            .catch(error => {
                feedbackDisplay.innerHTML = '<p style="text-align: center; color: #888; padding: 2rem;">Error loading feedback</p>';
            });
        }

        function deleteFeedback(feedbackId) {
            if (confirm('Delete this feedback?')) {
                const deleteUrl = '{{ route('user.feedback.destroy', ':id') }}'.replace(':id', feedbackId);
                
                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Deleted successfully');
                        loadUserFeedbacks();
                    }
                })
                .catch(error => alert('❌ Error deleting feedback'));
            }
        }
    </script>
</body>
</html>