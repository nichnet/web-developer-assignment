<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;

class ExportBooksTest extends TestCase {
    
    public function __construct() {
        parent::__construct();
        // Ensure there are some books in the database already.
        for($i = 0; $i < 5; $i++) {
            // Randomly generate a title and author so that it is ensured not to exist.
            $newBookData = [
                'title'=>Str::uuid()->toString(),
                'author'=>Str::uuid()->toString()
            ];
            
            // Insert the dummy book.
            $book = Book::create($newBookData);
        }
    }

    /**
     * Tests if existing books can be exported as CSV.
     * @return void
     */
    public function testExportBooksAsCSV() {
        $response = $this->withoutMiddleware()->followingRedirects()->get(route('books.export', [
            'exportAsCSV' => 1, // 1 for exporting as CSV
        ]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
    }

    /**
     * Tests if existing books can be exported as XML.
     * @return void
     */
    public function testExportBooksAsXML() {
        $response = $this->withoutMiddleware()->followingRedirects()->get(route('books.export', [
            'exportAsCSV' => 0, // 0 for exporting as XML
        ]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
    }

}
