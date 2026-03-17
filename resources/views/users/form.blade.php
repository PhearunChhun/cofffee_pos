<x-app-layout>
    <x-slot name="header">
        {{ isset($user) ? 'Edit User' : 'Add User' }}
    </x-slot>

    <div class="mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">
            {{ isset($user) ? 'Edit' : 'Add' }} User
        </h2>

        <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST"
            class="space-y-4">

            @csrf
            @if (isset($user))
                @method('PUT')
            @endif

            {{-- Name --}}
            <div>
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">

                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">

                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded shadow-sm">

                @if (isset($user))
                    <p class="text-sm text-gray-500">Leave blank if you don't want to change password</p>
                @endif

                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div>
                <label class="block text-gray-700">Role</label>
                <select name="role" class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin
                    </option>
                    <option value="manager" {{ old('role', $user->role ?? '') == 'manager' ? 'selected' : '' }}>Manager
                    </option>
                    <option value="cashier" {{ old('role', $user->role ?? '') == 'cashier' ? 'selected' : '' }}>Cashier
                    </option>
                </select>

                @error('role')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            {{-- Buttons --}}
            <div class="flex justify-end">
                <a href="{{ route('users.index') }}" class="mr-2 px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                    Cancel
                </a>

                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Save
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
