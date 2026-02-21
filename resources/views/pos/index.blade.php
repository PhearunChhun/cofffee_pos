<x-app-layout>
    <x-slot name="header">Point of Sale</x-slot>

    <div class="flex flex-col md:flex-row h-[calc(100vh-4rem)] gap-4 p-4">

        {{-- Left: Product List --}}
        <div class="md:w-2/3 bg-white rounded-lg shadow p-4 overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">Products</h2>

            {{-- Category Filter --}}
            <div class="flex gap-2 mb-4">
                <button data-category="all"
                    class="category-btn bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-700">All</button>
                @foreach ($categories as $category)
                    <button data-category="{{ $category->id }}"
                        class="category-btn bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">{{ $category->name }}</button>
                @endforeach
            </div>

            {{-- Products Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <div class="product-card bg-gray-50 p-3 rounded shadow cursor-pointer"
                        data-category="{{ $product->category_id }}" data-product='@json($product)'>
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                            class="w-full h-32 object-cover rounded mb-2">
                        <h3 class="font-bold text-gray-800">{{ $product->name }}</h3>

                        {{-- Size Selector --}}
                        @if (count($product->sizes) > 0)
                            <select class="size-select w-full mt-2 p-1 border rounded">
                                @foreach ($product->sizes as $size)
                                    <option value="{{ $size->id }}"
                                        data-price="{{ $product->base_price + $size->price_adjustment }}">
                                        {{ $size->name }} (+${{ number_format($size->price_adjustment, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        <p class="text-gray-600">${{ number_format($product->base_price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Right: Cart Panel --}}
        <div class="md:w-1/3 bg-white rounded-lg shadow p-4 flex flex-col">
            <h2 class="text-xl font-bold mb-4">Cart</h2>

            <div class="flex-1 overflow-y-auto mb-4" id="cart-items">
                <p class="text-gray-400">No items in cart</p>
            </div>

            {{-- Totals --}}
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span id="subtotal">$0.00</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax (10%):</span>
                    <span id="tax">$0.00</span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total:</span>
                    <span id="total">$0.00</span>
                </div>
            </div>

            {{-- Checkout --}}
            <form id="checkout-form" class="mt-4">
                @csrf
                <button type="submit"
                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 rounded text-lg">Checkout</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const products = document.querySelectorAll('.product-card');
            const cartItemsEl = document.getElementById('cart-items');
            const subtotalEl = document.getElementById('subtotal');
            const taxEl = document.getElementById('tax');
            const totalEl = document.getElementById('total');
            let cart = [];

            // Add to cart
            products.forEach(p => {
                p.addEventListener('click', () => {
                    const product = JSON.parse(p.dataset.product);

                    // Get selected size
                    let sizeId = null;
                    let price = parseFloat(product.base_price);
                    const select = p.querySelector('.size-select');
                    if (select) {
                        sizeId = select.value;
                        price = parseFloat(select.selectedOptions[0].dataset.price);
                    }

                    const existing = cart.find(item => item.id === product.id && item.size_id ===
                        sizeId);
                    if (existing) existing.qty++;
                    else cart.push({
                        ...product,
                        qty: 1,
                        size_id: sizeId,
                        price: price
                    });

                    renderCart();
                });
            });

            // Render cart
            function renderCart() {
                if (cart.length === 0) {
                    cartItemsEl.innerHTML = '<p class="text-gray-400">No items in cart</p>';
                    subtotalEl.textContent = '$0.00';
                    taxEl.textContent = '$0.00';
                    totalEl.textContent = '$0.00';
                    return;
                }

                cartItemsEl.innerHTML = '';
                let subtotal = 0;

                cart.forEach((item, index) => {
                    const row = document.createElement('div');
                    row.classList.add('flex', 'justify-between', 'mb-2', 'items-center');

                    const sizeName = item.size_id ? item.sizes?.find(s => s.id == item.size_id)?.name : '';
                        row.innerHTML = `
                        <div>
                            <p class="font-bold">${item.name} ${sizeName ? '(' + sizeName + ')' : ''}</p>
                            <p class="text-gray-500 text-sm">$${item.price.toFixed(2)} x ${item.qty}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button data-index="${index}" class="decrease px-2 bg-gray-200 rounded">-</button>
                            <button data-index="${index}" class="increase px-2 bg-gray-200 rounded">+</button>
                            <button data-index="${index}" class="remove px-2 text-red-600">x</button>
                        </div>
                    `;
                    cartItemsEl.appendChild(row);

                    subtotal += item.price * item.qty;
                });

                subtotalEl.textContent = '$' + subtotal.toFixed(2);
                const tax = subtotal * 0.1;
                taxEl.textContent = '$' + tax.toFixed(2);
                totalEl.textContent = '$' + (subtotal + tax).toFixed(2);

                // Add event listeners
                document.querySelectorAll('.increase').forEach(btn => {
                    btn.addEventListener('click', e => {
                        const idx = e.target.dataset.index;
                        cart[idx].qty++;
                        renderCart();
                    });
                });
                document.querySelectorAll('.decrease').forEach(btn => {
                    btn.addEventListener('click', e => {
                        const idx = e.target.dataset.index;
                        if (cart[idx].qty > 1) cart[idx].qty--;
                        renderCart();
                    });
                });
                document.querySelectorAll('.remove').forEach(btn => {
                    btn.addEventListener('click', e => {
                        const idx = e.target.dataset.index;
                        cart.splice(idx, 1);
                        renderCart();
                    });
                });
            }

            // Checkout submit
            document.getElementById('checkout-form').addEventListener('submit', async e => {
                e.preventDefault();
                if (cart.length === 0) return alert('Cart is empty');

                // Checkout POST request
                fetch("{{ route('pos.checkout') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: cart
                        }) // <-- important!
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        cart = [];
                        renderCart();
                    })
                    .catch(err => console.error(err));
            });
            // Category filter
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const cat = btn.dataset.category;
                    products.forEach(p => {
                        if (cat === 'all' || p.dataset.category == cat) p.style.display =
                            'block';
                        else p.style.display = 'none';
                    });
                });
            });
        });
    </script>
</x-app-layout>
