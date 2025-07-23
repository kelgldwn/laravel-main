<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="text-gray-600">Ready to crush your fitness goals today?</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-fire mr-2"></i>Active Member
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $role = Auth::user()?->getRoleNames()->first();
        $trainers = \App\Models\User::role('trainer')->get();
    @endphp

    @if ($role === 'client')
    <div class="flex min-h-screen bg-gray-50">
        {{-- Enhanced Sidebar --}}
        <aside class="w-72 bg-white shadow-xl border-r border-gray-200">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-dumbbell text-white"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">FitBook</span>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-3 rounded-xl font-medium transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('client.bookings.history') }}" class="flex items-center space-x-3 text-gray-600 hover:text-blue-600 hover:bg-blue-50 px-4 py-3 rounded-xl transition-all duration-300">
                        <i class="fas fa-history"></i>
                        <span>Booking History</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-blue-600 hover:bg-blue-50 px-4 py-3 rounded-xl transition-all duration-300">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </nav>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 text-red-600 hover:text-red-700 hover:bg-red-50 px-4 py-3 rounded-xl transition-all duration-300 w-full">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-8">
            @if (session('success'))
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-4 rounded-xl mb-6 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-3"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            {{-- Quick Stats - Removed Favorite Trainers --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Bookings</p>
                            <p class="text-3xl font-bold text-gray-900">24</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">This Month</p>
                            <p class="text-3xl font-bold text-gray-900">8</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-fire text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Hours Trained</p>
                            <p class="text-3xl font-bold text-gray-900">36</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Enhanced Booking Form --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6">
                            <h3 class="text-2xl font-bold text-white flex items-center">
                                <i class="fas fa-plus-circle mr-3"></i>
                                Book Your Next Session
                            </h3>
                            <p class="text-blue-100 mt-2">Find the perfect trainer and schedule your workout</p>
                        </div>

                        <form action="{{ route('bookings.store') }}" method="POST" class="p-8 space-y-6">
                            @csrf
                            
                            <div>
                                <label for="trainer_id" class="block text-sm font-bold text-gray-700 mb-3">
                                    <i class="fas fa-user-tie mr-2 text-blue-600"></i>Select Your Trainer
                                </label>
                                <select name="trainer_id" class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300" required>
                                    <option value="">Choose a trainer...</option>
                                    @foreach ($trainers as $trainer)
                                    <option value="{{ $trainer->id }}">
                                        {{ $trainer->name }} - ⭐ 4.9 Rating
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-3">
                                        <i class="fas fa-calendar mr-2 text-green-600"></i>Select Date
                                    </label>
                                    <input type="date" name="booking_date" class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-300" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-3">
                                        <i class="fas fa-clock mr-2 text-purple-600"></i>Select Time
                                    </label>
                                    <input type="time" name="booking_time" class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-300" required>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold py-4 px-8 rounded-xl hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl" style="color:black">
                                <i class="fas fa-rocket mr-3"></i>Book This Session
                            </button>
                        </form>
                    </div>  
                </div>

                {{-- Notifications & Quick Actions --}}
                <div class="space-y-6">
                    {{-- Notifications --}}
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-bell mr-2"></i>
                                Notifications
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                                @endif
                            </h3>
                        </div>

                        <div class="p-4 max-h-80 overflow-y-auto">
                            @forelse (Auth::user()->unreadNotifications as $notification)
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-3 hover:bg-yellow-100 transition-colors duration-300">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-800">{{ $notification->data['message'] }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('POST')
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fas fa-bell-slash text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500">No new notifications</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Quick Actions - Removed Favorite Trainers and Progress Tracking --}}
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-bolt mr-2 text-yellow-500"></i>Quick Actions
                        </h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('client.bookings.history') }}" class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors duration-300">
                                <div class="flex items-center">
                                    <i class="fas fa-history text-blue-600 mr-3"></i>
                                    <span class="font-medium text-gray-800">View History</span>
                                </div>
                                <i class="fas fa-arrow-right text-blue-600"></i>
                            </a>

                            <a href="#" class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-xl transition-colors duration-300">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-green-600 mr-3"></i>
                                    <span class="font-medium text-gray-800">Rate Trainers</span>
                                </div>
                                <i class="fas fa-arrow-right text-green-600"></i>
                            </a>

                            <a href="#" class="flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition-colors duration-300">
                                <div class="flex items-center">
                                    <i class="fas fa-cog text-purple-600 mr-3"></i>
                                    <span class="font-medium text-gray-800">Settings</span>
                                </div>
                                <i class="fas fa-arrow-right text-purple-600"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Bookings Table --}}
            @if(isset($bookings) && $bookings->count())
            <div class="mt-8">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 p-6">
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-list mr-3"></i>Recent Bookings
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-user-tie mr-2"></i>Trainer
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-2"></i>Date
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-clock mr-2"></i>Time
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-info-circle mr-2"></i>Status
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition-colors duration-300">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white font-bold text-sm">{{ substr($booking->trainer->name, 0, 1) }}</span>
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $booking->trainer->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($booking->status === 'confirmed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Confirmed
                                        </span>
                                        @elseif($booking->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>{{ ucfirst($booking->status) }}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 mr-3">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </main>
    </div>
    @endif

    <style>
    .gradient-text {
        background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.02);
    }
    </style>

    <script>
    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stats on load
        const stats = document.querySelectorAll('.grid .bg-white');
        stats.forEach((stat, index) => {
            setTimeout(() => {
                stat.style.opacity = '0';
                stat.style.transform = 'translateY(20px)';
                stat.style.transition = 'all 0.6s ease';
                setTimeout(() => {
                    stat.style.opacity = '1';
                    stat.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });
    });
    </script>
</x-app-layout>
