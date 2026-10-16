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
        // Legal Cases (deposits)
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();          // Auto-generated unique docket number
            $table->string('title');                          // Case title
            $table->text('description')->nullable();          // Case synopsis
            $table->unsignedBigInteger('created_by');         // Lawyer who created the case
            $table->enum('status', ['open', 'under_review', 'closed', 'archived'])->default('open');
            $table->string('court_reference')->nullable();    // External court reference
            $table->date('hearing_date')->nullable();         // Scheduled hearing date
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        // Pivot: link evidence to cases
        Schema::create('case_evidence', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('case_id');
            $table->unsignedBigInteger('evidence_id');
            $table->unsignedBigInteger('added_by');           // Who linked the evidence
            $table->text('notes')->nullable();                // Notes about this evidence in context of the case
            $table->integer('sort_order')->default(0);        // Ordering within the case
            $table->timestamps();

            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
            $table->foreign('evidence_id')->references('id')->on('evidence')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['case_id', 'evidence_id']); // Prevent duplicate links
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_evidence');
        Schema::dropIfExists('cases');
    }
};
