<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            // The judge this docket has been pushed/assigned to by the lawyer
            $table->unsignedBigInteger('assigned_judge_id')->nullable()->after('created_by');
            $table->foreign('assigned_judge_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['assigned_judge_id']);
            $table->dropColumn('assigned_judge_id');
        });
    }
};
