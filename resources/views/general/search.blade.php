 <div class="main-products container d-flex flex-column">
     <h1 class="title section-title align-self-center">بحث عن "{{ $searched }}"</h1>
     <form id="search" action="" class="row gap-3 d-flex align-items-center justify-content-center" method="post">
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
                             target="_blank" class="btn btn-success mar-3">
                             شراء الان
                             <i class="fa-solid fa-cash-register"></i>

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
