<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug')->unique();

            $table->float('height')->nullable()->index();
            $table->float('diagonal')->nullable()->index();
            $table->float('volume')->nullable()->index();
            $table->float('weight')->nullable()->index();
            $table->unsignedTinyInteger('box')->nullable()->default(1);

            $table->float('price')->nullable()->default(0);
            $table->float('old_price')->nullable()->default(0);
            $table->float('additional_price')->nullable()->default(0);
            $table->boolean('can_increase_price')->default(false);

            $table->boolean('is_stock')->default(false);
            $table->unsignedInteger('stock')->nullable();
            $table->unsignedInteger('sku')->unique();

            $table->enum('type', ['lid', 'box', 'other']);
            $table->boolean('has_selectable_lid')->default(false);
            $table->boolean('has_selectable_box')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('offline_shopping')->default(false);

            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('meta_description')->nullable();

            $table->foreignId('category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
