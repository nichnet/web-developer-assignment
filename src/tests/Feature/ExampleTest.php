<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * Tests if a new unique book can be successfully added.
     * @return void
     */
    public function AddNewBookTest() {
        // Generate dummy book data.
        $newBookData = [
            'title'=> 'Treasure Island',
            'author'=> 'Robert Louis Stevenson'
        ];

        // Perform the POST.
        $response = $this->post(route('books.store'), $bookData);

        // Assert: Verify the result.
        $response->assertStatus(201);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
