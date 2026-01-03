@extends('layouts.admin')

@section('title', 'Deals')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-leather-900">All Deals</h3>
            <a href="{{ route('admin.deals.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gold-600 hover:bg-gold-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                Create Deal
            </a>
        </div>
        <div class="border-t border-neutral-200">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Discount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Duration</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @foreach($deals as $deal)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-leather-900">{{ $deal->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-leather-900">
                                @if($deal->discount_type === 'percentage')
                                    {{ $deal->discount_value }}% Off
                                @else
                                    Rs. {{ number_format($deal->discount_value) }} Off
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-neutral-500">
                                {{ $deal->start_date ? $deal->start_date->format('M d, Y') : 'N/A' }} - 
                                {{ $deal->end_date ? $deal->end_date->format('M d, Y') : 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $deal->is_active && $deal->isValid() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $deal->is_active && $deal->isValid() ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.deals.edit', $deal->id) }}" class="text-gold-600 hover:text-gold-900 mr-4">Edit</a>
                            <form action="{{ route('admin.deals.destroy', $deal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-neutral-200 sm:px-6">
            {{ $deals->links() }}
        </div>
    </div>
@endsection
