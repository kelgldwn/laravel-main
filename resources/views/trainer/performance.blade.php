<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance Metrics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Performance Analytics</h1>
                
                <!-- Performance Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl shadow">
                        <h3 class="text-gray-500 text-sm font-medium">Booking Completion Rate</h3>
                        <div class="flex items-end">
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($completionRate, 1) }}%</p>
                            <div class="ml-2 text-sm text-gray-500">of bookings completed</div>
                        </div>
                        <div class="mt-4 h-2 bg-gray-200 rounded-full">
                            <div class="h-2 bg-blue-500 rounded-full" style="width: {{ $completionRate }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-xl shadow">
                        <h3 class="text-gray-500 text-sm font-medium">Client Retention Rate</h3>
                        <div class="flex items-end">
                            <p class="text-3xl font-bold text-gray-800">{{ number_format($retentionRate, 1) }}%</p>
                            <div class="ml-2 text-sm text-gray-500">of clients return</div>
                        </div>
                        <div class="mt-4 h-2 bg-gray-200 rounded-full">
                            <div class="h-2 bg-purple-500 rounded-full" style="width: {{ $retentionRate }}%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Monthly Bookings Chart -->
                <div class="mb-8 bg-white p-6 rounded-lg shadow border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4">Monthly Bookings</h2>
                    <div class="h-64">
                        <!-- This is a placeholder for a chart -->
                        <div class="h-full bg-gray-100 rounded flex items-center justify-center">
                            <p class="text-gray-500">Chart will be displayed here</p>
                        </div>
                    </div>
                </div>
                
                <!-- Popular Time Slots -->
                <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4">Popular Time Slots</h2>
                    
                    @if(count($popularTimeSlots) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            @foreach($popularTimeSlots as $timeSlot)
                                <div class="bg-gradient-to-br from-green-50 to-teal-50 p-4 rounded-lg text-center">
                                    <p class="text-lg font-semibold text-gray-800">{{ $timeSlot['time'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $timeSlot['total'] }} bookings</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Not enough data to determine popular time slots.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
