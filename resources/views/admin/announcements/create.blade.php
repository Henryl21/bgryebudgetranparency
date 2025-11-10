<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }

        .container {
            max-width: 800px;
        }

        .card-wrapper {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            backdrop-filter: blur(10px);
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
        }

        .alert ul {
            margin-bottom: 0;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 18px;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-2px);
        }

        .form-control:hover {
            border-color: #a0a0a0;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
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

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-success {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #5a6268 0%, #6c757d 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(108, 117, 125, 0.4);
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .mb-3 {
            margin-bottom: 25px !important;
            animation: fadeIn 0.6s ease-out backwards;
        }

        .mb-3:nth-child(1) {
            animation-delay: 0.1s;
        }

        .mb-3:nth-child(2) {
            animation-delay: 0.2s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .input-wrapper {
            position: relative;
        }

        .char-counter {
            position: absolute;
            right: 15px;
            bottom: -25px;
            font-size: 12px;
            color: #888;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-wrapper {
                padding: 25px;
            }

            h1 {
                font-size: 24px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px 0;
            }

            .card-wrapper {
                padding: 20px;
                border-radius: 15px;
            }

            h1 {
                font-size: 20px;
            }

            .form-control {
                padding: 10px 15px;
                font-size: 14px;
            }
        }

        /* Error message styling */
        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card-wrapper">
        <h1>Create Announcement</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('admin.announcements.store') }}" method="POST" id="announcementForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" id="titleInput" class="form-control" required pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
                <div class="error-message" id="titleError">Only letters and spaces are allowed in the title</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <div class="input-wrapper">
                    <textarea name="content" id="contentInput" class="form-control" rows="4" required></textarea>
                    <span class="char-counter" id="charCounter">0 characters</span>
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-success">Save Announcement</button>
                <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Title validation (letters and spaces only)
    const titleInput = document.getElementById('titleInput');
    const titleError = document.getElementById('titleError');
    
    titleInput.addEventListener('input', function(e) {
        const value = e.target.value;
        const regex = /^[A-Za-z\s]*$/;
        
        if (!regex.test(value)) {
            titleError.classList.add('show');
            titleInput.style.borderColor = '#dc3545';
            e.target.value = value.replace(/[^A-Za-z\s]/g, '');
        } else {
            titleError.classList.remove('show');
            titleInput.style.borderColor = '#e0e0e0';
        }
    });

    // Character counter for content
    const contentInput = document.getElementById('contentInput');
    const charCounter = document.getElementById('charCounter');
    
    contentInput.addEventListener('input', function(e) {
        const length = e.target.value.length;
        charCounter.textContent = `${length} character${length !== 1 ? 's' : ''}`;
    });

    // Form validation before submit
    document.getElementById('announcementForm').addEventListener('submit', function(e) {
        const titleValue = titleInput.value.trim();
        const regex = /^[A-Za-z\s]+$/;
        
        if (!regex.test(titleValue)) {
            e.preventDefault();
            titleError.classList.add('show');
            titleInput.style.borderColor = '#dc3545';
            titleInput.focus();
        }
    });

    // Add smooth focus effects
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.01)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>