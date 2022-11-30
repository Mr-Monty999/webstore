<?php

namespace App\Http\Livewire\General;

use App\Services\CartService;
use App\Services\CheckService;
use App\Services\GetService;
use App\Services\SettingService;
use Livewire\Component;
use Livewire\Livewire;

class Cart extends Component
{
    public $products;
    public $store;
    public $cartId;

    protected $listeners = ['$refresh'];
    public function mount()
    {
        $this->cartId = CartService::intialCookieCart();
    }
    public function changeAmount($productId, $amount)
    {
        CartService::update($this->cartId, $productId, ["product_amount" => $amount]);
    }
    public function removeProductFromCart($id)
    {
        CartService::destroy($this->cartId, $id);
        $this->emitTo('general.sub-products', '$refresh');
        $this->emitTo('general.search-products', '$refresh');
    }
    public function removeAllProductsFromCart()
    {
        CartService::destroyAll($this->cartId);
        $this->emitTo('general.sub-products', '$refresh');
        $this->emitTo('general.search-products', '$refresh');
    }
    public function render()
    {
        $this->products = CartService::showCartProducts($this->cartId);
        return view('livewire.general.cart');
    }
}
