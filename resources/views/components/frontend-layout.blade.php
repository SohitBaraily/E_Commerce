<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <title>Document</title>
</head>

<body>
    @include('sweetalert::alert')

    <x-frontend-navbar />
    <main>
        {{ $slot }}
    </main>
</body>

</html>
