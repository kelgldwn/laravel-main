<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Your Booking History</h2>
    </x-slot>
   
<a href="{{ route('dashboard') }}" class="bg-gray-200 px-4 py-2 rounded">← Back to Dashboard</a>

    <div class="py-4 max-w-5xl mx-auto">
        @if ($bookings->isEmpty())
            <p>No bookings found.</p>
        @else
            <table class="w-full border text-left">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2">Trainer</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Time</th>
                        <th class="p-2">Status</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border-t">
                            <td class="p-2">{{ $booking->trainer->name ?? 'N/A' }}</td> <!-- ✅ Fix here -->
                            <td class="p-2">{{ $booking->booking_date }}</td>
                            <td class="p-2">{{ $booking->booking_time }}</td>
                            <td class="p-2">
                                @if ($booking->status == 'approved')
                                    <span class="text-green-600 font-semibold">Approved</span>
                                @elseif ($booking->status == 'declined')
                                    <span class="text-red-600 font-semibold">Declined</span>
                                @else
                                    <span class="text-yellow-600 font-semibold">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
