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
        <div class="flex flex-col gap-10">
            @foreach ($cart->items as $item)
                <div class="p-4 bg-gray-100 rounded-md">
                    Product: {{ $item->productVariant->slug }}<br>
                    Bundle: {{ $item->bundle_uuid }}<br>
                    Quantity: {{ $item->quantity }}

                    <form action="{{ route('update-item-quantity') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}">
                        <input type="hidden" name="item_uuid" value="{{ $item->product_variant_uuid }}">
                        <button type="submit" class="bg-blue-500 text-white p-3 rounded-md ml-2">
                            Update quantity
                        </button>
                    </form>

                    <form action="{{ route('remove-item') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="item_uuid" value="{{ $item->product_variant_uuid }}">
                        <button type="submit" class="bg-red-500 text-white p-3 rounded-md ml-2">
                            Remove item
                        </button>
                    </form>
                </div>
            @endforeach
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
