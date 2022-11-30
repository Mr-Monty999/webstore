<?php

namespace App\Http\Livewire\General;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class Search extends Component
{
    public $pattern;

    protected $listeners = ['$refresh'];
    public function render()
    {
        return view('livewire.general.search');
    }
}
