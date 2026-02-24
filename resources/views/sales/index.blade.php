<x-app-layout>
    <x-slot name="header">Sale</x-slot>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white shadow rounded-lg overflow-hidden p-4">

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-blue-400 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Cashier</th>
                        <th class="px-4 py-2 text-left">Items</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Actions</th>
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
                            <td class="px-4 py-2">${{ number_format($sale->total_amount, 2) }}</td>
                            <td class="px-4 py-2">{{ $sale->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('sales.show', $sale) }}"
                                    class="text-yellow-500 hidden px-3 py-1 rounded">View</a>
                                <form action="{{ route('sales.destroy', $sale) }}" method="POST"
                                    onsubmit="return confirm('Delete this sale?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class=" text-red-500 px-3 py-1 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">No sales yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sales->links() }}
        </div>
    </div>
</x-app-layout>
