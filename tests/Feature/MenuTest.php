<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // $this->withoutExceptionHandling();
    }

    /** @test */
    public function canCreateAMenu()
    {
        $menu = factory(Menu::class)->make()->toArray();
        $response = $this->post("/api/menus", $menu);
        $response->assertStatus(201);
    }

    /** @test */
    public function cantCreateAMenuWithMissingParameters()
    {
        $menu = factory(Menu::class)->make()->toArray();
        $response = $this->post("/api/menus", array_except($menu, "name"));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["name"]);
    }

    /** @test */
    public function canGetAMenuById()
    {
        $menu = factory(Menu::class)->create();
        $response = $this->get("/api/menus/{$menu->id}");
        $response->assertStatus(200);

        $menuReturned = json_decode($response->getContent());
        $this->assertEquals($menuReturned->id, $menu->id);
    }

    /** @test */
    public function canUpdateAMenuPUT()
    {
        $menu = factory(Menu::class)->create();
        $newData = factory(Menu::class)->make()->toArray();
        $response = $this->put("/api/menus/{$menu->id}", $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('menus', [
            'id'=>$menu->id,
            'name'=>$newData["name"],
        ]);
    }

    /** @test */
    public function canUpdateAMenuPATCH()
    {
        $menu = factory(Menu::class)->create();
        $newData = factory(Menu::class)->make()->toArray();
        $response = $this->patch("/api/menus/{$menu->id}", $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('menus', [
            'id'=>$menu->id,
            'name'=>$newData["name"],
        ]);
    }

    /** @test */
    public function cantUpdateAMenuWithMissingParametersPUT()
    {
        $menu = factory(Menu::class)->create();
        $newData = factory(Menu::class)->make()->toArray();
        $response = $this->put("/api/menus/{$menu->id}", array_except($newData, "name"));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["name"]);
    }

    /** @test */
    public function cantUpdateAMenuWithMissingParametersPATCH()
    {
        $menu = factory(Menu::class)->create();
        $newData = factory(Menu::class)->make()->toArray();
        $response = $this->patch("/api/menus/{$menu->id}", array_except($newData, "name"));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["name"]);
    }

    /** @test */
    public function canDeleteAMenu()
    {
        $menu = factory(Menu::class)->create();
        $response = $this->delete("/api/menus/{$menu->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('menus', [
            'id'=>$menu->id,
        ]);
    }
}
