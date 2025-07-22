<x-guest-layout>
    <form method="POST" action="{{ route('trainer.register.submit') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="w-full border p-2" required>
            @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="w-full border p-2" required>
            @error('email') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="w-full border p-2" required>
            @error('password') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border p-2" required>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Register as Trainer
            </button>
        </div>
    </form>
</x-guest-layout>
