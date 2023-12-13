<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddNewBookTest extends TestCase {
    
    /**
     * Tests if a new unique book can be successfully added.
     * @return void
     */
    public function testAddNewBook() {
        // Generate dummy book data.
        $newBookData = [
            'title'=>Str::uuid()->toString(),
            'author'=>Str::uuid()->toString()
        ];

        echo("\n" . 'Created test book: Title: "' . $newBookData['title'] . '" , Author: "' . $newBookData['author'] . '"');
        echo("\nPerforming POST.");

        // Perform the POST.
        $response = $this->withoutMiddleware()->post(route('books.store'), $newBookData);

        // Assert: Verify the result.
        $result = session('result');

        // Assert that the result is as expected (success_created).
        $this->assertEquals('success_created', $result);
    }
}
