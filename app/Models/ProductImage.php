<?php

namespace App\Models;

use App\Libraries\ImageUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class ProductImage extends Model
{
    protected $fillable = [
        'path',
        'alt',
        'is_thumb',
    ];

    #[\Override]
    protected static function booted(): void
    {
        static::saved(function (ProductImage $productImage) {
            $is_thumb = $productImage->is_thumb;
            if ($is_thumb) {
                $productImage->setThumb();
            } else {
                $productImage->setThumbFirstImage();
            }
        });
        
        static::deleting(function (ProductImage $productImage) {
            $is_thumb = $productImage->is_thumb;
            if ($is_thumb) {
                $productImage->setThumbFirstImage(true);
            }
            
            ImageUtil::remove($productImage->path);
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    private function setThumbFirstImage(bool $exceptMe = false): void
    {
        $query = '';
        if ($exceptMe) {
            $query = 'SELECT COUNT(*) FROM `product_images` WHERE `is_thumb` = 1 AND `product_id` = ? AND `id` != ?';
            $thumbCount = DB::scalar($query, [$this->product_id, $this->id]);
            if (!$thumbCount) {
                $query = 'UPDATE `product_images` SET `is_thumb` = 1 WHERE `product_id` = ? AND `id` != ? LIMIT 1';
                DB::update($query, [$this->product_id, $this->id]);
            }
        } else {
            $query = 'SELECT COUNT(*) FROM `product_images` WHERE `is_thumb` = 1 AND `product_id` = ?';
            $thumbCount = DB::scalar($query, [$this->product_id]);
            if (!$thumbCount) {
                $query = 'UPDATE `product_images` SET `is_thumb` = 1 WHERE `product_id` = ? LIMIT 1';
                DB::update($query, [$this->product_id]);
            }
        }
        
    }
    
    private function setThumb(): void
    {
        DB::update('UPDATE `product_images` SET `is_thumb` = 0 WHERE `product_id` = ?', [$this->product_id]);
        DB::update('UPDATE `product_images` SET `is_thumb` = 1 WHERE `id` = ?', [$this->id]);
    }
}
