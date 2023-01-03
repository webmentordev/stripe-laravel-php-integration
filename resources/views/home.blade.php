@extends('layouts.app')
@section('content')
    <section class="h-screen flex justify-center">
        <div class="bg-white mt-6 rounded-md p-6 max-w-4xl w-full h-fit">
            <div class="flex items-center justify-between mb-3">
                <h1 class="mb-4 font-bold text-3xl">Welcome to Home Page 👋</h1>
                @if ($cart > 0)
                    <div class="flex">
                        <form action="{{ route('destroy.cart') }}" method="POST">
                            @csrf
                            <button class="bg-red-700 rounded-md text-white font-bold py-2 px-4 mr-2" type="submit">Empty Cart</button>
                        </form>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <button class="bg-green-700 rounded-md text-white font-bold py-2 px-4" type="submit">Checkout Now</button>
                        </form>
                    </div>
                @endif
            </div>
            @if (session('success'))
                <p class="text-green-600 mb-2">{{ session('success') }}</p>
            @endif
            @if (session('failed'))
                <p class="text-red-600 mb-2">{{ session('failed') }}</p>
            @endif
            @error('quantity')
                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror
            @if (count($products) && $products != null)
                @foreach ($products as $item)
                <div class="flex flex-col">
                    @foreach ($item->prices as $price_item)
                        <div class="flex items-center justify-between bg-gray-100 rounded-md p-6 mb-3">
                            <h2>{{ $item->name }}</h2>
                            @if ($price_item->payment == null)
                                <span class="bg-black rounded-md text-white py-2 px-4">Create Payment link</span>
                            @else
                                <a class="bg-black rounded-md text-white py-2 px-4" href="{{ $price_item->payment->url }}">Pay {{ $price_item->price }} {{ $price_item->currency  }}</a>
                                <form action="{{ route('add.cart', $price_item->price_id) }}" method="POST">
                                    @csrf
                                    <div class="flex items-center">
                                        <input type="number" name="quantity" required placeholder="Quantity" value="1" class="bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out mr-2">
                                        <button class="bg-black rounded-md text-white py-2 px-4" type="submit">Add To Cart</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endforeach
            @else
                <p class="py-2 text-center">No product exist in the database!</p>
            @endif
            @if ($products->hasPages())
                <div class="py-2 bg-gray-100">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection