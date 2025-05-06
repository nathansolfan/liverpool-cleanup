<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Support Our Community Cleanup') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 border-l-4 border-green-500 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">
                        Make a Difference Today
                    </h3>
                    <p class="text-gray-600 text-lg mb-4">
                        Your donation helps us provide essential supplies for community cleanup efforts.
                        Together, we can create cleaner, healthier neighborhoods for everyone.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Donation Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Donation Form</h4>

                        <form action="{{ route('donate.process') }}" method="POST">
                            @csrf

                            <!-- Amount -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Donation Amount
                                </label>
                                <div class="grid grid-cols-3 gap-2 mb-2">
                                    <button type="button" onclick="setAmount(5)" class="btn-amount p-2 border-2 border-gray-300 rounded-md text-center hover:border-green-500 hover:bg-green-50">£5</button>
                                    <button type="button" onclick="setAmount(10)" class="btn-amount p-2 border-2 border-gray-300 rounded-md text-center hover:border-green-500 hover:bg-green-50">£10</button>
                                    <button type="button" onclick="setAmount(25)" class="btn-amount p-2 border-2 border-gray-300 rounded-md text-center hover:border-green-500 hover:bg-green-50">£25</button>
                                    <button type="button" onclick="setAmount(50)" class="btn-amount p-2 border-2 border-gray-300 rounded-md text-center hover:border-green-500 hover:bg-green-50">£50</button>
                                    <button type="button" onclick="setAmount(100)" class="btn-amount p-2 border-2 border-gray-300 rounded-md text-center hover:border-green-500 hover:bg-green-50">£100</button>
                                    <button type="button" onclick="showCustomAmount()" class="btn-amount p-2 border-2 border-gray-300 rounded-md text-center hover:border-green-500 hover:bg-green-50">Other</button>
                                </div>
                                <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
                                    required min="1" step="0.01" placeholder="Enter amount">
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Frequency -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Donation Frequency
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="frequency" value="one-time" {{ old('frequency', 'one-time') == 'one-time' ? 'checked' : '' }} class="mr-2">
                                        One-time donation
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="frequency" value="monthly" {{ old('frequency') == 'monthly' ? 'checked' : '' }} class="mr-2">
                                        Monthly recurring
                                    </label>
                                </div>
                                @error('frequency')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Payment Method
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="payment_method" value="credit_card" {{ old('payment_method', 'credit_card') == 'credit_card' ? 'checked' : '' }} class="mr-2">
                                        Credit/Debit Card
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="payment_method" value="paypal" {{ old('payment_method') == 'paypal' ? 'checked' : '' }} class="mr-2">
                                        PayPal
                                    </label>
                                </div>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Your Name
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email Address
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
                                    required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Donate Now
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Impact Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4">Your Impact</h4>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 font-bold">£5</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Provides 50 heavy-duty trash bags</p>
                                    <p class="text-sm text-gray-500">Enough for a small cleanup crew for one day</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 font-bold">£10</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Provides a trash picker tool</p>
                                    <p class="text-sm text-gray-500">Essential equipment for safe waste collection</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 font-bold">£25</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Provides a community cleanup kit</p>
                                    <p class="text-sm text-gray-500">Includes bags, pickers, and safety gloves</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 font-bold">£50</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Provides a portable waste bin</p>
                                    <p class="text-sm text-gray-500">For busy cleanup locations</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 font-bold">£100</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Sponsors a large waste removal</p>
                                    <p class="text-sm text-gray-500">For bulky items and major cleanups</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h5 class="font-semibold text-gray-800 mb-2">Thank You</h5>
                            <p class="text-sm text-gray-600">
                                Every donation, no matter the size, helps create cleaner communities.
                                You'll receive a receipt via email for your donation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Add Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>

    <script>
    function setAmount(amount) {
        document.getElementById('amount').value = amount;
        highlightButton(amount);
    }

    function showCustomAmount() {
        document.getElementById('amount').value = '';
        document.getElementById('amount').focus();
        highlightButton(null);
    }

    function highlightButton(amount) {
        // Remove active class from all buttons
        document.querySelectorAll('.btn-amount').forEach(btn => {
            btn.classList.remove('border-green-500', 'bg-green-50');
            btn.classList.add('border-gray-300');
        });

        // Add active class to selected button
        if (amount) {
            event.target.classList.add('border-green-500', 'bg-green-50');
            event.target.classList.remove('border-gray-300');
        }
    }
    </script>
    @endpush
</x-app-layout>
