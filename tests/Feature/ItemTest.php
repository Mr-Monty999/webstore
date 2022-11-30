<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Services\ItemService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $user;
    private $item;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::role("owner")->firstOrFail();
        $this->item = Item::firstOrCreate(["name" => uniqid("test")]);
        $this->actingAs($this->user);
    }
    public function testShowAllItems()
    {

        $response = $this->get(route('api.items.index'));
        $response->assertStatus(200);

        $response = $this->get(route('items.index'));
        $response->assertStatus(200);
    }
    public function testShowItem()
    {

        $response = $this->get(route('api.items.show', $this->item->id));
        // $response->assertSee($this->item);
        $response->assertStatus(200);
    }
    public function testEditItem()
    {

        $response = $this->get(route('items.edit', $this->item->id));
        $response->assertStatus(200);
    }
    public function testStoreItem()
    {

        $data = [
            "name" => uniqid("test"),
        ];
        $response = $this->post(route('api.items.store'), $data);
        $response->assertStatus(201);

        $response = $this->post(route('items.store'), $data);
        $response->assertStatus(201);
    }

    public function testUpdateItem()
    {

        $data = [
            "name" => uniqid("test"),
            "_method" => "put"
        ];
        $response = $this->post(route('api.items.update', $this->item->id), $data);
        $response->assertStatus(200);

        $response = $this->post(route('items.update', $this->item->id), $data);
        $response->assertStatus(200);
    }

    public function testDeleteItem()
    {
        $response = $this->delete(route('api.items.destroy', $this->item->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing(Item::class, $this->item->toArray());
    }
    public function testDeleteAllItems()
    {
        $response = $this->delete(route('api.items.destroy.all'));
        $response->assertStatus(200);
        $this->assertDatabaseCount("items", 0);
    }
}
