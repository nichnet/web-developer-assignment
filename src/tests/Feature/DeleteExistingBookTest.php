<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;

class DeleteExistingBookTest extends TestCase {
    
    /**
     * Tests if an existing book can be deleted by ID.
     * @return void
     */
    public function testDeleteExistingBook() {
        // Randomly generate a title and author so that it is ensured not to exist.
        $newBookData = [
            'title'=>Str::uuid()->toString(),
            'author'=>Str::uuid()->toString()
        ];

        // Insert the dummy book.
        $book = Book::create($newBookData);

        if(!$book) {
            // Unable to create the test book. 
            $this->fail("Test book could not be created.");
            return;
        }

        echo("\n" . 'Created test book: ID: "' . $book['id'] . '", Title: "' . $book['title'] . '" , Author: "' . $book['author'] . '"');
        echo("\nPerforming DELETE.");

        // Perform the DELETE.
        $response = $this->withoutMiddleware()->delete(route('books.destroy', $book['id']));

        // Assert: Verify the result.
        $result = session('result');

        // Assert that the result is as expected (success_deleted).
        $this->assertEquals('success_deleted', $result);
    }
}
