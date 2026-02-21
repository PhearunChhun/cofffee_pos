<x-app-layout>
    <x-slot name="header">Add Categories</x-slot>

    <div class=" mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">{{ isset($category) ? 'Edit' : 'Add' }} Category</h2>

        <form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}"
            method="POST" class="space-y-4">
            @csrf
            @if (isset($category))
                @method('PUT')
            @endif

            <div>
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('description', $category->description ?? '') }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('categories.index') }}"
                    class="mr-2 px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
