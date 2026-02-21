<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-sm text-gray-500">Users</h2>
            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-sm text-gray-500">Categories</h2>
            <p class="text-2xl font-bold">{{ $totalCategories }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-sm text-gray-500">Products</h2>
            <p class="text-2xl font-bold">{{ $totalProducts }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-sm text-gray-500">Total Sales</h2>
            <p class="text-2xl font-bold">${{ number_format($totalSales,2) }}</p>
        </div>

    </div>
</x-app-layout>