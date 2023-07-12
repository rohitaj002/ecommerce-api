<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_products_by_name()
    {
        $product1 = Product::factory()->create(['name' => 'Test Product 1']);
        $product2 = Product::factory()->create(['name' => 'Test Product 2']);
        $product3 = Product::factory()->create(['name' => 'Another Product']);

        $response = $this->getJson('/api/products/search?term=Test');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => [
                    $product1->toArray(),
                    $product2->toArray(),
                ]
            ]);
    }

    public function test_can_search_products_by_description()
    {
        $product1 = Product::factory()->create(['description' => 'This is a test product']);
        $product2 = Product::factory()->create(['description' => 'Another test product']);
        $product3 = Product::factory()->create(['description' => 'A different product']);

        $response = $this->getJson('/api/products/search?term=test');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => [
                    $product1->toArray(),
                    $product2->toArray(),
                ]
            ]);
    }

    public function test_can_search_products_by_variant_name()
    {
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();
        $product3 = Product::factory()->create();

        $variant1 = $product1->variants()->create([
            'name' => 'Test Variant 1',
            'sku' => 'TEST-001',
            'additional_cost' => 5.00,
            'stock_count' => 10,
        ]);

        $variant2 = $product2->variants()->create([
            'name' => 'Test Variant 2',
            'sku' => 'TEST-002',
            'additional_cost' => 10.00,
            'stock_count' => 5,
        ]);

        $variant3 = $product3->variants()->create([
            'name' => 'Another Variant',
            'sku' => 'TEST-003',
            'additional_cost' => 2.50,
            'stock_count' => 8,
        ]);

        $response = $this->getJson('/api/products/search?term=Variant');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => [
                    $product1->toArray(),
                    $product2->toArray(),
                ]
            ]);
    }
}
