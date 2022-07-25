 @extends('layouts.public')
 @section('content')
     <div class="main-products container d-flex flex-column">
         <h1 class="title section-title align-self-center">المنتجات</h1>
         <form action="" class="row gap-3 d-flex align-items-center justify-content-center" method="post">

             @if ($products->count() > 0)
                 @foreach ($products as $product)
                     <div
                         class="card d-flex flex-column justify-content-center align-items-center col-10 col-md-4 col-lg-3 product{{ $product->id }}">
                         <img src="{{ asset($product->product_photo) }}" class="" width="" alt="...">
                         <div class="card-body d-flex flex-column justify-content-center align-items-center">
                             <h5 class="product_name card-title text-dark">{{ $product->product_name }}</h5>
                             @php
                                 
                                 $currency = $setting->store_currency;
                                 
                                 $price = $product->product_price;
                                 if (!is_numeric($price)) {
                                     $price = 0;
                                 }
                                 
                                 $finalPrice = ($product->product_discount * $price) / 100;
                                 $finalPrice = $price - $finalPrice;
                                 
                                 if ($finalPrice < 0) {
                                     $finalPrice = 0;
                                 }
                                 
                             @endphp
                             @if ($product->product_discount > 0)
                                 <h5 class="text-dark"> خصم %{{ $product->product_discount }}

                                     <h5 class="product_old_price text-dark">
                                         <del>{{ number_format($product->product_price) }} </del>
                                     </h5>
                                 </h5>

                                 <h5 class="product_price text-dark">
                                     <mark class="mark">{{ number_format($finalPrice) }} {{ $currency }}</mark>
                                 </h5>
                             @else
                                 <h5 class="product_price text-dark"> {{ number_format($product->product_price) }}
                                     {{ $currency }}</h5>
                             @endif

                             <a href="https://wa.me/{{ $setting->whatsapp_phone }}?text=اريد شراء {{ $product->product_name }}"
                                 target="_blank" class="btn btn-success mar-3">شراء الان
                             </a>
                             @if (Auth::guard('admin')->check())
                                 <a href="{{ route('products.edit', $product->id) }}" class="btn btn-dark">تعديل
                                 </a>
                             @endif
                             <input type="text" class="product-id" hidden value="{{ $product->id }}">
                             <a href="#cart{{ $product->id }}" class="btn btn-success add-to-cart"
                                 data-bs-toggle="collapse" href="#cart{{ $product->id }}" role="button"
                                 aria-expanded="false" aria-controls="cart{{ $product->id }}">اضف
                                 الي السلة
                                 <i class="fa-solid fa-cart-shopping"></i>
                             </a>
                             {{-- <button type="button"
                                 class="btn btn-danger delete d-flex justify-content-center align-items-center">
                                 ازالة من السلة
                                 <i class="fa-solid fa-trash"></i>
                             </button> --}}

                             <div class="collapse" id="cart{{ $product->id }}">
                                 <div class="d-flex flex-column justify-content-center align-items-center">
                                     <h1 class="product-new-price">{{ $finalPrice }}</h1>
                                     <div class="form-group">
                                         <label for="">الكمية:</label>
                                         <input min="1" type="number" value="1"
                                             class="form-control text-center product-amount" name="" id="">
                                     </div>
                                     <div>
                                         <button type="button" class="btn btn-success increase">+</button>
                                         <button type="button" class="btn btn-danger decrease">-</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 @endforeach
             @else
                 <div class="alert alert-danger text-center">عفوا لايوجد منتجات</div>
             @endif

             <div class="d-flex flex-column justify-content-center align-items-center">
                 {!! $products->links() !!}

             </div>

         </form>

     </div>
 @endsection
 @push('ajax')
     <script>
         //  $("input[type=date]").val(new Date().toISOString().slice(0, 10));


         let addToCart = $(".add-to-cart");

         addToCart.on("click", function() {
             //  alert("success");
             let productId = $(this).parent().find(".product-id").val(),
                 productNewPrice = $(this).parent().find(".product-new-price").text(),
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
                             '" class="product  product' +
                             productId + '">' +
                             '<form class="d-flex flex-column justify-content-center align-items-center" method="POST"' +
                             ' id="product-delete">' +
                             '@csrf' +
                             '@method('delete')' +
                             '<input type="text" class="product-id"  value="' +
                             productId + '" name="product_id" hidden>' +
                             '<h6 class="text-dark">' + productName + '</h6>' +
                             '<h6 class="text-dark product-new-price">' + productNewPrice + '</h6>' +
                             '<div class="form-group" dir="rtl">' +
                             ' <label class="text-dark" for="">الكمية</label>' +
                             '<input min="1" type="number" value="' + productAmount +
                             '" class="form-control text-center product-amount" name="qty" id="">' +
                             '</div>' +
                             '<div>' +
                             '<button type="button" class="btn btn-danger inside-cart-decrease">-</button>' +
                             ' <button type="button" class="btn btn-success inside-cart-increase">+</button>' +
                             '</div>' +
                             '<button type="submit" class="btn btn-danger delete d-flex justify-content-center align-items-center">' +
                             '<i class="fa-solid fa-trash"></i>' +
                             'ازالة' +
                             '</button>' +
                             '</form>' +
                             '</div>' +
                             '<hr>' +
                             '</div>';


                         $(".mycart .products").append(product);
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
                 productNewPrice = parseFloat(productPrice.text().match(/\d/g).join("")) * productAmount;

             $(".product" + productId + " .product-amount").val(productAmount);
             $(".product" + productId + " .product-new-price").text(productNewPrice);



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

                 }

             });

         });
     </script>
 @endpush
