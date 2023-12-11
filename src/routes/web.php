<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BookController;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $limit = 5;
    
    $page = $request->input('page');

    if ($page !== null) {
        // Eensure $page is an interger (not char), and 
        // if it's a digit already, ensure its positive for user-ease (readability).
        if(!ctype_digit($page)) {
            $page = 1;
        } else {
            $page = max((int) $page, 1); 
        }

        // Since offset pagination will begin at 0, subtract 1.
        $offset = ($page - 1) * $limit;
        $books = Book::offset($offset)->limit($limit)->get();
    } else {
        //Retrieve all books if $page isn't set.
        $books = Book::all();
    }
    return view('welcome', 
        [
            'books' => $books,
            'total' => getTotalBooksCount()
        ]
    );
});

/**
 * Function to get the total number of books in the database.
 * @returns int
 */
function getTotalBooksCount() {
    return Book::count();
}