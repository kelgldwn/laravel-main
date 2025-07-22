<x-guest-layout>
    <div class="w-full max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-6 text-center">Create Account</h2>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full mt-1 p-2 border rounded" required>
                @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full mt-1 p-2 border rounded" required>
                @error('email') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full mt-1 p-2 border rounded" required>
                @error('password') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full mt-1 p-2 border rounded" required>
            </div>

            <!-- Role Selection -->
            <div class="mb-4">
                <label for="role" class="block text-gray-700">Register As</label>
                <select name="role" id="role" class="w-full mt-1 p-2 border rounded" required>
                    <option value="">Select a role</option>
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                </select>
                @error('role') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded">
                    Register
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
