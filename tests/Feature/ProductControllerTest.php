<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product()
    {
        $data = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 9.99,
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => $data
            ]);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_can_get_all_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => $product->toArray()
            ]);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product',
            'description' => 'This is an updated product',
            'price' => 19.99,
        ];

        $response = $this->putJson('/api/products/' . $product->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => $updatedData
            ]);

        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}
