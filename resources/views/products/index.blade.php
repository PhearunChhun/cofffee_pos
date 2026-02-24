<x-app-layout>
    <x-slot name="header">Products</x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-hidden p-4 space-y-4">
        <div class=" flex justify-end items-center">
            <a href="{{ route('products.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Add Product
            </a>
        </div>
        @if (!empty($products) && count($products))
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-400 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left ">#</th>
                            <th class="px-4 py-2 text-left ">Image</th>
                            <th class="px-4 py-2 text-left ">Name</th>
                            <th class="px-4 py-2 text-left ">Category</th>
                            <th class="px-4 py-2 text-left ">Base Price</th>
                            <th class="px-4 py-2 text-left ">Size prices</th>
                            <th class="px-4 py-2 text-left ">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($products as $product)
                            <tr>
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" width="70px" height="70px"
                                            class="w-[50px] h-[50px] object-cover rounded">
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $product->name }}</td>
                                <td class="px-6 py-4">{{ $product->category->name }}</td>
                                <td class="px-6 py-4">{{ $product->base_price }}</td>
                                <td class="px-6 py-4">
                                    @foreach ($product->sizes as $size)
                                        <span class="text-xs bg-gray-200 px-2 py-1 rounded">
                                            {{ $size->name }} (${{ $size->pivot->price }})
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
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
    </div>
</x-app-layout>
