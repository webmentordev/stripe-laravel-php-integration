@extends('layouts.app')
@section('content')
    <section class="w-full">
        <a href="/" class="p-3 px-5 shadow-md rounded-full bg-white text-gray-800 font-bold fixed top-3 left-3"><i class="fas fa-caret-left"></i></a>
        <div class="max-w-4xl m-auto bg-white p-6 text-sm rounded-md mt-6 shadow-md">
            <h1 class="text-gray-800 font-bold text-2xl mb-2">Currency Database</h1>
            <form action="{{ route('currency.create') }}" method="post" class="mb-3 w-full">
                @csrf
                @if (session('success'))
                    <p class="text-green-600 mb-3">{{ session('success') }}</p>  
                @endif
                <div class="flex items-center w-full">
                    <div class="flex flex-col w-full">
                        <input type="text" name="name" id="name" placeholder="Currency Name" autocomplete="off"
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        @error('name')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col ml-3 w-full">
                        <input type="text" name="code" id="code" placeholder="Currency Code (3 Digit)" autocomplete="off"
                        class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 text-base outline-none text-gray-700 py-2 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                        @error('code')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="ml-3 bg-blue-500 h-full py-3 px-5 rounded-md text-white font-semibold">Create</button>
                </div>
            </form>
            @if (count($currencies) && $currencies != null)
                <table class="w-full rounded-lg border border-gray-100">
                    <tr class="bg-gray-800 text-white">
                        <th class="text-start px-4 py-2">Name</th>
                        <th class="text-start">Code</th>
                        <th class="text-end">Created At</th>
                        <th class="text-end px-4">Edit</th>
                    </tr>
                    @foreach ($currencies as $item)
                        <tr class="odd:bg-gray-100">
                            <td class="text-start py-3 px-3 max-w-[60px]">{{ $item->name }}</td>
                            <td class="text-start">{{ $item->code }}</td>
                            <td class="text-end">{{ $item->created_at->diffForHumans() }}</td>
                            <td class="text-end px-4 text-blue-500 underline">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = ! open">Edit</button>
                                    <div x-show="open" @click.outside="open = false">
                                        <form action="{{ route('currency.update', $item->id) }}" method="post" class="bg-white p-3 min-w-[300px] rounded-lg absolute shadow-lg z-20">
                                            @method('PUT')
                                            @csrf
                                            <input type="text" name="name" value="{{ $item->name }}" placeholder="Currency Name"
                                            class="p-3 rounded-lg border border-gray-100 mb-2 w-full" required>

                                            <input type="text" name="code" value="{{ $item->code }}" placeholder="Currency Code"
                                            class="p-3 rounded-lg border border-gray-100 mb-2 w-full" required>

                                            <button type="submit" class="py-2 w-full bg-blue-600 text-white">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="py-2 text-center">No currency exist in Database</p>
            @endif
            @if ($currencies->hasPages())
                <div class="py-2">
                    {{ $currencies->links() }}
                </div>
            @endif
            </div>
    </section>
@endsection