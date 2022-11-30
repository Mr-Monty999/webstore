<?php

namespace App\Http\Livewire\General;

use App\Models\Product;
use App\Models\Setting;
use App\Services\CartService;
use App\Services\CheckService;
use App\Services\SettingService;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Livewire\Component;
use Livewire\WithPagination;

class SubProducts extends Component
{
    public $item;
    public $setting;
    public $cartId;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["addProductToCart", '$refresh'];


    public function mount()
    {
        $this->cartId = CartService::intialCookieCart();
    }
    public function addProductToCart($id)
    {
        CartService::storeProduct($id, $this->cartId);
        $this->emitTo('general.cart', '$refresh');
        $this->emitTo('general.search-products', '$refresh');
    }
    public function removeProductFromCart($id)
    {
        CartService::destroy($this->cartId, $id);
        $this->emitTo('general.cart', '$refresh');
        $this->emitTo('general.search-products', '$refresh');
    }
    public function render()
    {
        return view('livewire.general.sub-products', [
            'products' => $this->item->products()->with("item")->paginate(6)->onEachSide(0)
        ]);
    }
}
