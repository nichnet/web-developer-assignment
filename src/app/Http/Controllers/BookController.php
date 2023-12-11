<?php 

namespace App\Http\Controllers;
use App\Models\Book;

/**
 * Book Controller
 */
class BookController extends Controller {

    /**
     * Retrieves the book entries from the database and returns a listing view.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $books = Book::all();
        return view('book', ['books' => $books]);
    } 

    /**
     * Creates a new book entry in the database.  
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        // Get the form data
        $title = $request->input('title');
        $author = $request->input('author');

        // Insert data in DB
        // TODO Insert data in DB
    }
}