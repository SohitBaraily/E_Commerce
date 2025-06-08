<x-frontend-layout>
    <section style="background-image: url({{ Asset(Storage::url($vendor->profile)) }})" class="h-[500px] w-full ">
        <div class="container relative h-full">

            <div class="bg-[#00000090] flex items-center gap-4 text-white px-4 py-2 absolute bottom-0 right-0 w-full">
                <div>
                    <img class="w-[120px]" src="{{ asset(Storage::url($vendor->profile)) }}" alt="">
                </div>
                <div>
                    <h1>
                        {{ $vendor->name }}
                    </h1>
                    <p class="text-white">
                        {{ $vendor->address }}
                    </p>
                </div>
            </div>


        </div>
    </section>

    <section>
        <div class="container grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8 py-10">
            @foreach ($products as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>
    </section>
</x-frontend-layout>
