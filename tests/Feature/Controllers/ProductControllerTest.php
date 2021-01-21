<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListingProducts()
    {
        $response = $this->get('/api/products');
        $response->assertStatus(200);
    }

    public function testShowProduct()
    {
        $product = Product::factory()->create();

        $response = $this->get("/api/products/{$product->id}");
        $response->assertStatus(200);

        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $body);

        $data = $body['data'];

        $this->assertIsArray($data);
        $this->assertEquals($data['name'], $product->name);
    }

    public function testCreateProduct()
    {
        $category = Category::factory()->create();

        $product = [
            'name' => 'Product Test',
            'price' => 123,
            'category_id' => $category->id,
        ];

        $response = $this->post('/api/products', $product);
        $response->assertStatus(201);

        $this->assertDatabaseHas('products', $product);
    }

    public function testUpdateProduct()
    {
        $product = Product::factory()->create();

        $productUpdated = $product->toArray();
        $productUpdated['name'] = 'Product Updated';

        $response = $this->put("/api/products/{$product->id}", $productUpdated);
        $response->assertStatus(200);

        $body = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals($body['message'], 'Updated successfully!');

        $this->assertDatabaseHas('products', ['name' => $productUpdated['name']]);
    }

    public function testDeleteProduct()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/api/products/{$product->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', $product->toArray());
    }
}
