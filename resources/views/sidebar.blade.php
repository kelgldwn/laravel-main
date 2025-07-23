<x-app-layout>
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-100 p-4">
            <h2 class="font-bold text-lg mb-6">Client Menu</h2>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-700 hover:underline">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('client.bookings.history') }}" class="text-blue-700 hover:underline">Booking History</a>
                </li>
            </ul>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</x-app-layout>
