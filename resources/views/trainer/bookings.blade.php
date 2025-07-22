<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">My Bookings</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-4 rounded shadow">
            @if ($bookings->isEmpty())
                <p>No bookings yet.</p>
            @else
                <table class="w-full table-auto border">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Client</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Time</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="border px-4 py-2">{{ $booking->client->name }}</td>
                                <td class="border px-4 py-2">{{ $booking->booking_date }}</td>
                                <td class="border px-4 py-2">{{ $booking->booking_time }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($booking->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
