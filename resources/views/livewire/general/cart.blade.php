<div>
    @php
        $productsToBuy = '';
    @endphp
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="mycart" dir="ltr">
        <div class="products" wire:ignore.self>
            @foreach ($products as $key => $product)
                <div wire:key="cart-{{ $product->id }}"
                    class="d-flex flex-column justify-content-center align-items-center">
                    <div id="" class="">
                        <div class="d-flex flex-column justify-content-center align-items-center">

                            <input type="text" class="product-id" name="product_id" value="{{ $product->id }}" hidden>
                            <input type="text" class="product-price" name="price" value="{{ $product->price }}"
                                hidden>
                            <h6 class="text-white product-name" name="name">
                                {{ $product->name }}</h6>
                            <h6 class="text-white product-new-price" dir="rtl" name="price">
                                {{ number_format($product->price * $product->pivot->product_amount) }}

                                {{ $store->store_currency }}

                            </h6>
                            <br>
                            <div class="form-group" dir="rtl">
                                <label class="text-white" for="">الكمية :</label>
                                <input wire:ignore wire:change="changeAmount({{ $product->id }},$event.target.value)"
                                    min="1" type="number" value="{{ $product->pivot->product_amount }}"
                                    class="form-control text-center product-amount" name="product_amount"
                                    id="">
                            </div>

                            <div>
                                <button type="button" class="btn btn-danger inside-cart-decrease">-</button>
                                <button type="button" class="btn btn-success inside-cart-increase">+</button>
                            </div>
                            <button type="button" wire:click="removeProductFromCart({{ $product->id }})"
                                class="btn btn-danger d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-trash"></i>
                                ازالة
                            </button>
                        </div>
                    </div>
                    <hr>
                    @php
                        $productsToBuy .= $product->name . ' ' . $product->pivot->product_amount;
                        if ($loop->index < $loop->count - 1) {
                            $productsToBuy .= ' , ';
                        }
                    @endphp
                </div>
            @endforeach
            <div class="buttons d-flex justify-content-around">
                <button type="button" id="delete-all" wire:click="removeAllProductsFromCart"
                    class="btn btn-danger d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-trash"></i>
                    ازالة الكل
                </button>
                <a href="https://wa.me/{{ $store->whatsapp_phone }}?text=[{{ $productsToBuy }}] اريد شراء"
                    target="_blank" type="button" id="buy-all"
                    class="btn btn-success d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-cash-register"></i>
                    شراء الكل
                </a>
            </div>
        </div>
        <div class="container">
            <div id="products-count" class="text-danger bg-white d-flex justify-content-center align-items-center">
                {{ $products->count() }}
            </div>
            <i class="fa-solid fa-cart-shopping" class="btn btn-primary"></i>
        </div>
    </div>
</div>
