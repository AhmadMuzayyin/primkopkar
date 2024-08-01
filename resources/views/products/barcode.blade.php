<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcode</title>
</head>

<body>
    @if ($products->count())
        <div id="ean">
            @foreach ($products as $product)
                <div class="barcode-container">
                    <p>{{ $product->name }}</p>
                    <canvas class="barcode" id="{{ $product->barcode }}" width="200" height="100"></canvas>
                </div>
            @endforeach
        </div>
    @else
        <p>No products found.</p>
    @endif
    <script src="{{ url('assets/js/vendor.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery-ean13.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.barcode').each(function() {
                var barcode = $(this).attr('id');
                $(this).EAN13(barcode);
            });
            setTimeout(() => {
                window.close();
            }, 1000);
        });
    </script>
</body>

</html>
