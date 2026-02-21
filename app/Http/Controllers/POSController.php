<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
class POSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch products with relationships
        $products = Product::with('sizes', 'category')->get();

        // Fetch all categories for filter buttons
        $categories = Category::all();

        // Optional: load cart from session
        $cart = session()->get('cart', []);

        return view('pos.index', compact('products', 'categories', 'cart'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $size = Size::findOrFail($request->size_id);

        $cart = session()->get('cart', []);

        $key = $product->id . '-' . $size->id;

        $price = $product->base_price + $size->price_adjustment;

        if (isset($cart[$key])) {
            $cart[$key]['quantity']++;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'size_id' => $size->id,
                'name' => $product->name . ' (' . $size->name . ')',
                'price' => $price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return back();
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->key])) {
            $cart[$request->key]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);

        return back();
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        unset($cart[$request->key]);

        session()->put('cart', $cart);

        return back();
    }
    public function updateSessionCart(Request $request)
    {
        session()->put('cart', $request->cart ?? []);
        return response()->json(['message' => 'Cart saved']);
    }
    public function checkout(Request $request)
    {

        $cart = $request->items ?? [];
        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::transaction(function () use ($cart) {

            // Compute total safely
            $total = collect($cart)->sum(function ($item) {
                // Use qty if exists, else fallback to quantity
                $qty = $item['qty'] ?? $item['quantity'] ?? 1;
                $price = $item['base_price'] ?? $item['price'] ?? 0;
                return $price * $qty;
            });

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
            ]);

            foreach ($cart as $item) {
                $qty = $item['qty'] ?? $item['quantity'] ?? 1;
                $price = $item['base_price'] ?? $item['price'] ?? 0;
                \Log::error($item);
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'size_id' => $item['sizes'][0]['id'] ?? null,
                    'quantity' => $qty,
                    'price' => $price,
                ]);

                $product = Product::find($item['id']);
                if ($product)
                    $product->decrement('stock', $qty);
            }
        });

        // Clear cart
        session()->forget('cart');

        return response()->json(['message' => 'Sale completed successfully']);
    }
}

