<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function getUserCart(Request $request)
    {
        $data = Cart::where(['user_id' => $request->user()->id])
            ->with(['product'])->get();

        return response()->json(['data' => $data]);
    }

    public function increaseCartQty(Request $request, int $productId)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id, 'product_id' => $productId], ['user_id' => $request->user()->id, 'product_id' => $productId, 'quantity' => 0]);

        $cart->quantity += 1;

        $cart->save();

        return response()->json(['message' => 'Berhasil menambah data']);
    }

    public function decreaseCartQty(Request $request, int $productId)
    {
        $cart = Cart::where(['user_id' => $request->user()->id, 'product_id' => $productId])->first();

        $cart->quantity -= 1;

        $cart->save();

        if ($cart->quantity <= 0) {
            $cart->delete();
        }

        return response()->json(['message' => 'Berhasil mengurang data']);
    }

    public function removeCart(Request $request, int $productId)
    {
        $cart = Cart::where(['user_id' => $request->user()->id, 'product_id' => $productId])->first();
        $cart->delete();

        return response()->json(['message' => 'Berhasil menghapus data']);
    }
}
