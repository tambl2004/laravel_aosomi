<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Hiển thị danh sách địa chỉ của user
     */
    public function index()
    {
        $addresses = Address::forUser(auth()->id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.addresses.index', compact('addresses'));
    }

    /**
     * Hiển thị form tạo địa chỉ mới
     */
    public function create()
    {
        return view('customer.addresses.create');
    }

    /**
     * Lưu địa chỉ mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'required|string|max:100',
            'type' => 'required|in:home,office,other',
            'is_default' => 'boolean',
        ], [
            'name.required' => 'Tên người nhận không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'address.required' => 'Địa chỉ chi tiết không được để trống',
            'city.required' => 'Tỉnh/Thành phố không được để trống',
            'district.required' => 'Quận/Huyện không được để trống',
            'ward.required' => 'Phường/Xã không được để trống',
            'type.required' => 'Loại địa chỉ không được để trống',
        ]);

        DB::beginTransaction();
        try {
            // Nếu đặt làm mặc định, bỏ mặc định của các địa chỉ khác
            if ($request->is_default) {
                Address::forUser(auth()->id())->update(['is_default' => false]);
            }

            // Tạo địa chỉ mới
            Address::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'district' => $request->district,
                'ward' => $request->ward,
                'type' => $request->type,
                'is_default' => $request->is_default ?? false,
            ]);

            DB::commit();

            return redirect()->route('addresses.index')
                ->with('success', 'Thêm địa chỉ thành công!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi thêm địa chỉ. Vui lòng thử lại!')
                ->withInput();
        }
    }

    /**
     * Hiển thị form chỉnh sửa địa chỉ
     */
    public function edit(Address $address)
    {
        // Kiểm tra quyền truy cập
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.addresses.edit', compact('address'));
    }

    /**
     * Cập nhật địa chỉ
     */
    public function update(Request $request, Address $address)
    {
        // Kiểm tra quyền truy cập
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'required|string|max:100',
            'type' => 'required|in:home,office,other',
            'is_default' => 'boolean',
        ], [
            'name.required' => 'Tên người nhận không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'address.required' => 'Địa chỉ chi tiết không được để trống',
            'city.required' => 'Tỉnh/Thành phố không được để trống',
            'district.required' => 'Quận/Huyện không được để trống',
            'ward.required' => 'Phường/Xã không được để trống',
            'type.required' => 'Loại địa chỉ không được để trống',
        ]);

        DB::beginTransaction();
        try {
            // Nếu đặt làm mặc định, bỏ mặc định của các địa chỉ khác
            if ($request->is_default && !$address->is_default) {
                Address::forUser(auth()->id())->update(['is_default' => false]);
            }

            // Cập nhật địa chỉ
            $address->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'district' => $request->district,
                'ward' => $request->ward,
                'type' => $request->type,
                'is_default' => $request->is_default ?? false,
            ]);

            DB::commit();

            return redirect()->route('addresses.index')
                ->with('success', 'Cập nhật địa chỉ thành công!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật địa chỉ. Vui lòng thử lại!')
                ->withInput();
        }
    }

    /**
     * Xóa địa chỉ
     */
    public function destroy(Address $address)
    {
        // Kiểm tra quyền truy cập
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        // Không cho phép xóa địa chỉ mặc định nếu còn địa chỉ khác
        if ($address->is_default && Address::forUser(auth()->id())->count() > 1) {
            return redirect()->back()
                ->with('error', 'Không thể xóa địa chỉ mặc định. Vui lòng chọn địa chỉ mặc định khác trước!');
        }

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Xóa địa chỉ thành công!');
    }

    /**
     * Đặt địa chỉ làm mặc định
     */
    public function setDefault(Address $address)
    {
        // Kiểm tra quyền truy cập
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            // Bỏ mặc định của tất cả địa chỉ khác
            Address::forUser(auth()->id())->update(['is_default' => false]);
            
            // Đặt địa chỉ này làm mặc định
            $address->update(['is_default' => true]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Đặt địa chỉ mặc định thành công!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi đặt địa chỉ mặc định!');
        }
    }
}
