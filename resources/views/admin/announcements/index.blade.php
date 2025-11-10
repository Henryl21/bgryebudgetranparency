@extends('layouts.admin')
@section('title', 'Announcements')
@section('content')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(139, 92, 246, 0);
        }
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .announcement-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 200px);
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }
    
    .announcement-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        pointer-events: none;
    }
    
    .content-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    
    .announcement-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px;
        gap: 15px;
        flex-wrap: wrap;
        animation: fadeInUp 0.6s ease-out;
    }
    
    .header-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .announcement-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ff6b6b, #feca57);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        box-shadow: 0 8px 32px rgba(255, 107, 107, 0.4);
        animation: float 3s ease-in-out infinite;
        position: relative;
    }
    
    .announcement-icon::after {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(135deg, #ff6b6b, #feca57);
        border-radius: 20px;
        z-index: -1;
        filter: blur(10px);
        opacity: 0.6;
    }
    
    .announcement-title {
        font-size: 32px;
        font-weight: 800;
        color: white;
        margin: 0;
        text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
        letter-spacing: -0.5px;
    }
    
    .btn-new {
        background: linear-gradient(135deg, #00d2ff, #3a47d5);
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 24px rgba(0, 210, 255, 0.4);
        position: relative;
        overflow: hidden;
    }
    
    .btn-new::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }
    
    .btn-new:hover::before {
        left: 100%;
    }
    
    .btn-new:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 32px rgba(0, 210, 255, 0.6);
    }
    
    .table-header {
        display: grid;
        grid-template-columns: 70px 1fr 2fr 200px 140px;
        gap: 20px;
        padding: 20px 25px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px 16px 0 0;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #667eea;
        margin-bottom: 2px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        animation: fadeInUp 0.7s ease-out;
    }
    
    .announcements-list {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 0 0 16px 16px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15);
    }
    
    .announcement-item {
        display: grid;
        grid-template-columns: 70px 1fr 2fr 200px 140px;
        gap: 20px;
        padding: 25px;
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        align-items: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        animation: slideIn 0.5s ease-out;
        animation-fill-mode: both;
    }
    
    .announcement-item:nth-child(1) { animation-delay: 0.1s; }
    .announcement-item:nth-child(2) { animation-delay: 0.15s; }
    .announcement-item:nth-child(3) { animation-delay: 0.2s; }
    .announcement-item:nth-child(4) { animation-delay: 0.25s; }
    .announcement-item:nth-child(5) { animation-delay: 0.3s; }
    
    .announcement-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 0;
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.1), transparent);
        transition: width 0.3s ease;
    }
    
    .announcement-item:last-child {
        border-bottom: none;
    }
    
    .announcement-item:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.05), transparent);
        transform: translateX(10px);
    }
    
    .announcement-item:hover::before {
        width: 100%;
    }
    
    .number-badge {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 16px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .announcement-item:hover .number-badge {
        transform: rotate(360deg) scale(1.1);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }
    
    .announcement-title-text {
        font-weight: 700;
        color: #1f2937;
        font-size: 16px;
        line-height: 1.4;
        transition: color 0.3s ease;
    }
    
    .announcement-item:hover .announcement-title-text {
        color: #667eea;
    }
    
    .announcement-content {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.6;
    }
    
    .announcement-date {
        color: #9ca3af;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .btn-edit, .btn-delete {
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .btn-edit::before,
    .btn-delete::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn-edit:hover::before,
    .btn-delete:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f093fb, #f5576c);
        color: white;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
    }
    
    .btn-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(240, 147, 251, 0.6);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #fa709a, #fee140);
        color: white;
        box-shadow: 0 4px 15px rgba(250, 112, 154, 0.4);
    }
    
    .btn-delete:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(250, 112, 154, 0.6);
    }
    
    .no-announcements {
        text-align: center;
        padding: 100px 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        color: #6b7280;
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15);
        animation: fadeInUp 0.8s ease-out;
    }
    
    .no-announcements .empty-icon {
        animation: float 3s ease-in-out infinite;
    }
    
    .no-announcements h3 {
        color: #1f2937;
        font-size: 28px;
        margin: 25px 0 15px;
        font-weight: 800;
    }
    
    .no-announcements p {
        font-size: 16px;
        margin-bottom: 35px;
        color: #9ca3af;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d4fc79, #96e6a1);
        color: #166534;
        padding: 18px 24px;
        border-radius: 14px;
        margin-bottom: 30px;
        border: 2px solid rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        gap: 15px;
        font-weight: 600;
        box-shadow: 0 4px 20px rgba(150, 230, 161, 0.4);
        animation: fadeInUp 0.5s ease-out;
        position: relative;
        overflow: hidden;
    }
    
    .alert-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }
    
    .alert-success::after {
        content: "✓";
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        border-radius: 50%;
        font-weight: bold;
        font-size: 16px;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
    }
    
    /* Mobile Cards View */
    .mobile-card {
        display: none;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        animation: slideIn 0.5s ease-out;
        animation-fill-mode: both;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .mobile-card:nth-child(1) { animation-delay: 0.1s; }
    .mobile-card:nth-child(2) { animation-delay: 0.2s; }
    .mobile-card:nth-child(3) { animation-delay: 0.3s; }
    
    .mobile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    
    .mobile-card-header {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .mobile-card-body {
        margin-bottom: 20px;
    }
    
    .mobile-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 2px solid rgba(102, 126, 234, 0.1);
    }
    
    /* Responsive Design */
    @media (max-width: 1024px) {
        .table-header {
            grid-template-columns: 60px 1fr 1.5fr 160px 120px;
            gap: 15px;
        }
        
        .announcement-item {
            grid-template-columns: 60px 1fr 1.5fr 160px 120px;
            gap: 15px;
        }
    }
    
    @media (max-width: 768px) {
        .announcement-container {
            padding: 25px 15px;
        }
        
        .announcement-title {
            font-size: 24px;
        }
        
        .announcement-icon {
            width: 50px;
            height: 50px;
            font-size: 24px;
        }
        
        .btn-new {
            padding: 12px 20px;
            font-size: 14px;
        }
        
        /* Hide desktop table view */
        .table-header,
        .announcements-list,
        .announcement-item {
            display: none !important;
        }
        
        /* Show mobile cards */
        .mobile-card {
            display: block;
        }
        
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-edit, .btn-delete {
            width: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .announcement-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .header-left {
            justify-content: center;
        }
        
        .btn-new {
            width: 100%;
            justify-content: center;
        }
        
        .announcement-title {
            font-size: 22px;
        }
        
        .no-announcements {
            padding: 60px 20px;
        }
    }
</style>

<div class="announcement-container">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="announcement-header">
            <div class="header-left">
                <div class="announcement-icon">📢</div>
                <h1 class="announcement-title">Announcements</h1>
            </div>
            <a href="{{ route('admin.announcements.create') }}" class="btn-new">
                <span>✨</span>
                <span>New Announcement</span>
            </a>
        </div>
        
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if ($announcements->count())
            <!-- Desktop Table View -->
            <div class="table-header">
                <div>#</div>
                <div>Title</div>
                <div>Content</div>
                <div>Date Posted</div>
                <div>Actions</div>
            </div>
            
            <div class="announcements-list">
                @foreach ($announcements as $index => $announcement)
                    <div class="announcement-item">
                        <div class="number-badge">{{ $index + 1 }}</div>
                        <div class="announcement-title-text">{{ $announcement->title }}</div>
                        <div class="announcement-content">{{ Str::limit($announcement->content, 100) }}</div>
                        <div class="announcement-date">
                            📅 {{ $announcement->published_at 
                                ? $announcement->published_at->format('M j, Y') 
                                : $announcement->created_at->format('M j, Y') }}
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn-edit">✏️ Edit</a>
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" 
                                  method="POST" style="display: inline;"
                                  onsubmit="return confirm('Delete this announcement?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">🗑️ Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Mobile Cards View -->
            @foreach ($announcements as $index => $announcement)
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div class="number-badge">{{ $index + 1 }}</div>
                        <div style="flex: 1;">
                            <div class="announcement-title-text" style="margin-bottom: 10px;">
                                {{ $announcement->title }}
                            </div>
                            <div class="announcement-date" style="font-size: 12px;">
                                📅 {{ $announcement->published_at 
                                    ? $announcement->published_at->format('M j, Y') 
                                    : $announcement->created_at->format('M j, Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="mobile-card-body">
                        <div class="announcement-content">
                            {{ Str::limit($announcement->content, 150) }}
                        </div>
                    </div>
                    <div class="mobile-card-footer">
                        <div class="action-buttons">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn-edit">✏️ Edit</a>
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Delete this announcement?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">🗑️ Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-announcements">
                <div class="empty-icon" style="font-size: 80px; margin-bottom: 20px;">📢</div>
                <h3>No announcements yet</h3>
                <p>Create your first announcement to get started and engage with your audience.</p>
                <a href="{{ route('admin.announcements.create') }}" class="btn-new" style="display: inline-flex;">
                    <span>✨</span>
                    <span>Create Announcement</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection