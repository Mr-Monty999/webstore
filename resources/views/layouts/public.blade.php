<!DOCTYPE html>
<html lang="ar" dir="rtl">

@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Setting;
use App\Models\Item;
use App\Models\Cart;

$products = Cart::with('products')
    ->where('cart_uid', Cookie::get('cart_uid'))
    ->first()->products;

$navItems = Item::all();

$store = null;
if (Setting::count() > 0) {
    $store = Setting::first();
}
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
    <link rel="icon" href="{{ asset($store->store_logo) }}">

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
                        @if (Auth::guard('admin')->check())
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
                    <form action="{{ route('search') }}" class="d-flex">
                        @csrf
                        <input name="search" class="form-control me-2" type="search" placeholder="بحث عن منتج"
                            aria-label="Search">
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
                    <div id="product{{ $product->id }}"
                        class="product d-flex flex-column justify-content-center align-items-center product{{ $product->id }}">
                        <input type="text" class="product-id" value="{{ $product->id }}" hidden>
                        <h6 class="text-dark">{{ $product->product_name }}</h6>
                        <h6 class="text-dark product-new-price">{{ $product->product_price }}</h6>
                        <div class="form-group" dir="rtl">
                            <label class="text-dark" for="">الكمية</label>
                            <input min="1" type="number" value="3"
                                class="form-control text-center product-amount" name="qty" id="">
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger inside-cart-decrease">-</button>
                            <button type="button" class="btn btn-success inside-cart-increase">+</button>
                        </div>
                        <button type="button"
                            class="btn btn-danger delete d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-trash"></i>
                            ازالة
                        </button>
                    </div>
                    <hr>
                </div>
            @endforeach
        </div>
        <i class="fa-solid fa-cart-shopping" class="btn btn-primary"></i>
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




        $(".mycart .delete").on("click", function() {
            // alert("success");

            let productId = $(this).parent().find(".product-id").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "delete",
                url: "{{ route('carts.destroy', 1) }}",
                data: {
                    "product_id": productId
                },
                dataType: "json",
                //  processData: false,
                //  contentType: false,
                success: function(response) {


                    console.log(response);



                },
                error: function(response) {


                    let errors = response.responseJSON;
                    console.log(errors);

                }

            });
        });
        $(document).on("click", ".mycart .inside-cart-increase", function() {


            let productId = $(this).parent().parent().find(".product-id").val();
            let productAmount = $("#product" + productId + "").find(".product-amount").val();


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "put",
                url: "{{ route('carts.update', 1) }}",
                data: {
                    "product_id": productId,
                    "product_amount": productAmount,
                },
                dataType: "json",
                //  processData: false,
                //  contentType: false,
                success: function(response) {


                    console.log(response);



                },
                error: function(response) {


                    let errors = response.responseJSON;
                    console.log(errors);

                }

            });
        });
        $(document).on("click", ".mycart .inside-cart-decrease", function() {
            //  alert("success");

            let productId = $(this).parent().parent().find(".product-id").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "put",
                url: "{{ route('carts.update', 1) }}",
                data: {
                    "product_id": productId,
                    "product_amount": productAmount
                },
                dataType: "json",
                //  processData: false,
                //  contentType: false,
                success: function(response) {


                    console.log(response);



                },
                error: function(response) {


                    let errors = response.responseJSON;
                    console.log(errors);

                }

            });
        });
    </script>


</body>

</html>
