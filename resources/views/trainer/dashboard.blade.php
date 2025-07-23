<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-dumbbell text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">Trainer Command Center</h2>
                    <p class="text-gray-600">Manage your fitness empire, {{ Auth::user()->name }}!</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-orange-100 text-orange-800 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-crown mr-2"></i>Pro Trainer
                </div>
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-circle mr-2 animate-pulse"></i>Online
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $role = Auth::user()?->getRoleNames()->first();
    @endphp

    @if ($role === 'trainer')
    <div class="flex min-h-screen bg-gray-50">
        {{-- Enhanced Sidebar --}}
        <aside class="w-72 bg-white shadow-2xl border-r border-gray-200">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-fire text-white"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">TrainerPro</span>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('trainer.dashboard') }}" class="flex items-center space-x-3 bg-gradient-to-r from-orange-500 to-red-600 text-white px-4 py-3 rounded-xl font-medium transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('trainer.bookings') }}" class="flex items-center space-x-3 text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-4 py-3 rounded-xl transition-all duration-300">
                        <i class="fas fa-calendar-check"></i>
                        <span>Manage Bookings</span>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">5</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-4 py-3 rounded-xl transition-all duration-300">
                        <i class="fas fa-users"></i>
                        <span>My Clients</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-4 py-3 rounded-xl transition-all duration-300">
                        <i class="fas fa-chart-bar"></i>
                        <span>Performance</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-4 py-3 rounded-xl transition-all duration-300">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Earnings</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-4 py-3 rounded-xl transition-all duration-300">
                        <i class="fas fa-star"></i>
                        <span>Reviews</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-4 py-3 rounded-xl transition-all duration-300">
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
            {{-- Welcome Section --}}
            <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl p-8 mb-8 text-white shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 🔥</h3>
                        <p class="text-orange-100 text-lg">Ready to transform lives and build your fitness empire today?</p>
                        <div class="flex items-center mt-4 space-x-6">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-day mr-2"></i>
                                <span>{{ now()->format('l, F j, Y') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <span id="current-time">{{ now()->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-32 h-32 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-trophy text-6xl text-white opacity-80"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Today's Sessions</p>
                            <p class="text-3xl font-bold text-gray-900">8</p>
                            <p class="text-green-600 text-sm font-medium mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>+2 from yesterday
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Active Clients</p>
                            <p class="text-3xl font-bold text-gray-900">42</p>
                            <p class="text-green-600 text-sm font-medium mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>+5 this week
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">This Month</p>
                            <p class="text-3xl font-bold text-gray-900">$3,240</p>
                            <p class="text-green-600 text-sm font-medium mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>+12% vs last month
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Rating</p>
                            <p class="text-3xl font-bold text-gray-900">4.9</p>
                            <div class="flex items-center mt-1">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-gray-500 text-sm ml-2">(127 reviews)</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-star text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Today's Schedule --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6">
                            <h3 class="text-2xl font-bold text-white flex items-center">
                                <i class="fas fa-calendar-alt mr-3"></i>
                                Today's Schedule
                            </h3>
                            <p class="text-blue-100 mt-2">Manage your upcoming sessions</p>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                {{-- Sample Schedule Items --}}
                                <div class="flex items-center justify-between p-4 bg-green-50 border-l-4 border-green-500 rounded-lg hover:bg-green-100 transition-colors duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold">JD</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">John Doe</h4>
                                            <p class="text-gray-600 text-sm">Strength Training</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">9:00 AM</p>
                                        <p class="text-green-600 text-sm font-medium">Confirmed</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg hover:bg-blue-100 transition-colors duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold">SM</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Sarah Miller</h4>
                                            <p class="text-gray-600 text-sm">Cardio & HIIT</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">11:00 AM</p>
                                        <p class="text-blue-600 text-sm font-medium">Confirmed</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg hover:bg-yellow-100 transition-colors duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold">MJ</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Mike Johnson</h4>
                                            <p class="text-gray-600 text-sm">Weight Loss Program</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">2:00 PM</p>
                                        <p class="text-yellow-600 text-sm font-medium">Pending</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-purple-50 border-l-4 border-purple-500 rounded-lg hover:bg-purple-100 transition-colors duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold">LW</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Lisa Wilson</h4>
                                            <p class="text-gray-600 text-sm">Yoga & Flexibility</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">4:00 PM</p>
                                        <p class="text-purple-600 text-sm font-medium">Confirmed</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 text-center">
                                <a href="{{ route('trainer.bookings') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-calendar-plus mr-2"></i>
                                    Manage All Bookings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Notifications & Quick Actions --}}
                <div class="space-y-6">
                    {{-- Notifications --}}
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-red-400 to-pink-500 p-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-bell mr-2"></i>
                                Notifications
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                <span class="ml-2 bg-white text-red-500 text-xs px-2 py-1 rounded-full font-bold">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                                @endif
                            </h3>
                        </div>

                        <div class="p-4 max-h-80 overflow-y-auto">
                            @forelse (Auth::user()->unreadNotifications as $notification)
                            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg mb-3 hover:bg-red-100 transition-colors duration-300">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                                            <span class="font-semibold text-gray-800">New Booking Request</span>
                                        </div>
                                        <p class="text-sm text-gray-700">{{ $notification->data['message'] }}</p>
                                        <p class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('POST')
                                        <button class="text-red-600 hover:text-red-800 text-sm font-medium bg-white px-3 py-1 rounded-full border border-red-200 hover:border-red-400 transition-colors duration-300">
                                            <i class="fas fa-check mr-1"></i>Read
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fas fa-bell-slash text-gray-300 text-4xl mb-4"></i>
                                <p class="text-gray-500 font-medium">All caught up!</p>
                                <p class="text-gray-400 text-sm">No new notifications</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-rocket mr-2 text-orange-500"></i>Quick Actions
                        </h3>
                        
                        <div class="space-y-3">
                            <button class="w-full flex items-center justify-between p-3 bg-orange-50 hover:bg-orange-100 rounded-xl transition-colors duration-300">
                                <div class="flex items-center">
                                    <i class="fas fa-plus text-orange-600 mr-3"></i>
                                    <span class="font-medium text-gray-800">Add Availability</span>
                                </div>
                                <i class="fas fa-arrow-right text-orange-600"></i>
                            </button>
                            
                            <button class="w-full flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-xl transition-colors duration-300">
                                <div class="flex items-center">
                                    <i class="fas fa-chart-line text-green-600 mr-3"></i>
                                    <span class="font-medium text-gray-800">View Analytics</span>
                                </div>
                                <i class="fas fa-arrow-right text-green-600"></i>
                            </button>
                            
                            <button class="w-full flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors duration-300">
                                <div class="flex items-center">
                                    <i class="fas fa-message text-blue-600 mr-3"></i>
                                    <span class="font-medium text-gray-800">Message Clients</span>
                                </div>
                                <i class="fas fa-arrow-right text-blue-600"></i>
                            </button>
                            
                            <button class="w-full flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-xl transition-colors duration-300">
                                <div class="flex items-center">
                                    <i class="fas fa-cog text-purple-600 mr-3"></i>
                                    <span class="font-medium text-gray-800">Profile Settings</span>
                                </div>
                                <i class="fas fa-arrow-right text-purple-600"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Performance Widget --}}
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-trophy mr-2 text-yellow-500"></i>This Week
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Sessions Completed</span>
                                <span class="font-bold text-gray-900">28/30</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full" style="width: 93%"></div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Client Satisfaction</span>
                                <span class="font-bold text-gray-900">98%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full" style="width: 98%"></div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Revenue Goal</span>
                                <span class="font-bold text-gray-900">$810/$900</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-2 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @endif

    <style>
        .gradient-text {
            background: linear-gradient(135deg, #F97316 0%, #DC2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour: 'numeric', 
                minute: '2-digit',
                hour12: true 
            });
            document.getElementById('current-time').textContent = timeString;
        }
        
        // Update time every minute
        setInterval(updateTime, 60000);
        
        // Animate stats on load
        document.addEventListener('DOMContentLoaded', function() {
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