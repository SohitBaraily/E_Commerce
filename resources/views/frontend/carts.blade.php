<x-frontend-layout>
    <section class="py-10">
        <div class="container">
            <div>
                <h1 class="text-2xl font-semibold">Carts</h1>
            </div>
            <div>
                @foreach ($vendors as $vendor)
                    <div class="mt-5">
                        <h2 class="text-xl mb-2">
                            {{ $vendor->name }}'s Cart
                        </h2>
                        <table class="w-full text-center">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th>S.N.</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedCarts[$vendor->id] as $index => $cart)
                                    <tr class="border-b border-gray-400">
                                        <td class="p-2">{{ $index + 1 }}</td>
                                        <td class="p-2">{{ Str::limit($cart->product->name, 25, '...') }}</td>
                                        <td class="p-2">{{ $cart->product->price }}</td>
                                        <td class="p-2">{{ $cart->quantity }}</td>
                                        <td class="p-2">{{ $cart->product->price * $cart->quantity }}</td>
                                        <td class="p-2">
                                            <!-- Optional: Remove button or other actions -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right mt-5">
                            <a href="{{route('checkout', $vendor->id)}}" class="bg-[var(--primary)] text-white px-4 py-2 rounded">
                                Check Out
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend-layout>
