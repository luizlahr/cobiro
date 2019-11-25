<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected $item;

    protected $itemsNumber;

    public function setUp(): void
    {
        parent::setUp();
        // $this->withoutExceptionHandling();
    }

    /** @test */
    public function canCreateAnItem()
    {
        $item = factory(Item::class)->make()->toArray();
        $response = $this->post("/api/items", $item);
        $response->assertStatus(201);
    }

    /** @test */
    public function cantCreateAnItemWithMissingParameters()
    {
        $item = factory(Item::class)->make()->toArray();
        $response = $this->post("/api/items", []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["name"]);
    }

    /** @test */
    public function canGetAnItemById()
    {
        $item = factory(Item::class)->create();
        $response = $this->get("/api/items/{$item->id}");
        $response->assertStatus(200);

        $itemReturned = json_decode($response->getContent());
        $this->assertEquals($itemReturned->id, $item->id);
    }

    /** @test */
    public function canUpdateAnItemPUT()
    {
        $item = factory(Item::class)->create();
        $newData = factory(Item::class)->make()->toArray();
        $response = $this->put("/api/items/{$item->id}", $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('items', [
            'id'=>$item->id,
            'name'=>$newData["name"],
        ]);
    }

    /** @test */
    public function canUpdateAnItemPATCH()
    {
        $item = factory(Item::class)->create();
        $newData = factory(Item::class)->make()->toArray();
        $response = $this->patch("/api/items/{$item->id}", $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('items', [
            'id'=>$item->id,
            'name'=>$newData["name"],
        ]);
    }

    /** @test */
    public function cantUpdateAnItemWithMissingParametersPUT()
    {
        $item = factory(Item::class)->create();
        $newData = factory(Item::class)->make()->toArray();
        $response = $this->put("/api/items/{$item->id}", []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["name"]);
    }

    /** @test */
    public function cantUpdateAnItemWithMissingParametersPATCH()
    {
        $item = factory(Item::class)->create();
        $newData = factory(Item::class)->make()->toArray();
        $response = $this->patch("/api/items/{$item->id}", array_except($newData, "name"));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["name"]);
    }

    /** @test */
    public function canDeleteAnItem()
    {
        $item = factory(Item::class)->create();
        $response = $this->delete("/api/items/{$item->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('items', [
            'id'=>$item->id,
        ]);
    }
}
