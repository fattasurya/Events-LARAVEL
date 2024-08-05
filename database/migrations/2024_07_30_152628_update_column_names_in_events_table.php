<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnNamesInEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Assuming you've manually renamed 'location' to 'room' and 'category' to 'shirt'
            // You can leave this method empty or add appropriate logic if needed
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Revert changes if needed
        });
    }
}
