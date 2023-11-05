<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class MigrationExample {

    public function __construct()
    {
        // This for Example Code.
        
        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Capsule::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->integer('created_by')->unsigned();
            $table->timestamps();
        });
    }

}