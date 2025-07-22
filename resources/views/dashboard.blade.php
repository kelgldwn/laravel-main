<x-app-layout>
    <x-slot name="header">
    <p>Logged in as: {{ Auth::user()->name }} | Role: {{ Auth::user()->getRoleNames()->first() }}</p>
        <h2 class="font-semibold text-xl">Client Dashboard</h2>
    </x-slot>

    {{-- Booking Form --}}
    @php
    $role = Auth::user()?->getRoleNames()->first();
    @endphp

    @if ($role === 'client')
        {{-- Pass trainers manually for now --}}
        @php
            $trainers = \App\Models\User::role('trainer')->get();
        @endphp

        <div class="py-4 max-w-3xl mx-auto">
            @if (session('success'))
                <div class="bg-green-200 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="trainer_id" class="block font-medium">Select Trainer</label>
                    <select name="trainer_id" class="w-full p-2 border rounded" required>
                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-medium">Date</label>
                    <input type="date" name="booking_date" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label class="block font-medium">Time</label>
                    <input type="time" name="booking_time" class="w-full p-2 border rounded" required>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Book Trainer</button>
            </form>
        </div>
    @endif
</x-app-layout>
