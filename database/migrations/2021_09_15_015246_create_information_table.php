<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('mediator_id');
            $table->foreign('mediator_id')->references('id')->on('mediators');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts'); 
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->text('description')->nullable();
            $table->string('first_meeting');
            $table->string('next_meeting')->nullable();
            $table->string('spend_time')->nullable();
            $table->string('time')->nullable();
            $table->string('allocated_time')->nullable();
            $table->integer('priority')->nullable(); //1 for high 2 for medium  3 for low
            // $table->integer('count')->default(0); //1 for firstt
            $table->integer('sort_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable();
            $table->string('created_at_np',20);
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
        Schema::dropIfExists('information');
    }
}
