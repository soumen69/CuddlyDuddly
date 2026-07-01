<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'navigation_master_category_mappings',
            function (Blueprint $table) {

                $table->id();

                $table->unsignedBigInteger(
                    'product_category_id'
                )->nullable();

                $table->unsignedBigInteger(
                    'product_sub_category_id'
                )->nullable();

                $table->unsignedBigInteger(
                    'master_category_id'
                );

                $table->unsignedInteger(
                    'priority'
                )->default(100);

                $table->timestamps();

                $table->index([
                    'product_category_id',
                ], 'idx_nmcm_category');

                $table->index([
                    'product_sub_category_id',
                ], 'idx_nmcm_subcategory');

                $table->index([
                    'master_category_id',
                ], 'idx_nmcm_master');

                $table->unique([
                    'product_category_id',
                    'product_sub_category_id',
                    'master_category_id',
                ], 'uq_nmcm_mapping');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'navigation_master_category_mappings'
        );
    }
};
