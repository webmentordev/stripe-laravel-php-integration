@extends('layouts.app')
@section('content')
    <section class="flex justify-center">
        <div class="bg-white mt-6 rounded-md p-6 max-w-4xl w-full h-fit">
            <h1 class="mb-4 font-bold text-3xl">Coupons Database</h1>
            <form action="{{ route('coupon.create') }}" method="POST" class="mb-2">
                @csrf
                @if (session('success'))
                    <p class="text-green-600">{{ session('success') }}</p>
                @endif
                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div class="flex flex-col">
                        <input type="number" name="percent" placeholder="Percent" step="0.01" required
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        @error('percent')
                            <p class="text-red-600 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div class="flex flex-col">
                        <select name="currency" id="currency"
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        <option value="" selected>Select Currency</option>
                            @foreach ($currency as $item)
                                <option value="{{ $item->code }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('currency')
                            <p class="text-red-600 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mb-2">
                    <div class="flex flex-col">
                        <input type="text" name="code" placeholder="Promo Code" required
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        @error('code')
                            <p class="text-red-600 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex flex-col">
                        <input type="number" name="max" placeholder="Max Redemptions" required
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        @error('max')
                            <p class="text-red-600 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>        
                <button type="submit" class="bg-blue-500 h-full py-2 px-5 rounded-md text-white font-semibold">Create</button>
            </form>
            @if (count($coupons) && $coupons != null)
                <table class="w-full rounded-lg border border-gray-100 overflow-hidden">
                    <tr class="bg-gray-800 text-white">
                        <th class="text-start px-4 py-2">Coupon</th>
                        <th class="text-start px-3 py-2">Coupon_ID</th>
                        <th class="text-start px-3 py-2">Percent_OFF</th>
                        <th class="text-start">Code</th>
                        <th class="text-end px-2">Created At</th>
                    </tr>
                    @foreach ($coupons as $item)
                        <tr class="odd:bg-gray-100 text-sm">
                            <td class="text-start py-3 px-3">{{ $item->coupon_name }}</td>
                            <td class="text-start py-3 px-3">{{ $item->coupon_id }}</td>
                            <td class="text-start py-3 px-3">{{ $item->percent }}</td>
                            <td class="text-start">{{ $item->code }}</td>
                            <td class="text-end px-2">{{ $item->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="py-2 text-center">No coupons exist in Database</p>
            @endif
            @if ($coupons->hasPages())
                <div class="py-2">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection