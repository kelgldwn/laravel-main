<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800">Booking Command Center</h2>
                    <p class="text-gray-600">Manage your client sessions like a pro</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-orange-100 text-orange-800 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-clock mr-2"></i>{{ $bookings->where('status', 'pending')->count() }} Pending
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back Button & Quick Stats --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <a href="{{ route('trainer.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 mb-4 md:mb-0">
                    <i class="fas fa-arrow-left mr-3 text-orange-600"></i>
                    Back to Dashboard
                </a>

                <div class="flex space-x-4">
                    <div class="bg-white rounded-xl p-4 shadow-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'approved')->count() }}</p>
                                <p class="text-sm text-gray-600"style="color:green">Approved</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 shadow-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'pending')->count() }}</p>
                                <p class="text-sm text-gray-600"style="color:orange">Pending</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 shadow-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-times text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'declined')->count() }}</p>
                                <p class="text-sm text-gray-600"style="color:red">Declined</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-2xl mb-8 shadow-xl">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Success!</h3>
                        <p class="text-green-100">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Filter Tabs --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden">
                <div class="flex border-b border-gray-200">
                    <button class="flex-1 px-6 py-4 text-center font-semibold text-orange-600 bg-orange-50 border-b-2 border-orange-600 transition-all duration-300" onclick="filterBookings('all')">
                        <i class="fas fa-list mr-2"></i>All Bookings ({{ $bookings->count() }})
                    </button>
                    <button class="flex-1 px-6 py-4 text-center font-semibold text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 transition-all duration-300" onclick="filterBookings('pending')">
                        <i class="fas fa-clock mr-2"></i><span style="color:orange">Pending</span> ({{ $bookings->where('status', 'pending')->count() }})
                    </button>
                    <button class="flex-1 px-6 py-4 text-center font-semibold text-gray-600 hover:text-green-600 hover:bg-green-50 transition-all duration-300" onclick="filterBookings('approved')">
                        <i class="fas fa-check mr-2"></i><span style="color:green">Approved</span> ({{ $bookings->where('status', 'approved')->count() }})
                    </button>
                    <button class="flex-1 px-6 py-4 text-center font-semibold text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all duration-300" onclick="filterBookings('declined')">
                        <i class="fas fa-times mr-2"></i><span style="color:red">Declined</span> ({{ $bookings->where('status', 'declined')->count() }})
                    </button>
                </div>
            </div>

            {{-- Bookings Content --}}
            @if ($bookings->isEmpty())
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-calendar-times text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No Booking Requests Yet</h3>
                <p class="text-gray-600 text-lg mb-8">When clients book sessions with you, they'll appear here for your review.</p>
                <a href="{{ route('trainer.dashboard') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold rounded-xl hover:from-orange-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Back to Dashboard
                </a>
            </div>
            @else
            {{-- Desktop Table View --}}
            <div class="hidden lg:block bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-gray-800 to-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-user mr-2"></i>Client
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-2"></i>Date
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-clock mr-2"></i>Time
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-2"></i>Status
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-2"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($bookings as $booking)
                            <tr class="booking-row hover:bg-gray-50 transition-colors duration-300" data-status="{{ $booking->status }}">
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                            <span class="text-white font-bold text-lg">{{ substr($booking->client->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-lg font-bold text-gray-900">{{ $booking->client->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->client->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="text-lg font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('l') }}
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="text-lg font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    @if ($booking->status == 'approved')
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>Approved
                                    </span>
                                    @elseif ($booking->status == 'declined')
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-2"></i>Declined
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 animate-pulse">
                                        <i class="fas fa-clock mr-2"></i><span style="color:orange">Pending</span>
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    @if ($booking->status === 'pending')
                                    <div class="flex space-x-3">
                                        <form action="{{ route('trainer.bookings.approve', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                                <i class="fas fa-check mr-2"></i><span style="color:green">Approve</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('trainer.bookings.decline', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                                <i class="fas fa-times mr-2"></i><span style="color:red">Decline</span>
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                    <div class="flex space-x-3">
                                        <button class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 font-medium rounded-lg hover:bg-blue-200 transition-colors duration-300">
                                            <i class="fas fa-eye mr-2"></i>View
                                        </button>
                                        <button class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-300">
                                            <i class="fas fa-comment mr-2"></i>Message
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Mobile Card View --}}
            <div class="lg:hidden space-y-4">
                @foreach ($bookings as $booking)
                <div class="booking-card bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300" data-status="{{ $booking->status }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xl">{{ substr($booking->client->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $booking->client->name }}</h3>
                                <p class="text-gray-600">{{ $booking->client->email }}</p>
                            </div>
                        </div>
                        @if ($booking->status == 'approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Approved
                        </span>
                        @elseif ($booking->status == 'declined')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>Declined
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 animate-pulse">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center text-gray-600 mb-1">
                                <i class="fas fa-calendar mr-2"></i>
                                <span class="text-sm font-medium">Date</span>
                            </div>
                            <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l') }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center text-gray-600 mb-1">
                                <i class="fas fa-clock mr-2"></i>
                                <span class="text-sm font-medium">Time</span>
                            </div>
                            <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</div>
                            <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->booking_time)->diffForHumans() }}</div>
                        </div>
                    </div>

                    @if ($booking->status === 'pending')
                    <div class="flex space-x-3">
                        <form action="{{ route('trainer.bookings.approve', $booking) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-check mr-2"></i><span >Approve
                            </button>
                        </form>
                        <form action="{{ route('trainer.bookings.decline', $booking) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-times mr-2"></i>Decline
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="flex space-x-3">
                        <button class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-blue-100 text-blue-800 font-bold rounded-xl hover:bg-blue-200 transition-colors duration-300">
                            <i class="fas fa-eye mr-2"></i>View Details
                        </button>
                        <button class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-800 font-bold rounded-xl hover:bg-gray-200 transition-colors duration-300">
                            <i class="fas fa-comment mr-2"></i>Message
                        </button>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <style>
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>

    <script>
        function filterBookings(status) {
            // Update active tab
            const tabs = document.querySelectorAll('button[onclick^="filterBookings"]');
            tabs.forEach(tab => {
                tab.classList.remove('text-orange-600', 'bg-orange-50', 'border-b-2', 'border-orange-600');
                tab.classList.add('text-gray-600');
            });
            
            event.target.classList.remove('text-gray-600');
            event.target.classList.add('text-orange-600', 'bg-orange-50', 'border-b-2', 'border-orange-600');
            
            // Filter bookings
            const bookingRows = document.querySelectorAll('.booking-row');
            const bookingCards = document.querySelectorAll('.booking-card');
            
            [...bookingRows, ...bookingCards].forEach(element => {
                if (status === 'all' || element.dataset.status === status) {
                    element.style.display = '';
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        element.style.transition = 'all 0.3s ease';
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    element.style.display = 'none';
                }
            });
        }

        // Animate elements on page load
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.booking-row, .booking-card');
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(20px)';
                    element.style.transition = 'all 0.6s ease';
                    setTimeout(() => {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</x-app-layout>