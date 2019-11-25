<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuItemTest extends TestCase
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
    public function canAddItemsToMenu()
    {
        $items = factory(Item::class, $this->itemsNumber)->make()->toArray();
        $response = $this->post("/api/menus/{$this->menu->id}/items", $items);
        $response->assertStatus(201);
    }

    /** @test */
    public function cantAddItemsToMenuOverMaxChildren()
    {
        $items = factory(Item::class, $this->itemsNumber+1)->make()->toArray();
        $response = $this->post("/api/menus/{$this->menu->id}/items", $items);
        $response->assertStatus(403);
    }

    /** @test */
    public function canGetMenuStructure()
    {
        $items = factory(Item::class, $this->itemsNumber)->make()->toArray();
        $response = $this->post("/api/menus/{$this->menu->id}/items", $items);
        $response->assertStatus(201);

        $structure = $this->get("/api/menus/{$this->menu->id}/items");
        $structure->assertStatus(200);
        $structure->assertJsonCount($this->itemsNumber);
    }

    /** @test */
    public function canDeleteMenuItems()
    {
        $items = factory(Item::class, $this->itemsNumber)->make()->toArray();
        $response = $this->post("/api/menus/{$this->menu->id}/items", $items);
        $response->assertStatus(201);

        $structure = $this->get("/api/menus/{$this->menu->id}/items");
        $structure->assertStatus(200);
        $structure->assertJsonCount($this->itemsNumber);

        $delete = $this->delete("/api/menus/{$this->menu->id}/items");
        $delete->assertStatus(200);
        $this->assertDatabaseMissing("items", [
            "menu_id" =>$this->menu->id
        ]);
    }
}
