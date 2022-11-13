<!DOCTYPE html>
<html lang="ar" dir="rtl">

@php
    
    // header('Access-Control-Allow-Origin: *');
    
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cookie;
    use App\Models\Setting;
    use App\Models\Item;
    use App\Services\CheckService;
    use App\Services\GetService;
    
    $products = GetService::getCartProducts(CheckService::checkCartAndGetId());
    
    $navItems = Item::all();
    
    $store = Setting::latest()->firstOrNew();
    
@endphp

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->store_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset("storage/$store->store_logo") }}">

</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark main-nav">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">{{ $store->store_name }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-center align-items-center">
                        @if (Auth::check())
                            <li class="nav-item">
                                <a class="nav-link active btn btn-success" aria-current="page"
                                    href="{{ route('dashboard.index') }}">لوحة
                                    التحكم</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">الرئيسية</a>
                        </li>

                        <li class="nav-item dropdown d-flex flex-column justify-content-center align-items-center">
                            <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                الاصناف
                            </a>
                            <ul class="dropdown-menu text-center items-menu" aria-labelledby="navbarDropdown">
                                @foreach ($navItems as $item)
                                    <li><a class="dropdown-item"
                                            href="{{ route('products.view', $item->id) }}">{{ $item->item_name }}</a>
                                    </li>
                                    <hr class="dropdown-divider">
                                @endforeach



                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('feedback') }}">رأيك يهمنا</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('contact') }}">تواصل معنا</a>
                        </li>
                    </ul>
                    <form id="product-search" class="d-flex">
                        @csrf
                        <input name="search" id="search" class="form-control me-2" type="search"
                            placeholder="بحث عن منتج" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">بحث</button>
                    </form>
                </div>
            </div>
        </nav>

    </header>
    <main class="">
        @yield('content')
    </main>
    <div class="mycart" dir="ltr">
        <div class="products">
            @foreach ($products as $product)
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div id="product{{ $product->id }}" class="product product{{ $product->id }}">
                        <form class="d-flex flex-column justify-content-center align-items-center product-delete"
                            method="POST" id="">
                            @csrf
                            @method('DELETE')
                            <input type="text" class="product-id" name="product_id" value="{{ $product->id }}"
                                hidden>
                            <input type="text" class="product-price" name="product_price"
                                value="{{ $product->product_price }}" hidden>
                            <h6 class="text-white product-name" name="product_name">
                                {{ $product->product_name }}</h6>
                            <h6 class="text-white product-new-price" dir="rtl" name="product_price">
                                {{ number_format($product->product_price * $product->pivot->product_amount) }}

                                {{ $store->store_currency }}

                            </h6>
                            <div class="form-group" dir="rtl">
                                <label class="text-dark" for="">الكمية</label>
                                <input min="1" type="number" value="{{ $product->pivot->product_amount }}"
                                    class="form-control text-center product-amount" name="product_amount"
                                    id="">
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger inside-cart-decrease">-</button>
                                <button type="button" class="btn btn-success inside-cart-increase">+</button>
                            </div>
                            <button type="submit"
                                class="btn btn-danger delete d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-trash"></i>
                                ازالة
                            </button>
                        </form>
                    </div>
                    <hr>
                </div>
            @endforeach
            <div class="buttons d-flex justify-content-around">
                <button type="button" id="delete-all"
                    class="btn btn-danger d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-trash"></i>
                    ازالة الكل
                </button>
                <button type="button" id="buy-all"
                    class="btn btn-success d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-cash-register"></i>
                    شراء الكل
                </button>
            </div>
        </div>
        <div class="container">
            <div id="products-count" class="text-danger bg-white d-flex justify-content-center align-items-center">
                0
            </div>
            <i class="fa-solid fa-cart-shopping" class="btn btn-primary"></i>
        </div>
    </div>
    <footer dir="ltr" class="footer bg-dark d-flex flex-column justify-content-center align-items-center">
        <div class="made d-flex justify-content-center align-items-center">
            <p class="title">made by monty</p>
            <p class="fas fa-heart text-danger" style="margin-left: 5px"></p>
        </div>
        <div class="contact d-flex justify-content-center align-items-center">
            <p class="title">contact:</p>
            <a style="margin-left: 5px" target="_blank" href="https://www.facebook.com/KING231MONTSER">
                <p class="fab fa-facebook facebook"></p>
            </a>
        </div>
    </footer>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
    @stack('ajax')
    <script>
        //  $("input[type=date]").val(new Date().toISOString().slice(0, 10));

        // let addToCart = $(".add-to-cart");

        $("#products-count").text($(".mycart .products .product-name").length);

        $(document).on("click", ".add-to-cart", function() {
            //  alert("success");
            let productId = $(this).parent().find(".product-id").val(),
                productNewPrice = $(this).parent().find(".product-new-price").text(),
                productPrice = $(this).parent().find(".product_price").text()
            productName = $(this).parent().find(".product_name").text(),
                productAmount = $(this).parent().find(".product-amount").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "post",
                url: "{{ route('carts.store') }}",
                data: {
                    "product_id": productId
                },
                dataType: "json",
                //  processData: false,
                //  contentType: false,
                success: function(response) {

                    let product = $(".mycart #product" + productId + "");

                    if (product.length < 1) {


                        product =
                            '<div class="d-flex flex-column justify-content-center align-items-center">' +
                            '<div id="product' + productId +
                            '" class="product product' + productId +
                            '">' +
                            '<form class="d-flex flex-column justify-content-center align-items-center product-delete" method="POST" id="">' +
                            '@csrf' +
                            '@method('DELETE')' +
                            '<input type="text" class="product-id" name="product_id" value="' +
                            productId +
                            '"hidden>' +
                            '<input type="text" class="product-price" name="product_price"' +
                            'value="' + productPrice + '" hidden>' +
                            '<h6 class="text-white product-name" name="product_name">' +
                            '    ' + productName + '</h6>' +
                            '<h6 class="text-white product-new-price" dir="rtl" name="product_price">' +
                            '' + productNewPrice + '' +

                            '</h6>' +
                            ' <div class="form-group" dir="rtl">' +
                            ' <label class="text-dark" for="">الكمية</label>' +
                            '<input min="1" type="number" value="' + productAmount + '"' +
                            'class="form-control text-center product-amount" name="product_amount" id="">' +
                            '</div>' +
                            '<div>' +
                            '<button type="button" class="btn btn-danger inside-cart-decrease">-</button>' +
                            '<button type="button" class="btn btn-success inside-cart-increase">+</button>' +
                            '</div>' +
                            '<button type="submit" class="btn btn-danger delete d-flex justify-content-center align-items-center">' +
                            '<i class="fa-solid fa-trash"></i>' +
                            'ازالة' +
                            '</button>' +
                            ' </form>' +
                            ' </div>' +
                            '<hr>' +
                            '</div>';

                        $(".mycart .products").append(product);
                        $("#products-count").text($(".mycart .products .product-name").length);

                    }


                },
                error: function(response) {


                    let errors = response.responseJSON;

                }

            });

        });

        $(document).on("change", ".main-products .product-amount", function() {

            let productId = $(this).parent().parent().parent().parent().find(".product-id").val(),
                productAmount = $(this).val(),
                productPrice = $(".product" + productId + " .product_price"),
                // url = "{{ route('carts.update', '') }}/" + productId + "",
                url = "{{ route('carts.update.post', '') }}/" + productId + "",

                productNewPrice = parseFloat(productPrice.text().replace(/\D/g, "")) * productAmount;

            $(".product" + productId + " .product-amount").val(productAmount);
            $(".product" + productId + " .product-new-price").text(productNewPrice.toLocaleString() +
                " {{ $store->store_currency }}");



            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "post",
                url: url,
                data: {
                    "product_id": productId,
                    "product_amount": productAmount,
                },
                dataType: "json",
                //  processData: false,
                //  contentType: false,
                success: function(response) {


                    // console.log(response);



                },
                error: function(response) {


                    let errors = response.responseJSON;

                }

            });

        });

        $(document).on("click", ".mycart #delete-all", function() {


            let deleteAll = confirm("هل أنت متأكد من إزالة جميع المنتجات من السلة؟");
            if (deleteAll) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('carts.destroy.all') }}",
                    data: "",
                    dataType: "json",
                    success: function(response) {

                        $(".mycart .products > *:not(.buttons)").remove();
                        $("#products-count").text(0);


                    },
                    error: function(response) {


                        let errors = response.responseJSON;
                        // console.log(errors);

                    }

                });
            }
        });
        $(document).on("click", ".mycart #buy-all", function() {

            let productNames = $(".mycart .product .product-name"),
                productAmouts = $(".mycart .product .product-amount"),
                products = "";
            for (let x = 0; x < productNames.length; x++) {
                products += productAmouts[x].value + " " + productNames[x].innerText;
                if (x < productNames.length - 1)
                    products += " و ";

            }
            let url =
                "https://wa.me/{{ $store->whatsapp_phone }}?text=اريد شراء " + products + "";


            open(url);




        });
        $(document).on("submit", "form.product-delete", function() {
            $(this).parent().parent().remove();


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "post",
                url: "{{ route('carts.destroy', 0) }}",
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(response) {


                    $("#products-count").text($(".mycart .products .product-name").length);

                    // console.log(response);




                },
                error: function(response) {


                    let errors = response.responseJSON;
                    // console.log(errors);

                }

            });
        });

        $(document).on("change", ".mycart .product-amount", function() {


            let productId = $(this).parent().parent().find(".product-id").val(),
                productAmount = $(this).val(),
                // url = "{{ route('carts.update', '') }}/" + productId + "",
                url = "{{ route('carts.update.post', '') }}/" + productId + "",

                productPrice = $(".mycart #product" + productId + " .product-price"),
                productNewPrice = parseFloat(productPrice.val().replace(/\D/g, "")) * productAmount;


            $(".product" + productId + " .product-amount").val(productAmount);
            $(".product" + productId + " .product-new-price").text(productNewPrice.toLocaleString() +
                " {{ $store->store_currency }}");


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                method: "post",
                url: url,
                data: {
                    "product_id": productId,
                    "product_amount": productAmount,
                },
                dataType: "json",
                //  processData: false,
                //  contentType: false,
                success: function(response) {


                    // console.log(response);



                },
                error: function(response) {


                    let errors = response.responseJSON;

                }

            });
        });
        /*
                $(document).on("click", ".mycart .inside-cart-increase", function() {

                    // $(document).on("change", ".mycart input[type='number']", function() {

                    let productId = $(this).parent().parent().find(".product-id").val();
                    let productAmount = $("#product" + productId + "").find(".product-amount").val();

                    console.log(productAmount);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method: "put",
                        url: "{{ route('carts.update', 0) }}",
                        data: {
                            "product_id": productId,
                            "product_amount": productAmount,
                        },
                        dataType: "json",
                        //  processData: false,
                        //  contentType: false,
                        success: function(response) {


                            // console.log(response);



                        },
                        error: function(response) {


                            let errors = response.responseJSON;
                            console.log(errors);

                        }

                        // });
                    });
                });
                $(document).on("click", ".mycart .inside-cart-decrease", function() {
                    //  alert("success");

                    let productId = $(this).parent().parent().find(".product-id").val();
                    let productAmount = $("#product" + productId + "").find(".product-amount").val();
                    console.log(productAmount);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        method: "put",
                        url: "{{ route('carts.update', 0) }}",
                        data: {
                            "product_id": productId,
                            "product_amount": productAmount
                        },
                        dataType: "json",
                        //  processData: false,
                        //  contentType: false,
                        success: function(response) {


                            // console.log(response);



                        },
                        error: function(response) {


                            let errors = response.responseJSON;
                            console.log(errors);

                        }

                    });
                });
        */
        // Search For Products //
        $("form#product-search").on("submit", function(e) {
            e.preventDefault();



            let main = $("main");


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "get",
                url: "{{ route('search', 1) }}",
                data: {
                    "search": $("#search").val()
                },
                // dataType: "json",
                beforeSend: function() {

                    main.addClass("d-flex justify-content-center");
                    main.empty();

                    $("main").append(
                        '<div class="d-flex spinner mar-3"><p>جار البحث...</p>' +
                        '<div class="spinner-border text-primary margin-1" role="status"></div>' +
                        '</div>'
                    );
                },
                complete: function() {
                    $(".spinner").remove();
                },
                success: function(response) {
                    $(".alert").remove();


                    main.removeClass("d-flex justify-content-center");
                    main.empty();

                    main.append(response);




                },
                error: function(response) {

                    $(".alert").remove();

                    main.removeClass("d-flex justify-content-center");
                    main.empty();

                    let errors = response.responseJSON.errors;



                }

            });
        });

        // Search For Products //
        $("#search").on("keyup change", function(e) {
            e.preventDefault();


            let main = $("main");



            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "get",
                url: "{{ route('search', 1) }}",
                data: {
                    "search": $("#search").val()
                },
                // dataType: "json",
                beforeSend: function() {

                    main.addClass("d-flex justify-content-center");
                    main.empty();

                    $("main").append(
                        '<div class="d-flex spinner mar-3"><p>جار البحث...</p>' +
                        '<div class="spinner-border text-primary margin-1" role="status"></div>' +
                        '</div>'
                    );
                },
                complete: function() {
                    $(".spinner").remove();
                },
                success: function(response) {

                    $(".alert").remove();

                    main.removeClass("d-flex justify-content-center");
                    main.empty();

                    main.append(response);




                },
                error: function(response) {


                    $(".alert").remove();

                    main.removeClass("d-flex justify-content-center");
                    main.empty();

                    let errors = response.responseJSON.errors;



                }

            });
        });
        //Load Products By Page Link//

        $(document).on("click", "form#search .pagination .page-link", function(e) {
            e.preventDefault();


            let pageNumber = parseInt($(this).text());

            if ($(this).attr("rel") == "prev")
                pageNumber = parseInt($("form#search .pagination .active").text()) - 1;
            else if ($(this).attr("rel") == "next")
                pageNumber = parseInt($("form#search .pagination .active").text()) + 1;

            let url = "{{ route('search', '') }}/" + pageNumber + "";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "get",
                url: url,
                data: {
                    "search": $("#search").val()
                },
                // dataType: "json",
                success: function(response) {


                    let main = $("main");
                    main.empty();
                    main.append(response);

                    location.href = "#";



                },
                error: function(response) {


                    let errors = response.responseJSON.errors;



                }

            });



        });
    </script>


</body>

</html>
