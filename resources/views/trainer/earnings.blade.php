<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Earnings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Financial Overview</h1>
                
                <!-- Earnings Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-green-50 to-teal-50 p-6 rounded-xl shadow">
                        <h3 class="text-gray-500 text-sm font-medium">Total Earnings</h3>
                        <p class="text-3xl font-bold text-gray-800">${{ number_format($totalEarnings, 2) }}</p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl shadow">
                        <h3 class="text-gray-500 text-sm font-medium">Pending Earnings</h3>
                        <p class="text-3xl font-bold text-gray-800">${{ number_format($pendingEarnings, 2) }}</p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-xl shadow">
                        <h3 class="text-gray-500 text-sm font-medium">Paid Earnings</h3>
                        <p class="text-3xl font-bold text-gray-800">${{ number_format($paidEarnings, 2) }}</p>
                    </div>
                </div>
                
                <!-- Monthly Earnings Chart -->
                <div class="mb-8 bg-white p-6 rounded-lg shadow border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4">Monthly Earnings</h2>
                    <div class="h-64">
                        <!-- This is a placeholder for a chart -->
                        <div class="h-full bg-gray-100 rounded flex items-center justify-center">
                            <p class="text-gray-500">Chart will be displayed here</p>
                        </div>
                    </div>
                </div>
                
                <!-- Earnings History -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Earnings History</h2>
                    
                    @if($earnings->count() > 0)
                        <div class="bg-white shadow overflow-hidden rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($earnings as $earning)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $earning->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $earning->booking->client->name ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $earning->booking ? \Carbon\Carbon::parse($earning->booking->booking_date)->format('M d, Y') : 'N/A' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $earning->booking ? \Carbon\Carbon::parse($earning->booking->booking_time)->format('g:i A') : '' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">${{ number_format($earning->net_amount, 2) }}</div>
                                                <div class="text-xs text-gray-500">
                                                    Fee: ${{ number_format($earning->platform_fee, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($earning->status == 'paid')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Paid
                                                    </span>
                                                @elseif($earning->status == 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($earning->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $earnings->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No earnings recorded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
