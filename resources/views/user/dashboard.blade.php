<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay eBudget Transparency</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            position: relative;
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            border: 3px solid #ffd700;
        }

        .brgy-logo i.fa-house {
            color: #16a34a;
            font-size: 1.8rem;
        }

        .brgy-logo i.fa-users {
            position: absolute;
            color: #15803d;
            font-size: 0.6rem;
            bottom: 18px;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 0.5px;
            color: white;
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
            object-fit: cover;
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
            display: flex;
            align-items: center;
            gap: 8px;
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

        #profile-dropdown button[type="submit"] {
            color: #dc2626;
        }

        #profile-dropdown button[type="submit"]:hover {
            background: #fee2e2;
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

        /* Expenditure Cards (Mobile) */
        .expenditure-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            background: #f9fafb;
        }

        .expenditure-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .expenditure-barangay {
            font-weight: 600;
            color: #374151;
        }

        .expenditure-amount {
            color: #ea580c;
            font-weight: 700;
        }

        .expenditure-category {
            display: inline-flex;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
        }

        .expenditure-category.infrastructure {
            background: #dbeafe;
            color: #1e40af;
        }

        .expenditure-category.education {
            background: #dcfce7;
            color: #166534;
        }

        .expenditure-category.healthcare {
            background: #fee2e2;
            color: #991b1b;
        }

        .expenditure-category.public-safety {
            background: #fef3c7;
            color: #92400e;
        }

        .expenditure-category.utilities {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .expenditure-category.other {
            background: #f3f4f6;
            color: #1f2937;
        }

        .expenditure-title {
            color: #1f2937;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .expenditure-date {
            color: #6b7280;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 4px;
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
        @media (max-width: 1024px) {
            .desktop-table {
                display: none;
            }
            .mobile-cards {
                display: block;
            }
        }

        @media (min-width: 1025px) {
            .desktop-table {
                display: block;
            }
            .mobile-cards {
                display: none;
            }
        }

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
            }

            .brgy-logo i.fa-house {
                font-size: 1.5rem;
            }

            .brgy-logo i.fa-users {
                font-size: 0.5rem;
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
        <div class="header-container">
            <!-- Left side: Barangay Icon + Title -->
            <div class="header-left">
                <!-- Barangay Icon (House + People inside circle) -->
                <div class="brgy-logo">
                    <i class="fa-solid fa-house"></i>
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>
                    <h1>Barangay eBudget Transparency</h1>
                </div>
            </div>

            <!-- Right side: Profile -->
            <div class="profile-wrapper">
                <button id="profile-button">
                    <img src="{{ $user->profile_photo && file_exists(public_path('profile_photos/' . $user->profile_photo)) 
                                 ? asset('profile_photos/' . $user->profile_photo) 
                                 : asset('images/default-avatar.png') }}" 
                         alt="{{ $user->full_name }}">
                </button>

                <!-- Dropdown -->
                <div id="profile-dropdown">
                    <!-- Feedback Button -->
                    <a href="{{ route('user.feedback.index') }}">
                        <i class="fa-solid fa-comment-dots"></i>
                        Feedback
                    </a>

                    <a href="{{ route('user.profile.edit') }}">
                        <i class="fa-solid fa-user"></i>
                        Profile
                    </a>

                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

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

        <!-- Expenditures Section -->
        <section>
            <h2>💳 Expenditures</h2>
            <div class="ph-accent"></div>
            
            <!-- Desktop Table -->
            <div class="desktop-table">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>CATEGORY</th>
                                <th>DETAILS</th>
                                <th>AMOUNT (₱)</th>
                                <th>DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenditures as $exp)
                            <tr class="{{ session('new_expenditure_id') == $exp->id ? 'bg-green-50 border-l-4 border-green-500' : '' }}">
                                <td>
                                    <span class="expenditure-category 
                                        @if($exp->category == 'Infrastructure') infrastructure
                                        @elseif($exp->category == 'Education') education
                                        @elseif($exp->category == 'Healthcare') healthcare
                                        @elseif($exp->category == 'Public Safety') public-safety
                                        @elseif($exp->category == 'Utilities') utilities
                                        @else other
                                        @endif">
                                        {{ $exp->category ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ $exp->title }}</td>
                                <td style="color: #ea580c; font-weight: 700;">₱{{ number_format($exp->amount, 2) }}</td>
                                <td>{{ $exp->date ? \Carbon\Carbon::parse($exp->date)->format('M d, Y') : ($exp->created_at ? $exp->created_at->format('M d, Y') : 'N/A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                                    <div style="font-size: 3rem; margin-bottom: 15px;">📊</div>
                                    <div style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">No expenditures found</div>
                                    <div style="font-size: 0.875rem;">Check back later for updates</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Cards -->
            <div class="mobile-cards" style="display: none;">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @forelse($expenditures as $exp)
                    <div class="expenditure-card">
                        <div class="expenditure-card-header">
                            <span class="expenditure-barangay">{{ $exp->barangay ?? 'N/A' }}</span>
                            <span class="expenditure-amount">₱{{ number_format($exp->amount, 2) }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                            <span class="expenditure-category 
                                @if($exp->category == 'Infrastructure') infrastructure
                                @elseif($exp->category == 'Education') education
                                @elseif($exp->category == 'Healthcare') healthcare
                                @elseif($exp->category == 'Public Safety') public-safety
                                @elseif($exp->category == 'Utilities') utilities
                                @else other
                                @endif">
                                {{ $exp->category ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="expenditure-title">{{ $exp->title }}</div>
                        <div class="expenditure-date">
                            <svg style="width: 16px; height: 16px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $exp->date ? \Carbon\Carbon::parse($exp->date)->format('M d, Y') : ($exp->created_at ? $exp->created_at->format('M d, Y') : 'N/A') }}
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
                        <div style="font-size: 3rem; margin-bottom: 15px;">📊</div>
                        <div style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px;">No expenditures found</div>
                        <div style="font-size: 0.875rem;">Check back later for updates</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Data from Laravel
        const budgetChart = @json($budgetChart ?? ['labels' => [], 'data' => []]);
        const totalBudget = {{ $totalBudget ?? 0 }};
        const totalSpent = {{ $totalSpent ?? 0 }};
        const totalRemaining = {{ $totalRemaining ?? 0 }};

        // Budget Overview Chart (Doughnut)
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

        // Category Chart (Bar)
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

        // Function to update budget charts
        function updateBudgetCharts(newTotalBudget, newTotalSpent, newTotalRemaining) {
            budgetOverviewChart.data.datasets[0].data = [newTotalSpent, newTotalRemaining];
            budgetOverviewChart.update();
        }

        // Logout confirmation
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                document.getElementById('logout-form').submit();
            }
        }

        // Profile dropdown functionality
        const profileButton = document.getElementById('profile-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (profileButton && profileDropdown) {
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
        }

        // Feedback modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('feedback-modal');
            const openBtn = document.getElementById('open-feedback-modal');
            const closeBtn = document.getElementById('close-feedback-modal');
            const cancelBtn = document.getElementById('cancel-feedback');
            const form = document.getElementById('feedback-form');
            const messagesDiv = document.getElementById('feedback-messages');

            // Open modal
            if (openBtn) {
                openBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                    loadUserFeedbacks();
                });
            }

            // Close modal function
            function closeModal() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
                if (form) form.reset();
                if (messagesDiv) messagesDiv.style.display = 'none';
            }

            // Close button
            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            // Cancel button
            if (cancelBtn) {
                cancelBtn.addEventListener('click', closeModal);
            }

            // Click outside to close
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
            }

            // Form submission
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = document.getElementById('submit-feedback-btn');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Submitting...';
                    }
                });
            }
        });

        // Load user feedbacks function (placeholder)
        function loadUserFeedbacks() {
            const displayDiv = document.getElementById('user-feedback-display');
            if (displayDiv) {
                // This would typically make an AJAX call to load feedbacks
                // For now, keeping the loading message
                displayDiv.innerHTML = '<p style="color: #757575; font-style: italic;">Loading your feedback...</p>';
            }
        }

        // Handle window resize for responsive behavior
        function handleResize() {
            const width = window.innerWidth;
            const desktopTable = document.querySelector('.desktop-table');
            const mobileCards = document.querySelector('.mobile-cards');
            
            if (desktopTable && mobileCards) {
                if (width <= 1024) {
                    desktopTable.style.display = 'none';
                    mobileCards.style.display = 'block';
                } else {
                    desktopTable.style.display = 'block';
                    mobileCards.style.display = 'none';
                }
            }
        }

        // Call on load and resize
        window.addEventListener('load', handleResize);
        window.addEventListener('resize', handleResize);

        // Highlight new expenditure row (if present)
        document.addEventListener('DOMContentLoaded', function() {
            const highlightedRows = document.querySelectorAll('tr.bg-green-50');
            if (highlightedRows.length > 0) {
                highlightedRows[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Remove highlight after 5 seconds
                setTimeout(function() {
                    highlightedRows.forEach(row => {
                        row.classList.remove('bg-green-50', 'border-l-4', 'border-green-500');
                    });
                }, 5000);
            }
        });
    </script>
</body>
</html>