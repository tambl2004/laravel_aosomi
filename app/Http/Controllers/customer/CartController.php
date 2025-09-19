<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $cartItems = Cart::with('product.category')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $totalItems = $cartItems->sum('quantity');

        return view('customer.cart', compact('cartItems', 'totalAmount', 'totalItems'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng (AJAX)
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:10'
        ]);

        $userId = auth()->id();
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        // Kiểm tra sản phẩm có tồn tại và đang kích hoạt không
        $product = Product::active()->find($productId);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại hoặc đã ngừng kinh doanh'
            ], 404);
        }

        // Kiểm tra số lượng tồn kho
        $currentCartQuantity = Cart::where('user_id', $userId)
                                  ->where('product_id', $productId)
                                  ->sum('quantity');

        if (($currentCartQuantity + $quantity) > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng trong giỏ hàng vượt quá tồn kho có sẵn'
            ], 400);
        }

        // Thêm vào cart
        Cart::addToCart($userId, $productId, $quantity);

        $totalItems = Cart::getTotalItems($userId);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
            'totalItems' => $totalItems
        ]);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng (AJAX)
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0|max:10'
        ]);

        $userId = auth()->id();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cartItem = Cart::where('user_id', $userId)
                       ->where('product_id', $productId)
                       ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không có trong giỏ hàng'
            ], 404);
        }

        if ($quantity == 0) {
            $cartItem->delete();
            $message = 'Đã xóa sản phẩm khỏi giỏ hàng';
        } else {
            // Kiểm tra số lượng tồn kho
            $product = Product::active()->find($productId);
            if ($quantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá tồn kho có sẵn'
                ], 400);
            }

            $cartItem->updateQuantity($quantity);
            $message = 'Đã cập nhật số lượng sản phẩm';
        }

        $totalAmount = Cart::getTotalAmount($userId);
        $totalItems = Cart::getTotalItems($userId);

        return response()->json([
            'success' => true,
            'message' => $message,
            'totalAmount' => $totalAmount,
            'totalItems' => $totalItems
        ]);
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove(Request $request, $productId)
    {
        $userId = auth()->id();
        
        Cart::removeFromCart($userId, $productId);

        return redirect()->route('cart.index')
            ->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Xóa tất cả sản phẩm khỏi giỏ hàng
     */
    public function clear()
    {
        $userId = auth()->id();
        
        Cart::clearCart($userId);

        return redirect()->route('cart.index')
            ->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Lấy thông tin giỏ hàng (AJAX)
     */
    public function info(): JsonResponse
    {
        $userId = auth()->id();
        
        $totalItems = Cart::getTotalItems($userId);
        $totalAmount = Cart::getTotalAmount($userId);

        return response()->json([
            'totalItems' => $totalItems,
            'totalAmount' => $totalAmount
        ]);
    }
}