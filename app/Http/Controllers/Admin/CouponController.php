<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = \App\Models\Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons|uppercase',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        \App\Models\Coupon::create($request->all());

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function edit(\App\Models\Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, \App\Models\Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|uppercase|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(\App\Models\Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }
}
