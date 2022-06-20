 @extends('layouts.public')
 @section('content')
     <div class="products container d-flex flex-column">
         <h1 class="title section-title align-self-center">المنتجات</h1>
         <form action="" class="row gap-3 d-flex align-items-center justify-content-center" method="post">

             @if ($products->count() > 0)
                 @foreach ($products as $product)
                     <div class="card d-flex flex-column justify-content-center align-items-center col-6 col-md-4 col-lg-3">
                         <img src="{{ asset($product->product_photo) }}" class="" width="" alt="...">
                         <div class="card-body d-flex flex-column justify-content-center align-items-center">
                             <h5 class="product_name card-title text-dark">{{ $product->product_name }}</h5>
                             @if ($product->product_discount > 0)
                                 @php
                                     
                                     $currency = '';
                                     
                                     ///Get The Custom Currancy of User
                                     for ($x = 0; $x < strlen($product->product_price); $x++) {
                                         if (!is_numeric($product->product_price[$x])) {
                                             $currency .= $product->product_price[$x] . '';
                                         }
                                     }
                                     
                                     $price = filter_var($product->product_price, FILTER_SANITIZE_NUMBER_FLOAT);
                                     
                                     $finalPrice = ($product->product_discount * $price) / 100;
                                     $finalPrice = $price - $finalPrice;
                                     
                                     if ($finalPrice < 0) {
                                         $finalPrice = 0;
                                     }
                                     
                                 @endphp
                                 <h5 class="product_price text-dark"> خصم %{{ $product->product_discount }}

                                     <h5 class="product_price text-dark"> <del>{{ $product->product_price }} </del></h5>
                                 </h5>

                                 <h5 class="product_price text-dark">
                                     <mark class="mark">{{ $finalPrice }}{{ $currency }}</mark>
                                 </h5>
                             @else
                                 <h5 class="product_price text-dark"> {{ $product->product_price }}</h5>
                             @endif

                             <a href="https://wa.me/{{ $setting->whatsapp_phone }}?text=اريد شراء {{ $product->product_name }}"
                                 target="_blank" class="btn btn-success mar-3">شراء الان
                                 <i class="fa-solid fa-cash-register"></i>
                             </a>
                             @if (Auth::guard('admin')->check())
                                 <a href="{{ route('products.edit', $product->id) }}" class="btn btn-dark">تعديل
                                 </a>
                             @endif
                             <a hidden href="#collapseExample" class="btn btn-success" data-bs-toggle="collapse"
                                 href="#collapseExample" role="button" aria-expanded="false"
                                 aria-controls="collapseExample">اضف
                                 الي السلة
                                 <i class="fa-solid fa-cart-shopping"></i>
                             </a>
                             <div class="collapse" id="collapseExample">
                                 <div class="d-flex flex-column justify-content-center align-items-center">
                                     <h1 class="product-new-price">{{ $product->product_price }}</h1>
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
                 {{ $products->links() }}

             </div>

         </form>

     </div>
 @endsection