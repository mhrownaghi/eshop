<?php

namespace Tests\Feature;

use App\Models\Product;
use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_related_products()
    {
        $mainProduct = Product::factory()->create();
        $relatedProduct = Product::factory()->create();
        DB::table('product_relations')->insert([
            ['type' => 'lid', 'product' => $mainProduct->id, 'related' => $relatedProduct->id],
        ]);
        

        $response = $this->get("/admin/products/{$mainProduct->slug}/related-products");
        $response->assertStatus(200);
        $response->assertSee($relatedProduct->name);
        $response->assertSee('lid');
    }

    public function test_list_related_products_empty()
    {
        $mainProduct = Product::factory()->create();
        $response = $this->get("/admin/products/{$mainProduct->slug}/related-products");
        $response->assertStatus(200);
        $response->assertSee('No related products found.');
    }

    public function test_see_404_when_main_product_not_found()
    {
        $response = $this->get("/admin/products/invalid-slug/related-products");
        $response->assertStatus(404);
    }
}
