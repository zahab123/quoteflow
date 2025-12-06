<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full bg-gray-100 py-10">

    <main class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Profile Settings</h2>

        <div class="space-y-10">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Update Profile Information</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Change Password</h3>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-semibold text-red-600 mb-4">Delete Account</h3>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </main>
</body>

</html>