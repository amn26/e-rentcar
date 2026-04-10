<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-RentCar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Phone</label>
                        <input type="text" name="phone" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 mb-2">Address</label>
                    <textarea name="address" rows="2" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-gray-700 mb-2">KTP Image</label>
                        <input type="file" name="ktp_image" accept="image/*" required class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">SIM Image</label>
                        <input type="file" name="sim_image" accept="image/*" required class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 mt-6">Register</button>
            </form>

            <p class="text-center mt-4 text-gray-600">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
            </p>
        </div>
    </div>
</body>
</html>
