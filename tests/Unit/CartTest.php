<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Product;
use App\Services\CartService;
use Tests\TestCase;

class CartTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    private Cart $cart;
    private Product $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->cart = CartService::intialCart();
        $item = Item::firstOrCreate(["item_name" => "test"]);
        $this->product = Product::firstOrCreate([
            "product_name" => "product",
        ], [
            "product_price" => 10,
            "product_discount" => 1,
            "item_id" => $item->id
        ]);
    }

    public  function testIntialCart()
    {
        $this->assertNotEmpty($this->cart);
    }

    public function testStoreProductOnCart()
    {

        $result =  CartService::storeProduct($this->product->id, $this->cart->id);
        $this->assertNotEmpty($result);
    }

    public  function testShowCartProducts()
    {
        $products =   CartService::showCartProducts($this->cart->id);
        $this->assertNotEmpty($products);
    }
    public  function testShowProductInCart()
    {
        $product = CartService::show($this->cart->id, $this->product->id);
        $this->assertNotEmpty($product);
    }
    public  function testUpdateProductInCart()
    {
        $product = CartService::update($this->cart->id, $this->product->id, ["product_amount" => 10]);
        $this->assertNotEmpty($product);
    }

    public  function testDestroyProductInCart()
    {
        $product = CartService::destroy($this->cart->id, $this->product->id);
        $this->assertNotEmpty($product);
    }
    public  function testDestroyAllProductsInCart()
    {
        $result = CartService::destroyAll($this->cart->id);
        $this->assertTrue($result);
    }
}
