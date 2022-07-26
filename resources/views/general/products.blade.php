 @extends('layouts.public')
 @section('content')
     @include('general.sub-products')
 @endsection
 @push('ajax')
     <script>
         //  $("input[type=date]").val(new Date().toISOString().slice(0, 10));



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
                 location.href = "#";

             });




         });
     </script>
 @endpush
