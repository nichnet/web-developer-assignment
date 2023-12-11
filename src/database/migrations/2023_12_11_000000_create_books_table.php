 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Database Table Migration
 */
class CreateBooksTable extends Migration {
    
    /**
     * Run the migrations.
     * @return void
     */
    public function up() { 
        Schema::create('books', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 256)->nullable(false);
            $table->string('author', 256)->nullable(false);

            // Unique constaint to ensure that the same book/author combination isn't entered into the database. 
            // However, there may be a book with same name, but different author, which is acceptable.
            $table->unique(['title', 'author']);
        });

    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() {
        Schema::dropIfExists('books');
    }
}
