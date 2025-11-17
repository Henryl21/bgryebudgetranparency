<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expenditure Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }

        /* Header Layout */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header img {
            height: 100px;
            width: 100px;
            object-fit: contain;
        }
        .header-text {
            flex: 1;
            text-align: center;
        }
        .header-text h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header-text h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }
        .header-text h4 {
            margin: 2px 0;
            font-size: 14px;
            font-weight: 500;
        }
        .header-text small {
            margin: 0;
            font-size: 10px;
        }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; font-size: 14px; }
        th { background: #f1f1f1; }
        .category-row { background: #f9f9f9; font-weight: bold; }
        .totals { margin-top: 30px; font-size: 16px; font-weight: bold; text-align: right; }
        .signature { margin-top: 80px; display: flex; justify-content: space-between; }
        .signature div { text-align: center; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <!-- Left Logo -->
        @if($settings && $settings->poblacion_logo)
            <img  src="{{ asset($settings->poblacion_logo) }}" alt="Poblacion Logo">
        @else
            <div style="width:100px; height:100px; background:#ccc;"></div>
        @endif

        <!-- Center Text -->
        <div class="header-text">
            <h4>Republic of the Philippines</h4>
            <h4>Province of Cebu</h4>
            <h4>Municipality of Madridejos</h4>
            <h3>BARANGAY {{ strtoupper($settings->barangay_name ?? 'POBLACION') }}</h3>
            <h2>OFFICE OF THE PUNONG BARANGAY</h2>
            
        </div>

        <!-- Right Logo -->
        @if($settings && $settings->barangay_logo)
              <img src="{{ asset($settings->barangay_logo) }}" alt="Barangay Logo">
        @else
            <div style="width:100px; height:100px; background:#ccc;"></div>
        @endif
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Title</th>
                <th>Amount (₱)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; $currentCategory = null; @endphp
            @foreach($expenditures as $exp)
                @if($currentCategory !== $exp->category)
                    <tr class="category-row">
                        <td colspan="6">{{ $exp->category }}</td>
                    </tr>
                    @php $currentCategory = $exp->category; @endphp
                @endif
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $exp->category }}</td>
                    <td>{{ $exp->title }}</td>
                    <td>₱{{ number_format($exp->amount, 2) }}</td>
                    <td>{{ $exp->date ? \Carbon\Carbon::parse($exp->date)->format('M d, Y') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        Total Spent: ₱{{ number_format($totalSpent, 2) }}
    </div>

    <!-- Signatures -->
    <div class="signature">
        <div>
            ___________________________<br>
            Prepared By
        </div>
        <div>
            ___________________________<br>
            Barangay Captain
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.location.href = "{{ url()->previous() }}#expenditures";
            };
        };
    </script>

</body>
</html>
