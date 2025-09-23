<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get the actual foreign key constraint names
        $carProductsConstraint = $this->getForeignKeyConstraintName('car_products', 'supplier_id');
        $carBrandsConstraint = $this->getForeignKeyConstraintName('car_brands', 'supplier_id');

        // Remove foreign key constraints if they exist
        if ($carProductsConstraint) {
            Schema::table('car_products', function (Blueprint $table) use ($carProductsConstraint) {
                $table->dropForeign($carProductsConstraint);
                $table->dropColumn('supplier_id');
            });
        }

        if ($carBrandsConstraint) {
            Schema::table('car_brands', function (Blueprint $table) use ($carBrandsConstraint) {
                $table->dropForeign($carBrandsConstraint);
                $table->dropColumn('supplier_id');
            });
        }

        // Drop the suppliers table
        Schema::dropIfExists('suppliers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the suppliers table
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('id');
            $table->string('company_name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
        });

        // Add back the foreign key columns
        Schema::table('car_products', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });

        Schema::table('car_brands', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
    }

    /**
     * Get the actual foreign key constraint name from the database
     */
    private function getForeignKeyConstraintName($table, $column)
    {
        $constraint = DB::select("
            SELECT tc.constraint_name
            FROM information_schema.table_constraints tc
            JOIN information_schema.key_column_usage kcu
                ON tc.constraint_name = kcu.constraint_name
            WHERE tc.constraint_type = 'FOREIGN KEY'
                AND tc.table_name = ?
                AND kcu.column_name = ?
        ", [$table, $column]);

        return $constraint ? $constraint[0]->constraint_name : null;
    }
};
