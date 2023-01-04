@extends('layouts.app')
@section('content')
    <section class="w-full">
        <a href="/" class="p-3 px-5 shadow-md rounded-full bg-white text-gray-800 font-bold fixed top-3 left-3"><i class="fas fa-caret-left"></i></a>
        <div class="max-w-4xl m-auto bg-white p-6 text-sm rounded-md mt-6 shadow-md">
            <h1 class="text-gray-800 font-bold text-2xl mb-2">Price Database</h1>
            <form action="{{ route('price.create') }}" method="POST" class="mb-3">
                @csrf
                @if (session('success'))
                    <p class="text-green-600">{{ session('success') }}</p>
                @endif
                @if (session('failed'))
                    <p class="text-red-600">{{ session('failed') }}</p>
                @endif
                <div class="flex items-center w-full">
                    <div class="flex flex-col w-full mr-2">
                        <input type="number" name="price" id="price" step="0.01" placeholder="Price"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        @error('price')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full mr-2">
                        <select name="currency" id="currency"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            <option value="" selected>Select Currency</option>
                            @foreach ($currency as $item)
                                <option value="{{ $item->code }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('currency')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col w-full mr-2">
                        <select name="product" id="product"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            <option value="" selected>Select Product</option>
                            @foreach ($products as $item)
                                <option value="{{ $item->stripe_id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('product')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"class="bg-blue-500 h-full py-3 px-5 rounded-md text-white font-semibold">Create</button>
                </div>
            </form>
            @if (count($price) && $price != null)
                <table class="w-full rounded-lg border border-gray-100">
                    <tr class="bg-gray-800 text-white">
                        <th class="text-start px-4 py-2">Price_ID</th>
                        <th class="text-start">Price</th>
                        <th class="text-start">Product</th>
                        <th class="text-start">Currency</th>
                        <th class="text-start">Active</th>
                        <th class="text-end">Created At</th>
                        <th class="text-end px-4">Edit</th>
                    </tr>
                    @foreach ($price as $item)
                        <tr class="odd:bg-gray-100">
                            <td class="text-start py-3 px-3">{{ $item->price_id }}</td>
                            <td class="text-start text-blue-400 font-bold">{{ number_format($item->price, 2) }}</td>
                            <td class="text-start">{{ $item->product->name }}</td>
                            <td class="text-start"><span class="p-2 px-4 rounded-lg bg-blue-600 text-white font-bold">{{ $item->currency }}</span></td>
                            <td class="text-start">
                                @if ($item->is_active == true)
                                    <span
                                        class="p-1 px-3 rounded-lg text-green-600 font-semibold bg-green-600 bg-opacity-20">Active</span>
                                @else
                                    <span
                                        class="p-1 px-3 rounded-lg text-red-600 font-semibold bg-red-600 bg-opacity-20">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">{{ $item->created_at->diffForHumans() }}</td>
                            <td class="text-end px-4 text-blue-500 underline">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = ! open">Edit</button>
                                    <div x-show="open" @click.outside="open = false">
                                        <form action="{{ route('price.update', $item->price_id) }}" method="post" class="bg-white p-4 min-w-[300px] rounded-lg absolute shadow-lg z-20">
                                            @method('PUT')
                                            @csrf
                                            <input type="number" name="price" value="{{ $item->price }}" placeholder="Product Price" step="0.01"
                                            class="p-3 rounded-lg border border-gray-100 mb-2 w-full" required>
                                            
                                            <select name="currency" id="currency"
                                            class="p-3 rounded-lg border border-gray-100 mb-2 w-full">
                                                <option value="" selected>Select Currency</option>
                                                @foreach ($currency as $item)
                                                    <option value="{{ $item->code }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            
                                            <button type="submit" class="py-2 w-full bg-blue-600 text-white">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="py-2 text-center">No product Exist in Database</p>
            @endif
            @if ($price->hasPages())
                <div class="py-2">
                    {{ $price->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
