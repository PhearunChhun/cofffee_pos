<x-app-layout>
    <x-slot name="header"> Size</x-slot>
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-hidden p-4 space-y-4">
        <div class=" flex justify-end items-center">
            <a href="{{ route('sizes.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Add Size
            </a>
        </div>
        @if (!empty($sizes) && count($sizes))
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-400 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Price</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($sizes as $size)
                            <tr>
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $size->name }}</td>
                                <td class="px-6 py-4">{{ $size->price_adjustment ."$"}}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('categories.edit', $size) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('categories.destroy', $size) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
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
</x-app-layout>
