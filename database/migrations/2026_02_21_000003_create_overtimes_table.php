<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'overtimes', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->string( 'dept' )->nullable();
            $table->date( 'ot_date' );
            $table->decimal( 'salary', 12, 2 )->default( 0 );
            $table->time( 'in_time' );
            $table->time( 'out_time' );
            $table->decimal( 'hrs', 6, 2 )->default( 0 );
            $table->decimal( 'amount', 12, 2 )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'overtimes' );
    }
};
