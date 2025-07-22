<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome, {{ Auth::user()->name }} (Trainer)
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <a href="{{ route('trainer.bookings') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
            View My Bookings
        </a>
    </div>
</x-app-layout>
