<header class="bg-[var(--primary)] py-3 shadow-md sticky top-0 z-50 text-white">
    <nav class="container flex justify-between items-center gap-10">
        <div class="w-[25%]">
            <a href="{{ route('home') }}">
                <img class="h-[40px]" src="{{ asset(Storage::url($company->logo)) }}" alt="">
            </a>

        </div>
        <div class="w-[50%]">

            <form action="{{ route('compare') }}" method="get">
                <div class="flex">
                    <input class="w-full text-black" type="text" name="q" placeholder="Compare Products By Name">
                    <button type="submit" class="bg-gray-100 text-[var(--primary)] px-4 py-2">Compare</button>
                </div>
            </form>

        </div>
        <div class="w-[25%] flex gap-4 justify-end items-center">
            @if (!Auth::user())
                <a href="{{ route('register') }}">SignUp</a>
                <a href="{{ route('login') }}">Login</a>
            @else
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button>
                        logout
                    </button>
                </form>
                <a class="relative" href="{{route('carts')}}">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                    <span class="absolute bottom-5 -right-1 bg-red-600 h-3 w-3 rounded text-[8px] flex justify-center items-center">
                        {{ count($carts) }}
                    </span>
                </a>
            @endif
        </div>
    </nav>
</header>
