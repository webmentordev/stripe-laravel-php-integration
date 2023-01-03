@extends('layouts.app')
@section('content')
    <section class="w-full">
        <a href="/" class="p-3 px-5 shadow-md rounded-full bg-white text-gray-800 font-bold fixed top-3 left-3"><i class="fas fa-caret-left"></i></a>
        <div class="max-w-4xl m-auto bg-white p-6 text-sm rounded-md mt-6 shadow-md">
            <h1 class="text-gray-800 font-bold text-2xl mb-2">Products Database</h1>
            <form action="{{ route('product.create') }}" method="POST" class="mb-3">
                @csrf
                @if (session('success'))
                    <p class="text-green-600 mb-3">{{ session('success') }}</p>  
                @endif
                <div class="flex items-center">
                    <div class="flex flex-col w-full">
                        <input type="text" name="name" placeholder="Product Name" autocomplete="off"
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        @error('name')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="ml-3 bg-blue-500 h-full py-3 px-5 rounded-md text-white font-semibold">Create</button>
                </div>
            </form>
            @if (count($products) && $products != null)
                <table class="w-full rounded-lg border border-gray-100 overflow-hidden">
                    <tr class="bg-gray-800 text-white">
                        <th class="text-start px-4 py-2">StripeID</th>
                        <th class="text-start">Name</th>
                        <th class="text-start">Active</th>
                        <th class="text-end">Created At</th>
                        <th class="text-end px-4">Edit</th>
                    </tr>
                    @foreach ($products as $item)
                        <tr class="odd:bg-gray-100">
                            <td class="text-start py-3 px-3 max-w-[60px]">{{ $item->stripe_id }}</td>
                            <td class="text-start">{{ $item->name }}</td>
                            <td class="text-start">
                            @if ($item->is_active == true)
                                <span class="p-1 px-3 rounded-lg text-green-600 font-semibold bg-green-600 bg-opacity-20">Active</span>
                            @else
                                <span class="p-1 px-3 rounded-lg text-red-600 font-semibold bg-red-600 bg-opacity-20">Inactive</span>
                            @endif
                            </td>
                            <td class="text-end">{{ $item->created_at->diffForHumans() }}</td>
                            <td class="text-end px-4 text-blue-500 underline">Edit</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="py-2 text-center">No product Exist in Database</p>
            @endif
            @if ($products->hasPages())
                <div class="py-2">
                    {{ $products->links() }}
                </div>
            @endif
            </div>
    </section>
@endsection