<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();   // admin, commercial, magasinier, rh
            $table->string('label');             // Admin, Commercial, Magasinier, RH
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['name' => 'admin',       'label' => 'Administrateur',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'commercial',  'label' => 'Commercial',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'magasinier',  'label' => 'Magasinier',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'rh',          'label' => 'Ressources Humaines', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
