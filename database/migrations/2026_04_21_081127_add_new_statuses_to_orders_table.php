<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: alter ENUM by redefining the column definition
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM(
            'pending','validated','en_preparation','expediee','livree','cancelled'
        ) NOT NULL DEFAULT 'pending'");

        DB::statement("ALTER TABLE orders ADD COLUMN delivery_date DATE NULL AFTER notes");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders DROP COLUMN delivery_date");
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM(
            'pending','validated','cancelled'
        ) NOT NULL DEFAULT 'pending'");
    }
};
