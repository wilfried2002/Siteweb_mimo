<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            // Allow candidatures spontanées (no specific job offer)
            $table->dropForeign(['job_offer_id']);
            $table->unsignedBigInteger('job_offer_id')->nullable()->change();
            $table->foreign('job_offer_id')->references('id')->on('job_offers')->nullOnDelete();

            $table->string('desired_position')->nullable()->after('job_offer_id');
            $table->string('lettre_path')->nullable()->after('cv_path');
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign(['job_offer_id']);
            $table->unsignedBigInteger('job_offer_id')->nullable(false)->change();
            $table->foreign('job_offer_id')->references('id')->on('job_offers')->cascadeOnDelete();

            $table->dropColumn(['desired_position', 'lettre_path']);
        });
    }
};
