<section class="sticky top-3 w-full">
    <nav class="max-w-4xl py-2 px-4 flex justify-between items-center mb-3 rounded-md m-auto bg-black bg-opacity-75 backdrop-blur-md">
        <a href="{{ route('home') }}"><img src="{{ asset('images/stripe_small.png') }}" alt="" width="80px"></a>
        <ul class="flex items-center">
            <a class="py-2 px-4 text-white font-semibold" href="{{ route('products') }}">Products</a>
            <a class="py-2 px-4 text-white font-semibold" href="{{ route('price') }}">Prices</a>
            <a class="py-2 px-4 text-white font-semibold" href="{{ route('paymentlink') }}">Payments</a>
            <a class="py-2 px-4 text-white font-semibold" href="{{ route('currencies') }}">Currencies</a>
            <a class="py-2 px-4 text-white font-semibold" href="{{ route('invoice') }}">Invoices</a>
            <a class="py-2 px-4 text-white font-semibold" href="{{ route('coupon') }}">Coupons</a>
        </ul>
    </nav>
</section>