@extends('layouts.admin')

@section('title', 'Manage Coupons')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Coupons</h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn-primary">
            Create Coupon
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires At
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($coupons as $coupon)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono font-bold text-leather-800">{{ $coupon->code }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($coupon->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->type === 'percentage' ? $coupon->value . '%' : 'Rs. ' . number_format($coupon->value) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($coupon->is_active && (!$coupon->expires_at || $coupon->expires_at->isFuture()))
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'No Expiry' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No coupons found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $coupons->links() }}
        </div>
    </div>
@endsection