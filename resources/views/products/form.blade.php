<x-app-layout>
    <x-slot name="header">Add Products</x-slot>

    <div class="mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">{{ isset($product) ? 'Edit' : 'Add' }} Product</h2>

        <form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST"
            enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            <div>
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Category</label>
                <select name="category_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Base Price</label>
                <input type="number" step="0.01" name="base_price"
                    value="{{ old('base_price', $product->base_price ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('base_price')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Sizes & Prices</label>
                @foreach ($sizes as $size)
                    <div class="flex items-center space-x-2 mt-1">
                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                            {{ isset($product) && $product->sizes->contains($size->id) ? 'checked' : '' }}>
                        <span class="w-32">{{ $size->name }}</span>
                        <input type="number" step="0.01" name="size_prices[{{ $size->id }}]"
                            value="{{ isset($product) && $product->sizes->contains($size->id) ? $product->sizes->find($size->id)->pivot->price : 0 }}"
                            class="border-gray-300 rounded shadow-sm w-20">
                    </div>
                @endforeach
            </div>

            <div>
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-gray-700">Image</label>
                <input type="file" name="image" class="mt-1 block w-full">
                @if (isset($product) && $product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="mt-2 w-32 h-32 object-cover rounded">
                @endif
            </div>

            <div class="flex justify-end">
                <a href="{{ route('products.index') }}"
                    class="mr-2 px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</a>
                <button type="submit"
                    class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
