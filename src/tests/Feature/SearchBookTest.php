<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;

class SearchBookTest extends TestCase {
    
    /**
     * Tests if an existing book can be found by title.
     * @return void
     */
    public function testSearchForBookByTitle() {
        $book = $this->generateBook();

        // Perform the GET.
        $response = $this->withoutMiddleware()->followingRedirects()->get(route('index', [
            'query' => $book['title']
        ]));

        $responseContent = json_decode($response->original->getData()['books']);
        $titles = array_column($responseContent, 'title');

        // Assert that the result is as expected.
        $this->assertContains($book['title'], $titles);
    }

    /**
     * Tests if an existing book can be found by author.
     * @return void
     */
    public function testSearchForBookByAuthor() {
        $book = $this->generateBook();

        // Perform the GET.
        $response = $this->withoutMiddleware()->followingRedirects()->get(route('index', [
            'query' => $book['author']
        ]));

        $responseContent = json_decode($response->original->getData()['books']);
        $authors = array_column($responseContent, 'author');

        // Assert that the result is as expected.
        $this->assertContains($book['author'], $authors);
    }

    function generateBook() {
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
            return null;
        }

        return $newBookData;
    }
}
