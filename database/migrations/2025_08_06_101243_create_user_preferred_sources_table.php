<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPreferredSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_preferred_sources', function (Blueprint $table) {
             $table->unsignedBigInteger('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            // Foreign key to sources table
            $table->unsignedBigInteger('source_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['user_id', 'source_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_preferred_sources');
    }
}
