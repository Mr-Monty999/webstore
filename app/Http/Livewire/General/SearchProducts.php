<?php

namespace App\Http\Livewire\General;

use App\Models\Product;
use App\Services\CartService;
use App\Services\ProductService;
use App\Services\SettingService;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProducts extends Component
{
    public $setting;
    public $cartId;
    public $pattern;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['$refresh', 'searchForProduct'];


    public function mount()
    {
        $this->cartId = CartService::intialCookieCart();
        $this->setting = SettingService::getLastSetting();
    }
    public function searchForProduct($pattern)
    {
        $this->pattern = $pattern;
    }
    public function addProductToCart($id)
    {
        CartService::storeProduct($id, $this->cartId);
        $this->emitTo('general.cart', '$refresh');
        $this->emitTo('general.sub-products', '$refresh');
    }
    public function removeProductFromCart($id)
    {
        CartService::destroy($this->cartId, $id);
        $this->emitTo('general.cart', '$refresh');
        $this->emitTo('general.sub-products', '$refresh');
    }

    public function render()
    {
        // $products = [];
        // if ($this->pattern) {
        $products = Product::with("item")->where("name", 'LIKE', "%$this->pattern%")->paginate(6);
        // }
        return view('livewire.general.search-products', ["products" => $products]);
    }
}
