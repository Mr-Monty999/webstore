 @extends('layouts.public')
 @section('content')
     @include('general.sub-products')
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

         //Load Products By Page Link//
         $(document).on("click", "form#load-products .pagination .page-link", function(e) {
             e.preventDefault();


             let pageNumber = parseInt($(this).text());

             if ($(this).attr("rel") == "prev")
                 pageNumber = parseInt($("form#load-products .pagination .active").text()) - 1;
             else if ($(this).attr("rel") == "next")
                 pageNumber = parseInt($("form#load-products .pagination .active").text()) + 1;




             let main = $("main");
             let url = "{{ route('products.load', ['', '']) }}/{{ $item->id }}/" +
                 pageNumber + "";


             $(main).load(url, function(res, status,
                 request) {

             });




         });
     </script>
 @endpush
