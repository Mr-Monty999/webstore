<div>
    <form id="product-search" class="d-flex">
        @csrf
        <input wire:blur="$emit('searchForProduct',$event.target.value)"
            wire:keyup="$emit('searchForProduct',$event.target.value)" name="search" id="search"
            class="form-control me-2" type="search" placeholder="بحث عن منتج" aria-label="Search">
        {{-- <button wire:click="$emit('searchForProduct',$event.target.value)" class="btn btn-outline-light"
            type="button">بحث</button> --}}
    </form>
</div>
