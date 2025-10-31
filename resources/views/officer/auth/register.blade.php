<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Officer Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center min-h-screen">

  <form action="{{ route('officer.register.submit') }}" method="POST"
        class="bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-full max-w-xl border border-green-200">
    @csrf

    <!-- Header -->
    <h2 class="text-3xl font-extrabold text-center mb-6 text-green-700 tracking-wide">
      Officer Registration
    </h2>

    <!-- 👤 Personal Info -->
    <div class="mb-6">
      <h3 class="text-sm font-semibold text-green-600 mb-3 uppercase tracking-wide border-b border-green-200 pb-1">
        Personal Information
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Full Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name"
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email"
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
        </div>
      </div>
    </div>

    <!-- 🏛️ Role Info -->
    <div class="mb-6">
      <h3 class="text-sm font-semibold text-green-600 mb-3 uppercase tracking-wide border-b border-green-200 pb-1">
        Role Information
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Position -->
        <div>
          <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position (Optional)</label>
          <input type="text" id="position" name="position" placeholder="Enter your position"
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <!-- Role -->
        <div>
          <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Select Role</label>
          <select name="role" id="role"
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
            <option value="" disabled selected>Select Role</option>
            <option value="Officer">Officer</option>
            <option value="Captain">Captain</option>
            <option value="Kagawad">Kagawad</option>
            <option value="SK Chairperson">SK Chairperson</option>
            <option value="Treasurer">Treasurer</option>
            <option value="Clerk">Clerk</option>
            <option value="Record Keeper">Record Keeper</option>
            <option value="Tanod">Tanod</option>
            <option value="Health Worker">Health Worker</option>
            <option value="Nutrition Scholar">Nutrition Scholar</option>
            <option value="Day Care Worker">Day Care Worker</option>
            <option value="IT Officer">IT Officer</option>
            <option value="DRRMO">DRRMO</option>
            <option value="Utility Worker">Utility Worker</option>
          </select>
        </div>

        <!-- Barangay Dropdown -->
        <div class="md:col-span-2">
          <label for="barangay" class="block text-sm font-medium text-gray-700 mb-1">Select Barangay</label>
          <select name="barangay" id="barangay"
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
            <option value="" disabled selected>Select Barangay</option>
            <option value="Barangay 1">Barangay 1</option>
            <option value="Barangay 2">Barangay 2</option>
            <option value="Barangay 3">Barangay 3</option>
            <option value="Barangay 4">Barangay 4</option>
            <option value="Barangay 5">Barangay 5</option>
            <option value="Barangay 6">Barangay 6</option>
            <option value="Barangay 7">Barangay 7</option>
            <option value="Barangay 8">Barangay 8</option>
            <option value="Barangay 9">Barangay 9</option>
          </select>
        </div>
      </div>
    </div>

    <!-- 🔐 Security Info -->
    <div class="mb-8">
      <h3 class="text-sm font-semibold text-green-600 mb-3 uppercase tracking-wide border-b border-green-200 pb-1">
        Security
      </h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password"
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation"
                 placeholder="Confirm password"
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
        </div>
      </div>
    </div>

    <!-- Submit -->
    <button type="submit"
            class="w-full bg-green-600 text-white p-3 rounded-lg font-semibold hover:bg-green-700 transition shadow-sm hover:shadow-md">
      Register
    </button>

    <!-- Login Link -->
    <p class="mt-6 text-center text-sm text-gray-700">
      Already have an account?
      <a href="{{ route('officer.login') }}" class="text-green-600 font-medium hover:underline">
        Login
      </a>
    </p>
  </form>

</body>
</html>
