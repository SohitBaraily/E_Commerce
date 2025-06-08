<header class="bg-[var(--primary)] py-3 shadow-md sticky top-0 z-50">
    <nav class="container flex justify-between items-center gap-10">
        <div class="w-[25%]">
            <a href="{{route('home')}}">
                <img class="h-[40px]" src="{{ asset(Storage::url($company->logo)) }}" alt="">
            </a>

        </div>
        <div class="w-[50%]">

            <form action="{{route('compare')}}" method="get">
                <div class="flex">
                    <input class="w-full" type="text" name="q" placeholder="Compare Products By Name">
                    <button type="submit" class="bg-gray-100 text-[var(--primary)] px-4 py-2">Compare</button>
                </div>
            </form>

        </div>
        <div class="w-[25%]">
            <a href="">SignUp</a>
            <a href="">Login</a>
        </div>
    </nav>
</header>
