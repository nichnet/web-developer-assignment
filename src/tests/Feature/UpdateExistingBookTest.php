<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;

class UpdateExistingBookTest extends TestCase {

    /**
     * Tests if an existing book can be updated by ID.
     * @return void
     */
    public function testUpdateExistingBook() {
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
        echo("\nPerforming POST.");

        // Generate a different title and author for the existing ID.
        $updatedBookData = [
            'id'=>$book->id, // Existing ID
            'title'=>Str::uuid()->toString(),
            'author'=>Str::uuid()->toString()
        ];

        echo("\n" . 'Updating Book with ID: "' . $book->id . '"');

        // Perform the POST.
        $response = $this->withoutMiddleware()->post(route('books.store'), $updatedBookData);

        // Assert: Verify the result.
        $result = session('result');

        // Assert that the result is as expected (success_updated).
        $this->assertEquals('success_updated', $result);
    }
}
