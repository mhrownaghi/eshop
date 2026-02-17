<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCategoryFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::saving(function (ProductCategory $productCategory) {
            if ($productCategory->isDirty('name')) {
                $slug = Str::slug($productCategory->name, '-', null);
                $originalSlug = $slug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $productCategory->id)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $productCategory->slug = $slug;
            }
        });
    }

    protected $fillable = [
        'name',
        'description',
        'meta_description',
        'is_active',
        'parent_id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children(): hasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getAllDescendantIds(): array
    {
        $query = "
            WITH RECURSIVE category_tree AS (
                SELECT id FROM product_categories WHERE parent_id = ?
                UNION ALL
                SELECT pc.id FROM product_categories pc
                INNER JOIN category_tree ct ON pc.parent_id = ct.id
            )
            SELECT id FROM category_tree
        ";

        $result = DB::select($query, [$this->id]);

        return array_map('intval', array_column($result, 'id'));
    }
}
