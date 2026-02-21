<x-app-layout>
    <x-slot name="header">Users</x-slot>
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-hidden p-4 space-y-4">
        <div class=" flex justify-end items-center">
            <a href="{{ route('users.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Add User
            </a>
        </div>
        @if (!empty($users) && count($users))
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="w-full bg-white shadow rounded">
                    <thead class="bg-blue-400 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Role</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-t">
                                <td class="p-3">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td class="space-x-2">
                                    <a href="{{ route('users.edit', $user) }}" class="text-blue-500">Edit</a>
    
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div>
                <h2 class="text-xl font-semibold text-center leading-tight">No data.</h2>
            </div>
        @endif
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</x-app-layout>
