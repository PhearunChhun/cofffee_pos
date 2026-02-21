<x-app-layout>
    <x-slot name="header">Report</x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-hidden p-4">

        <!-- Filter -->
        <form method="GET" class="flex gap-2 mb-4 items-end">
            <div>
                <label class="block text-sm font-medium">Start Date</label>
                <input type="date" name="start" value="{{ $start->toDateString() }}"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium">End Date</label>
                <input type="date" name="end" value="{{ $end->toDateString() }}"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Filter</button>
        </form>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-400 text-white">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Cashier</th>
                        <th class="px-4 py-2">Items</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $sale->id }}</td>
                            <td class="px-4 py-2">{{ $sale->user->name }}</td>
                            <td class="px-4 py-2">
                                @foreach ($sale->items as $item)
                                    <span
                                        class="inline-block bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm mr-1 mb-1">
                                        {{ $item->product->name }} x{{ $item->quantity }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">${{ number_format($sale->total, 2) }}</td>
                            <td class="px-4 py-2">{{ $sale->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No sales in this period</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-right">
            <p class="text-xl font-bold">Total Sales: ${{ number_format($totalSales, 2) }}</p>
        </div>

    </div>
</x-app-layout>
