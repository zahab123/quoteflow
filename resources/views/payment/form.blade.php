<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Integration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md" x-data="{ method: 'stripe' }">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Choose Payment Method</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Payment Method Tabs -->
        <div class="flex justify-center mb-6 space-x-4">
            <button @click="method = 'stripe'" :class="method === 'stripe' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded-md font-medium transition">Stripe</button>
            <button @click="method = 'easypaisa'" :class="method === 'easypaisa' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded-md font-medium transition">EasyPaisa</button>
            <button @click="method = 'jazzcash'" :class="method === 'jazzcash' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-4 py-2 rounded-md font-medium transition">JazzCash</button>
        </div>

        <!-- Stripe Form -->
        <div x-show="method === 'stripe'" x-transition>
            <form action="{{ route('payment.stripe') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Amount (USD)</label>
                    <input type="number" name="amount" placeholder="Enter Amount" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                </div>
                
                <div class="flex justify-center">
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="{{ env('STRIPE_KEY') }}"
                        data-name="Quotation Payment"
                        data-description="Pay for Quotation"
                        data-currency="usd">
                    </script>
                </div>
            </form>
        </div>

        <!-- EasyPaisa Form -->
        <div x-show="method === 'easypaisa'" x-transition style="display: none;">
            <form action="{{ route('payment.easypaisa') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Amount (PKR)</label>
                    <input type="number" name="amount" placeholder="Enter Amount" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
                    <input type="text" name="mobile_number" placeholder="03XXXXXXXXX" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-2 border">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">Pay with EasyPaisa</button>
            </form>
        </div>

        <!-- JazzCash Form -->
        <div x-show="method === 'jazzcash'" x-transition style="display: none;">
            <form action="{{ route('payment.jazzcash') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Amount (PKR)</label>
                    <input type="number" name="amount" placeholder="Enter Amount" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">JazzCash Mobile Number</label>
                    <input type="text" name="mobile_number" placeholder="03XXXXXXXXX" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CNIC Last 6 Digits</label>
                    <input type="text" name="cnic_last_6" placeholder="XXXXXX" required maxlength="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm p-2 border">
                </div>
                <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition">Pay with JazzCash</button>
            </form>
        </div>

    </div>

</body>
</html>
