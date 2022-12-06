@extends('layouts.app')
@section('content')
    <section class="flex justify-center">
        <div class="bg-white mt-6 rounded-md p-6 max-w-4xl w-full h-fit">
            <h1 class="mb-4 font-bold text-3xl">Invoice Database</h1>
            <form action="{{ route('invoice.create') }}" method="POST">
                @csrf
                @if (session('success'))
                    <p class="text-green-600">{{ session('success') }}</p>
                @endif
                @if (session('failed'))
                    <p class="text-red-600">{{ session('failed') }}</p>
                @endif
                <div class="py-2">
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div class="flex flex-col">
                            <select name="product" id="product"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 mb-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            <option value="" selected>Select Product</option>
                                @foreach ($products as $item)
                                    <option value="{{ $item->stripe_id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('product')
                                <p class="text-red-600 mb-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <select name="currency" id="currency"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 mb-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
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
    
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div class="flex flex-col">
                            <input type="number" name="price" placeholder="Price" step="0.01"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 mb-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            @error('price')
                                <p class="text-red-600 mb-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex flex-col">
                            <input type="number" name="expire" placeholder="Expire"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 mb-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            @error('expire')
                                <p class="text-red-600 mb-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
    
                    <div class="grid grid-cols-2 gap-3 mb-2">
                        <div class="flex flex-col">
                            <input type="text" name="name" placeholder="Customer Name"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 mb-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            @error('name')
                                <p class="text-red-600 mb-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <input type="email" name="email" placeholder="Customer Email"
                            class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 mb-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                            @error('email')
                                <p class="text-red-600 mb-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class=" bg-blue-500 h-full py-3 px-5 rounded-md text-white font-semibold">Send invoice</button>
                </div>
            </form>
            @if (count($invoices) && $invoices != null)
                <table class="w-full rounded-lg border border-gray-100 overflow-hidden">
                    <tr class="bg-gray-800 text-white">
                        <th class="text-start px-4 py-2">Invoice_ID</th>
                        <th class="text-start">Customer</th>
                        <th class="text-start">Email</th>
                        <th class="text-end">Created At</th>
                        <th class="text-end px-4">Resend</th>
                    </tr>
                    @foreach ($invoices as $item)
                        <tr class="odd:bg-gray-100 text-sm">
                            <td class="text-start py-3 px-3">{{ $item->invoice_id }}</td>
                            <td class="text-start">{{ $item->name}}</td>
                            <td class="text-start">{{ $item->email}}</td>
                            <td class="text-end">{{ $item->created_at->diffForHumans() }}</td>
                            <td class="text-end"><form action="{{ route('invoice.resend', $item->id) }}" method="post"> @csrf
                                <button class="py-2 bg-gray-900 rounded-md text-white px-4" type="submit">Resend ({{ $item->resends }})</button></form></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="py-2 text-center">No Invoice Exist in Database</p>
            @endif
            @if ($invoices->hasPages())
                <div class="py-2">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection