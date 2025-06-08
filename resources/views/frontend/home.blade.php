<x-frontend-layout>
    <section>
        <div class="container py-10">
            <div>
                <h2 class="text-2xl text-[var(--primary)]">Featured Restaurant/Store</h2>
                <p>The nearest restaurant/store to your location</p>
            </div>
            <div class="mt-5 grid md:grid-cols-3 gap-4">
                @foreach ($vendors as $vendor)
                    <a href="{{route('shop', $vendor->id)}}">
                        <div class="shadow-md hover:shadow-lg shadow-[grey] rounded-lg overflow-hidden">
                            <img class="w-full h-[200px] odject-cover" src="{{ asset(Storage::url($vendor->profile)) }}"
                                alt="">
                            <div class="p-3 ">
                                <h3 class="font-semibold">
                                    {{ $vendor->name }}
                                </h3>
                                <p>
                                    {{ $vendor->address }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    <section>
        <div class="w-[66%] m-auto py-20 text-center">
            <h1 class="text-3xl">
                List your Restaurant or Store at Floor Digital Pvt. Ltd.!
                Reach 1,00,000 + new customers.
            </h1>
            <div>
                <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="bg-[var(--primary)] py-1 px-2 rounded-[2px] text-white" type="button">
                    Send A Request
                </button>
                <div id="default-modal" tabindex="-1" aria-hidden="true"
                    class="hidden  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="bg-white p-5">
                        <div>
                            <h1 class="text-[var(--primary)] font-semibold">Welcome to Floor Digital Pvt. Ltd</h1>
                        </div>
                        <form action="{{ route('vendor_request') }}" method="post">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-3 ">
                                <div class="flex flex-col gap-2">
                                    <label for="name">Enter Your Shop Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label for="email">Enter Your Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label for="contact_no">Enter Your Contact Number</label>
                                    <input type="tel" name="contact_no" id="contact_no"
                                        value="{{ old('contact_no') }}">
                                    @error('contact_no')
                                        <p class="text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label for="address">Enter Your Address</label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}">
                                    @error('address')
                                        <p class="text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <button type="submit"
                                        class="bg-[var(--primary)] py-1 px-2 rounded-[2px] text-white">Send
                                        Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>
</x-frontend-layout>
