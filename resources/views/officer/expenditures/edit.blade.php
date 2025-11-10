<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Expenditure Request | Officer Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-yellow-500 text-white px-6 py-4 shadow-md flex justify-between items-center">
        <h1 class="font-bold text-xl">Barangay eBudget Officer</h1>
        <div>
            <a href="{{ route('officer.dashboard') }}" class="mx-2 hover:underline">Dashboard</a>
            <a href="{{ route('officer.logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="mx-2 hover:underline">Logout</a>
            <form id="logout-form" action="{{ route('officer.logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Expenditure Request</h2>

            <form action="{{ route('officer.expenditures.update', $expenditure->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title', $expenditure->title) }}" required
                        class="w-full border-gray-300 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 shadow-sm p-2">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full border-gray-300 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 shadow-sm p-2">{{ old('description', $expenditure->description) }}</textarea>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Category</label>
                    <input type="text" name="category" value="{{ old('category', $expenditure->category) }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 shadow-sm p-2">
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Amount</label>
                    <input type="number" name="amount" value="{{ old('amount', $expenditure->amount) }}" required
                        class="w-full border-gray-300 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 shadow-sm p-2">
                </div>

                <!-- Receipt -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Receipt (optional)</label>
                    <input type="file" name="receipt" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    @if($expenditure->receipt)
                        <p class="text-sm text-gray-500 mt-1">
                            Current: 
                            <a href="{{ asset('storage/'.$expenditure->receipt) }}" target="_blank" class="text-yellow-600 hover:underline">View file</a>
                        </p>
                    @endif
                </div>

                <!-- Resolution -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Resolution (optional)</label>
                    <input type="file" name="resolution" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    @if($expenditure->resolution)
                        <p class="text-sm text-gray-500 mt-1">
                            Current: 
                            <a href="{{ asset('storage/'.$expenditure->resolution) }}" target="_blank" class="text-yellow-600 hover:underline">View file</a>
                        </p>
                    @endif
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-4 mt-6">
                    <a href="{{ route('officer.dashboard') }}"
                        class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold shadow transition">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 text-sm text-gray-500">
        &copy; {{ date('Y') }} Barangay eBudget Transparency System
    </footer>

</body>
</html>
