<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuLayerTest extends TestCase
{
    use RefreshDatabase;

    protected $menu;

    protected $itemsNumber;

    public function setUp(): void
    {
        parent::setUp();
        // $this->withoutExceptionHandling();
        $this->itemsNumber = rand(1, 15);
        $this->menu = factory(Menu::class)->create([
            "max_children"=>$this->itemsNumber
        ]);
    }

    /** @test */
    public function canGetMenuLayer()
    {
        $items = factory(Item::class, $this->itemsNumber)->make()->toArray();
        $response = $this->post("/api/menus/{$this->menu->id}/items", $items);
        $response->assertStatus(201);

        $structure = $this->get("/api/menus/{$this->menu->id}/items");
        $structure->assertStatus(200);
        $structure->assertJsonCount($this->itemsNumber);

        $layer = rand(1, $this->itemsNumber);
        $amount = Item::where("menu_id", $this->menu->id)->where("layer", $layer)->count();

        $layers = $this->get("/api/menus/{$this->menu->id}/layers/{$layer}");
        $layers->assertStatus(200);
        $layers->assertJsonCount($amount);
    }

    /** @test */
    public function canDeleteMenuLayer()
    {
        $items = factory(Item::class, $this->itemsNumber)->make()->toArray();
        $response = $this->post("/api/menus/{$this->menu->id}/items", $items);
        $response->assertStatus(201);

        $structure = $this->get("/api/menus/{$this->menu->id}/items");
        $structure->assertStatus(200);
        $structure->assertJsonCount($this->itemsNumber);

        $layer = rand(1, $this->itemsNumber);
        $selected = Item::where("menu_id", $this->menu->id)->where("layer", $layer)->first();

        $layers = $this->delete("/api/menus/{$this->menu->id}/layers/{$layer}");
        $layers->assertStatus(200);
        $this->assertDatabaseMissing("items", [
            "id"=> $selected->id
        ]);
        $this->assertDatabaseHas("items", [
            "menu_id"=>$this->menu->id,
            "layer"=> $layer
        ]);
    }
}
