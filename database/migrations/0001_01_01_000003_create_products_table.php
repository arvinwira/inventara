<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->string('sku')->unique();
            $t->string('name');
            $t->string('category')->nullable();
            $t->string('unit')->default('pcs');
            $t->decimal('cost_price', 12, 2)->default(0);
            $t->decimal('sell_price', 12, 2)->default(0);
            $t->unsignedInteger('reorder_point')->default(0);
            $t->timestamps();

            $t->index(['sku','name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
