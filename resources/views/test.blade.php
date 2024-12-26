<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="p-10">
        <h1>Cart:</h1>
        <div>
            {{ $cart->uuid }}
        </div>
        <h2>Items:</h2>
        <div>
            {{ $cart->items }}
        </div>

        <form action="{{ route('add-item') }}" method="POST" class="mt-10">
            @csrf
            <button type="submit" class="bg-blue-500 text-white p-3 rounded-md">
                Ajouter un item
            </button>
        </form>

        <form action="{{ route('add-bundle') }}" method="POST" class="mt-10">
            @csrf
            <button type="submit" class="bg-blue-500 text-white p-3 rounded-md">
                Ajouter un bundle
            </button>
        </form>
    </body>
</html>
