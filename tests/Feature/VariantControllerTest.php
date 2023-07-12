<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VariantControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_variant()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => 'Test Variant',
            'sku' => 'TEST-001',
            'additional_cost' => 5.00,
            'stock_count' => 10,
        ];

        $response = $this->postJson('/api/products/' . $product->id . '/variants', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => $data
            ]);

        $this->assertDatabaseHas('variants', $data);
    }

    public function test_can_get_all_variants()
    {
        $product = Product::factory()->create();
        Variant::factory()->count(3)->create(['product_id' => $product->id]);

        $response = $this->getJson('/api/products/' . $product->id . '/variants');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_variant()
    {
        $product = Product::factory()->create();
        $variant = Variant::factory()->create(['product_id' => $product->id]);

        $response = $this->getJson('/api/products/' . $product->id . '/variants/' . $variant->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => $variant->toArray()
            ]);
    }

    public function test_can_update_variant()
    {
        $product = Product::factory()->create();
        $variant = Variant::factory()->create(['product_id' => $product->id]);

        $updatedData = [
            'name' => 'Updated Variant',
            'sku' => 'TEST-002',
            'additional_cost' => 10.00,
            'stock_count' => 5,
        ];

        $response = $this->putJson('/api/products/' . $product->id . '/variants/' . $variant->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => $updatedData
            ]);

        $this->assertDatabaseHas('variants', $updatedData);
    }

    public function test_can_delete_variant()
    {
        $product = Product::factory()->create();
        $variant = Variant::factory()->create(['product_id' => $product->id]);

        $response = $this->deleteJson('/api/products/' . $product->id . '/variants/' . $variant->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('variants', [
            'id' => $variant->id
        ]);
    }
}
