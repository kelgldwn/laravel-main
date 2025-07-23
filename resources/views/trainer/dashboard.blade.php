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
    
        // Get actual data for trainer dashboard
        if ($role === 'trainer') {
            $todaySessions = \App\Models\Booking::where('trainer_id', Auth::id())
                ->whereDate('booking_date', today())
                ->where('status', 'confirmed')
                ->count();
                
            $pendingBookings = \App\Models\Booking::where('trainer_id', Auth::id())
                ->where('status', 'pending')
                ->count();
                
            $todaySchedule = \App\Models\Booking::where('trainer_id', Auth::id())
                ->whereDate('booking_date', today())
                ->with('client')
                ->orderBy('booking_time')
                ->get();
        }
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
                        @if($pendingBookings > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingBookings }}</span>
                        @endif
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
                        <h3 class="text-3xl font-bold mb-2" style="color:black">Welcome back,<span style="font-style:italic"> {{ Auth::user()->name }}!</span></h3>
                        <p class="text-orange-100 text-lg" style="color:orange">Ready to transform lives and build your fitness empire today?</p>
                        <div class="flex items-center mt-4 space-x-6" style="color:orange">
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

            {{-- Quick Stats - With Real Data --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Today's Sessions</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $todaySessions ?? 0 }}</p>
                            <p class="text-blue-600 text-sm font-medium mt-1">
                                <i class="fas fa-calendar-check mr-1"></i>Confirmed sessions
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
                            <p class="text-gray-600 text-sm font-medium">Pending Bookings</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $pendingBookings ?? 0 }}</p>
                            <p class="text-orange-600 text-sm font-medium mt-1">
                                <i class="fas fa-clock mr-1"></i>Awaiting approval
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-orange-600 text-xl"></i>
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
                            @if($todaySchedule && $todaySchedule->count() > 0)
                                <div class="space-y-4">
                                    @foreach($todaySchedule as $session)
                                    <div class="flex items-center justify-between p-4 bg-{{ $session->status === 'confirmed' ? 'green' : ($session->status === 'pending' ? 'yellow' : 'gray') }}-50 border-l-4 border-{{ $session->status === 'confirmed' ? 'green' : ($session->status === 'pending' ? 'yellow' : 'gray') }}-500 rounded-lg hover:bg-{{ $session->status === 'confirmed' ? 'green' : ($session->status === 'pending' ? 'yellow' : 'gray') }}-100 transition-colors duration-300">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-{{ $session->status === 'confirmed' ? 'green' : ($session->status === 'pending' ? 'yellow' : 'gray') }}-500 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold">{{ substr($session->client->name ?? 'N/A', 0, 1) }}{{ substr(explode(' ', $session->client->name ?? 'N A')[1] ?? 'A', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $session->client->name ?? 'Unknown Client' }}</h4>
                                                <p class="text-gray-600 text-sm">Training Session</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($session->booking_time)->format('g:i A') }}</p>
                                            <p class="text-{{ $session->status === 'confirmed' ? 'green' : ($session->status === 'pending' ? 'yellow' : 'gray') }}-600 text-sm font-medium capitalize">{{ $session->status }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-6 text-center">
                                    <a href="{{ route('trainer.bookings') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-calendar-plus mr-2"></i>
                                        Manage All Bookings
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <i class="fas fa-calendar-day text-gray-300 text-6xl mb-4"></i>
                                    <h4 class="text-xl font-semibold text-gray-600 mb-2">No Sessions Scheduled</h4>
                                    <p class="text-gray-500 mb-6">You don't have any sessions scheduled for today.</p>
                                    <a href="{{ route('trainer.bookings') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-calendar-plus mr-2"></i>
                                        View All Bookings
                                    </a>
                                </div>
                            @endif
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

                    {{-- Quick Actions - Simplified --}}
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
                            
                            <button class="w-full flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors duration-300">
                                <div class="flex items-center">
                                    <i class="fas fa-message text-blue-600 mr-3"></i>
                                    <span class="font-medium text-gray-800">Message Clients</span>
                                </div>
                                <i class="fas fa-arrow-right text-blue-600"></i>
                            </button>
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
