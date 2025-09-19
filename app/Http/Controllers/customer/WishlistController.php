<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    /**
     * Hiển thị danh sách yêu thích
     */
    public function index()
    {
        $wishlistItems = Wishlist::with('product.category')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('customer.wishlist', compact('wishlistItems'));
    }

    /**
     * Thêm/xóa sản phẩm khỏi danh sách yêu thích (AJAX)
     */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $userId = auth()->id();
        $productId = $request->product_id;

        // Kiểm tra sản phẩm có tồn tại và đang kích hoạt không
        $product = Product::active()->find($productId);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại hoặc đã ngừng kinh doanh'
            ], 404);
        }

        $isInWishlist = Wishlist::isInWishlist($userId, $productId);

        if ($isInWishlist) {
            // Xóa khỏi wishlist
            Wishlist::removeFromWishlist($userId, $productId);
            $message = 'Đã xóa khỏi danh sách yêu thích';
            $action = 'removed';
        } else {
            // Thêm vào wishlist
            Wishlist::addToWishlist($userId, $productId);
            $message = 'Đã thêm vào danh sách yêu thích';
            $action = 'added';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'isInWishlist' => !$isInWishlist
        ]);
    }

    /**
     * Xóa sản phẩm khỏi danh sách yêu thích
     */
    public function remove(Request $request, $productId)
    {
        $userId = auth()->id();
        
        Wishlist::removeFromWishlist($userId, $productId);

        return redirect()->route('wishlist.index')
            ->with('success', 'Đã xóa sản phẩm khỏi danh sách yêu thích!');
    }

    /**
     * Xóa tất cả sản phẩm khỏi danh sách yêu thích
     */
    public function clear()
    {
        $userId = auth()->id();
        
        Wishlist::where('user_id', $userId)->delete();

        return redirect()->route('wishlist.index')
            ->with('success', 'Đã xóa tất cả sản phẩm khỏi danh sách yêu thích!');
    }

    /**
     * Chuyển sản phẩm từ wishlist sang cart
     */
    public function moveToCart(Request $request, $productId)
    {
        $userId = auth()->id();
        
        // Kiểm tra sản phẩm có trong wishlist không
        $wishlistItem = Wishlist::where('user_id', $userId)
                               ->where('product_id', $productId)
                               ->first();

        if (!$wishlistItem) {
            return redirect()->route('wishlist.index')
                ->with('error', 'Sản phẩm không có trong danh sách yêu thích!');
        }

        // Kiểm tra sản phẩm còn hàng không
        $product = Product::active()->find($productId);
        if (!$product || $product->stock <= 0) {
            return redirect()->route('wishlist.index')
                ->with('error', 'Sản phẩm đã hết hàng!');
        }

        // Thêm vào cart
        \App\Models\Cart::addToCart($userId, $productId, 1);

        // Xóa khỏi wishlist
        $wishlistItem->delete();

        return redirect()->route('wishlist.index')
            ->with('success', 'Đã chuyển sản phẩm vào giỏ hàng!');
    }
}