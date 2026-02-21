<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
        $products = Product::with('sizes', 'category')->get();
        $cart = session()->get('cart', []);

        return view('pos.index', compact('products', 'cart'));
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

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Cart is empty');
        }

        DB::transaction(function () use ($cart) {

            $total = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total_amount' => $total
            ]);

            foreach ($cart as $item) {

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'size_id' => $item['size_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                $product = Product::find($item['product_id']);
                $product->decrement('stock', $item['quantity']);
            }

        });

        session()->forget('cart');

        return redirect()->route('pos.index')
            ->with('success', 'Sale completed');
    }
}
