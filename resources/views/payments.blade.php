@extends('layouts.app')
@section('content')
    <section class="w-full">
        <a href="/" class="p-3 px-5 shadow-md rounded-full bg-white text-gray-800 font-bold fixed top-3 left-3"><i class="fas fa-caret-left"></i></a>
        <div class="max-w-4xl m-auto bg-white p-6 text-sm rounded-md mt-6 shadow-md">
            <h1 class="text-gray-800 font-bold text-2xl mb-2">Payments Database</h1>
            <form action="{{ route('paymentlink.create') }}" method="POST" class="mb-3">
                @csrf
                @if (session('success'))
                    <p class="text-green-600">{{ session('success') }}</p>
                @endif
                <div class="flex items-center w-full">
                    <div class="flex flex-col w-full mr-2">
                        <select name="price" id="price"
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                <option value="" selected>Select Price</option>
                            @foreach ($price as $item)
                                <option value="{{ $item->price_id }}">{{ $item->price }} - {{ $item->currency }}</option>
                            @endforeach
                        </select>
                        @error('price')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full mr-2">
                        <input type="number" name="quantity" placeholder="Quantity"
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        @error('quantity')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class=" bg-blue-500 h-full py-3 px-5 rounded-md text-white font-semibold">Create</button>
                </div>
            </form>
            @if (count($payments) && $payments != null)
                <table class="w-full rounded-lg border border-gray-100 overflow-hidden">
                    <tr class="bg-gray-800 text-white">
                        <th class="text-start px-4 py-2">Price_ID</th>
                        <th class="text-start">Price</th>
                        <th class="text-start">Quantity</th>
                        <th class="text-end">Created At</th>
                        <th class="text-end px-4">Edit</th>
                        <th class="text-end px-4">Pay</th>
                    </tr>
                    @foreach ($payments as $item)
                        <tr class="odd:bg-gray-100">
                            <td class="text-start py-3 px-3">{{ $item->price_id }}</td>
                            <td class="text-start">{{ $item->price->price }} - {{ $item->price->currency }}</td>
                            <td class="text-start">{{ $item->quantity}}</td>
                            <td class="text-end">{{ $item->created_at->diffForHumans() }}</td>
                            <td class="text-end px-4 text-blue-500 underline">Edit</td>
                            <td class="text-end"><a href="{{ $item->url }}" class="p-2 px-4 rounded-sm font-bold text-white bg-black" target="_blank">Pay</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="py-2 text-center">No product Exist in Database</p>
            @endif
            @if ($payments->hasPages())
                <div class="py-2">
                    {{ $payments->links() }}
                </div>
            @endif
            </div>
    </section>
@endsection