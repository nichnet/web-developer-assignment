<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;

class SortBooksTest extends TestCase {
    
    use RefreshDatabase;
    
    /**
     * Tests if existing books can be sorted.
     * @return void
     */
    public function testSortBooks() {
        $testBooksData = [];

        // Create random unique book titles and authors.
        for ($i = 0; $i < 5; $i++) {
            $book = [
                'title'=>Str::uuid()->toString(),
                'author'=>Str::uuid()->toString()
            ];

            // Add to array to sort later.
            array_push($testBooksData, $book);

            // Add book to database.
            Book::create($book);
        }
        
        echo("\nPerforming sorting by title.");
        $this->sortByTitle($testBooksData);
        echo("\nPerforming sorting by author.");
        $this->sortByAuthor($testBooksData);
    }

    /**
     * Tests if existing books can be sorted by title.
     * @return void
     */
    function sortByTitle($testBooksData) {
        // Perform the GET.
        $response = $this->withoutMiddleware()->followingRedirects()->get(route('index', [
            'sort' => 0, // 0 for sorting by title
        ]));

        // Manually sort by title.
        usort($testBooksData, function ($a, $b) {
            return strcmp($a['title'], $b['title']);
        }); 

        // Extract response data.
        $responseContent = json_decode($response->original->getData()['books']);

        // Assert: Verify the result.
        for($i = 0; $i < count($testBooksData); $i++) {
            $this->assertEquals($testBooksData[$i]['title'], $responseContent[$i]->title);
        }
    }

    /**
     * Tests if existing books can be sorted by author.
     * @return void
     */
    public function sortByAuthor($testBooksData) {
        // Perform the GET.
        $response = $this->withoutMiddleware()->followingRedirects()->get(route('index', [
            'sort' => 1, // 1 for sorting by author
        ]));

        // Manually sort by title.
        usort($testBooksData, function ($a, $b) {
            return strcmp($a['author'], $b['author']);
        }); 

        // Extract response data.
        $responseContent = json_decode($response->original->getData()['books']);

        // Assert: Verify the result.
        for($i = 0; $i < count($testBooksData); $i++) {
            $this->assertEquals($testBooksData[$i]['author'], $responseContent[$i]->author);
        }
    }
}
