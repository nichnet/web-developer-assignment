// Database Table Migration 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration {
    
    // Create database table migration
    public function up() { 
        Schema::create('books', function(Blueprint $table) {
            $table->string('name');
            $table->string('author');
        });
    }

    public function donw() {
        Schema::dropIfExists('tables');
    }
}