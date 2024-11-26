<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Helpers\Toast;
use App\Models\Coupon;
use App\Enums\CouponType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    //
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }
    public function create()
    {
        return view('admin.coupons.create');
    }
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|unique:coupons,code',
                'value' => 'required|integer',
                'type' => [
                    'required',
                    Rule::in(CouponType::getValues()),
                ],
                'description' => 'required|string',
                'usage_limit' => 'nullable|integer',
                'min_amount' => 'required|nullable|integer',
                'max_amount' => 'nullable|integer'
            ]);
            DB::table('coupons')->insert([
                'code' => $request->code,
                'value' => $request->value,
                'type' => $request->type,
                'description' => $request->description,
                'min_amount' => $request->min_amount ?? null,
                'max_amount' => $request->max_amount ?? null,
                'start_date' => Carbon::now(),
                'expiry_date' => Carbon::now()->addDays(rand(1, 30)),
                'usage_limit' => $request->usage_limit ?? null,
                'usage_count' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            Toast::success('Thêm thành công!');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Toast::success('Thêm thất bại!');
        }
        return redirect()->route('admin.coupons.index');
    }
    public function update(Request $request, $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $request->validate([
                'code' => [
                    'required',
                    Rule::unique('coupons')->ignore($coupon->id),
                ],
                'value' => 'required|integer',
                'type' => [
                    'required',
                    Rule::in(CouponType::getValues()),
                ],
                'description' => 'required|string',
                'usage_limit' => 'nullable|integer',
                'min_amount' => 'required|nullable|integer',
                'max_amount' => 'nullable|integer'
            ]);
            $coupon->update($request->except(['_token', '_method']));
            Toast::success('Sửa thành công!');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Toast::success('Sửa thất bại!');
        }
        return redirect()->route('admin.coupons.index');
    }
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        if ($coupon->delete()) {
            Toast::success('Xóa thành công!');
        } else {
            Toast::error('Xóa thất bại!');
        }
        return redirect()->back();
    }
}
