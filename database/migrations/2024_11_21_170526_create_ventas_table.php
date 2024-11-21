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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_vendedor');
            $table->foreign('id_vendedor')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('referencia', 10); 
            $table->unique(['referencia'], 'unique_referencia_factura');
            
            
            $table->decimal('valor', 15, 2); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
