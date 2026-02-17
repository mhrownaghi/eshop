<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'height',
        'diagonal',
        'volume',
        'weight',
        'box',
        'price',
        'old_price',
        'additional_price',
        'can_increase_price',
        'is_stock',
        'stock',
        'sku',
        'type',
        'has_selectable_lid',
        'has_selectable_box',
        'offline_shopping',
        'description',
        'short_description',
        'meta_description',
        'category_id',
    ];

    #[\Override]
    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if ($product->isDirty('name')) {
                $slug = Str::slug($product->name, '-', null);
                $originalSlug = $slug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $product->slug = $slug;
            }
        });
        
        static::deleting(function (Product $product) {
            /** @var ProductImage $image */
            foreach ($product->images as $image) {
                $image->delete();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    #[\Override]
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getRelatedProducts(string $type): Collection
    {
        $query = 'SELECT `related` FROM `product_related` WHERE `product` = ? AND `type` = ?';
        $ids = DB::select($query, [$this->id, $type]);

        return Product::all()->whereIn('id', $ids);
    }

    public function addRelatedProduct(string $type, int $relatedProductId): bool
    {
        $query = 'INSERT INTO `product_relations` (`type`, `product`, `related`) VALUES ( ?, ?, ? )';
        return DB::insert($query, [$type, $this->id, $relatedProductId]);
    }

    public function deleteRelatedProduct(int $relatedProductId): bool
    {
        $query = 'DELETE FROM `product_relations` WHERE `product` = ? AND `related` = ? ';
        return DB::delete($query, [$this->id, $relatedProductId]);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
