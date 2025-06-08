@props(['product'])
<a href="{{route('product', $product->id)}}" class="grid grid-cols-3 gap-2 shadow-md hover:shadow-lg p-2">
    <img class="w-full" src="{{ asset(Storage::url($product->images[0])) }}" alt="{{ $product->name }}">

    <div class="col-span-2 ">
        <h2 class="line-clamp-2 font-semibold">
            {{ $product->name }}
        </h2>
        @if ($product->discount > 0)
            <p>
                <span class="line-through text-red-700">NRs.{{ $product->price }}</span>
                {{ $product->price - ($product->price * $product->discount) / 100 }}
            </p>
        @else
            <p>
                NRs.{{ $product->price }}
            </p>
        @endif
    </div>
</a>
