<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $user;
    private $product;
    private $item;
    public function setUp(): void
    {

        parent::setUp();
        $this->user = User::role("owner")->firstOrFail();
        $this->item = Item::firstOrCreate([
            "name" => uniqid("test"),
        ]);
        $this->product = Product::firstOrCreate([
            "name" => uniqid("test"),
            "price" => 100,
            "item_id" => $this->item->id
        ]);
        $this->actingAs($this->user);
    }
    public function testShowAllProducts()
    {

        $response = $this->get(route('api.products.index'));
        $response->assertStatus(200);

        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
    }
    public function testShowProduct()
    {

        $response = $this->get(route('api.products.show', $this->product->id));
        // $response->assertSee($this->product);
        $response->assertStatus(200);
    }
    public function testEditProduct()
    {

        $response = $this->get(route('products.edit', $this->product->id));
        $response->assertStatus(200);
    }
    public function testStoreProduct()
    {

        $data = [
            "name" => uniqid("test"),
            "price" => 10,
            "discount" => 50,
            "item_id" => $this->item->id

        ];
        $response = $this->post(route('api.products.store'), $data);
        $response->assertStatus(201);

        $response = $this->post(route('products.store'), $data);
        $response->assertStatus(201);
    }

    public function testUpdateProduct()
    {

        $data = [
            "name" => uniqid("test"),
            "price" => 10,
            "item_id" => $this->item->id,
            "discount" => 50,
            // "photo" => UploadedFile::fake()->image("hi.jpeg"),
            "_method" => "put"
        ];
        $response = $this->post(route('api.products.update', $this->product->id), $data);
        $response->assertStatus(200);

        $response = $this->post(route('products.update', $this->product->id), $data);
        $response->assertStatus(200);
    }

    public function testDeleteProduct()
    {
        $response = $this->delete(route('api.products.destroy', $this->product->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing(Product::class, $this->product->toArray());
    }
    public function testDeleteAllProducts()
    {
        $response = $this->delete(route('api.products.destroy.all'));
        $response->assertStatus(200);
        $this->assertDatabaseCount("products", 0);
    }
}
