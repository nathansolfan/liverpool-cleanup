<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community Cleanup Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Hero Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">
                        Welcome to Our Community Cleanup Initiative!
                    </h3>
                    <p class="text-gray-600 text-lg mb-4">
                        Join our community in making a difference by reporting areas that need cleanup
                        and supporting our mission to keep our neighborhoods clean and green.
                    </p>
                </div>
            </div>

            <!-- Mission Statement -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Our Mission</h4>
                    <p class="text-gray-600 mb-4">
                        We're a community-based app dedicated to creating cleaner, healthier environments
                        for everyone. By connecting local volunteers with areas needing attention, we make
                        neighborhood cleanup efforts more organized and effective.
                    </p>
                </div>
            </div>

            <!-- Support Our Cause -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Support Our Cause</h4>
                    <p class="text-gray-600 mb-4">
                        Your donations help us provide essential supplies for community cleanup efforts:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 mb-6 space-y-2">
                        <li>Trash pickers and grabber tools for safe waste collection</li>
                        <li>Heavy-duty trash bags and recycling supplies</li>
                        <li>Community bins for collection points</li>
                        <li>Support for professionals to handle larger waste items</li>
                    </ul>
                    <a href="/donate" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white text-sm uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Support Us Now
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Report Area Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h5 class="text-lg font-semibold text-gray-800 mb-2">Report a Cleanup Area</h5>
                        <p class="text-gray-600 mb-4">Found litter or need cleanup? Let us know and we'll coordinate efforts!</p>
                        <a href="{{ route('cleanup-areas.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Report Now
                        </a>
                    </div>
                </div>

                <!-- View Areas Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h5 class="text-lg font-semibold text-gray-800 mb-2">View Cleanup Areas</h5>
                        <p class="text-gray-600 mb-4">Check out reported areas and join cleanup efforts in your area.</p>
                        <a href="{{ route('cleanup-areas.index') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">
                            View Areas
                        </a>
                    </div>
                </div>

                <!-- Volunteer Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h5 class="text-lg font-semibold text-gray-800 mb-2">Become a Volunteer</h5>
                        <p class="text-gray-600 mb-4">Join our team of environmental champions and make a real difference.</p>
                        <a href="/volunteer" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                            Join Us
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity (Optional) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">Recent Community Activity</h4>
                    <p class="text-gray-600">
                        Check back soon to see the latest cleanup efforts and community impact!
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
