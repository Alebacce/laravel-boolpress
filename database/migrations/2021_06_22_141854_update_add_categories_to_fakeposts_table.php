<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddCategoriesToFakepostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fakeposts', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');

                    // Colonna
            $table->foreign('category_id')
                    // Colonna tabella a cui ci si riferisce
                    ->references('id')
                    // In quale tabella
                    ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fakeposts', function (Blueprint $table) {
            $table->dropForeign('fakeposts_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
