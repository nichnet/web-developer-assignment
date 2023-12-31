<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Book;

/**
 * Book Controller
 */
class BookController extends Controller {

    /**
     * Size of a page of books.
     */
    protected $pageSize;

    public function __construct() {
        $this->pageSize = 5;
    }

    public function create() {
        return view('books.create');
    }

    /**
     * Retrieves the book entries from the database and returns a listing view.
     * @param int
     */
    public function index(Request $request) {
        $page = $request->input('page');
        $query = $request->input('query');
        $sort = $request->input('sort');

        // Clamp and redirect the page if necessary.
        if ($page === null || $page < 1 || $page > $this->getTotalPages($query)) {
            return redirect()->route('index', [
                'query'=>$query, 
                'sort'=>$sort, 
                'page'=>max(1, min($page, $this->getTotalPages($query)))
            ]);
        }

        // Get the books for this page.
        $books = $this->getBooks($page, $sort, $query);


        // Return the view. 
        return view('welcome', 
            [
                'books'=>$books,
                'total_books' =>$this->getTotalBooksCount($query),
                'query'=>$query,
                'sort'=>$sort,
                'page'=>(object) [
                    'current_page'=>$page,
                    'total_pages' =>$this->getTotalPages($query)
                ]
            ]
        );
    }

    /**
     * Stores a new book entry in the database or updates an existing one if an ID is present in the form data.  
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        $existingId = $request->input('id');

        $responseMessage = 'none';

        try {
            // Validate the incoming form data
            $request->validate([
                'title'=>'required|string|max:255',
                'author'=>'required|string|max:255',
            ]);

            $data = [
                'title' => addslashes($request->input('title')),
                'author' => addslashes($request->input('author')),
            ];

            // Check if ID is present, and update exsiting if so.
            if ($existingId) {
                $book = Book::find($request->input('id'));

                if($book) { 
                    $book->update($data);
                    $responseMessage = 'success_updated';
                } else {
                    $responseMessage = 'error_not_found';
                }
            } else {
                Book::create($data);
                $responseMessage = 'success_created';
            }
        } catch(\Exception $e) {
            if ($e->getCode() === '23000') {
                // Handle constraint violation (unique title & author)
                $responseMessage = 'error_duplicate';
            } else {
                $responseMessage = 'error_unknown';
            }
        } finally {
            return redirect()->back()->with('result', $responseMessage);
        }
    }

    /**
     * Delete a book by ID.
     * @param int $id The ID of the book to be deleted.  
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        $book = Book::find($id);

        if($book) {
            $book->delete();
            return redirect()->back()->with('result', 'success_deleted');
        }
    
        return redirect()->back()->with('result', 'error_unknown');
    }

    /**
     * Handle the export of books based on user submitted form.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handleExport(Request $request) {
        $query = $request->input('query');
        $sort = $request->input('sort'); 
        $currentPage = $request->input('currentPage');
        $exportAllPages = $request->input('exportAllPages') === 'true';

        /**
         * Export Options Indexes
         * 0 -> Both Titles & Authors 
         * 1 -> Only Titles
         * 2 -> Only Authors 
         */
        $options = $request->input('exportOptions');
        
        /**
         * Export File Type
         * true -> CSV
         * false -> XML 
         */
        $exportAsCSV = $request->input('exportAsCSV') === 'true';

        //TODO index if not all.
        $boks = [];

        // Fetch the current page or all pages.
        $books = $this->getBooks($exportAllPages ? null : $currentPage, $sort, $query);

        $fileData = $this->generateFileData($books, $options, $exportAsCSV);

        // Set extension
        $extensionType = "csv";
        if($exportAsCSV !== true) {
            $extensionType = "xml";
        }

        // Create download payload and headers
        $fileName = "books.$extensionType";
        $headers = [
            'Content-Type'=>"text/$extensionType; charset=UTF-8", ///UTF-8 for character support (eg Japanese).
            'Content-Disposition'=>"attachment; filename=$fileName"
        ];

        return response($fileData, 200, $headers);
    }

    /**
     * Returns the total pages.
     * @param  string $searchQuery Optional search query when determinging the amount of pages.  
     * @return int
     */
    function getTotalPages($searchQuery = null) {
        // Use max(1, x) because getTotalBooksCount may return 0. It needs at least 1 page.
        return max(1, ceil($this->getTotalBooksCount($searchQuery) / $this->pageSize));
    }

    /**
     * Returns the total number of books in the database. If $searchQuery is present, restricts the total to those that match.
     * @param string $searchQuery Optional search query (titles/authors).
     * @returns int
     */
    function getTotalBooksCount($searchQuery = null) {
        $queryBuilder = Book::query();

        if ($searchQuery !== null) {
            // Add a WHERE clause to filter by the query
            $queryBuilder->where('title', 'like', '%' . $searchQuery . '%')
                        ->orWhere('author', 'like', '%' . $searchQuery . '%');
        }

        return $queryBuilder->count();
    }

    /**
     * Retrieve a collection of books for a specific page using offset pagination.
     * @param int $page The page number (default is 1).
     * @param string $query The search query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function getBooks($page = null, $sort = 0, $searchQuery = null) {
        $queryBuilder = Book::query();
    
        // Add the search query to the SQL query.
        if($searchQuery) {
            $queryBuilder->where('title', 'like', '%' . $searchQuery . '%')
                         ->orWhere('author', 'like', '%' . $searchQuery . '%');
        }

        // Sort, default is 0 (Title).
        $sortField = 'title'; 

        if ($sort != 0) {
            $sortField = 'author';
        }

        $queryBuilder->orderBy($sortField, 'asc');

        // Pagination
        if($page) {
            // Eensure $page is an interger (not char), and 
            // if it's a digit already, ensure its positive for user-ease (readability).
            if(!ctype_digit($page)) {
                $page = 1;
            } else {
                $page = max((int) $page, 1); 
            }

            // Ensure the requested page isn't more than the total pages.
            $page = min((int) $page, $this->getTotalPages($searchQuery)); 

            // Since offset pagination will begin at 0, subtract 1.
            $offset = ($page - 1) * $this->pageSize;
            
            $queryBuilder->offset($offset)->limit($this->pageSize);
        }
        

        // Finally return.
        return $queryBuilder->get();
    }

    /**
     * Hellper function to generate file data based on the provided books array and options, and exports it as either CSV or XML.
     * @param array $books The selected books to export.
     * @param int $options An int representing the data to include in the export (0=titles/authors, 1=titles, 2=authors).
     * @param bool $exportAsCSV Indicates whether to export the data as CSV (true) or XML (false).
     * @return string The generated file data in the selected format.
     */
    function generateFileData($books, $options, $exportAsCSV) {
        $includeTitles = true;
        $includeAuthors = true;

        if($options == 1) {
            $includeAuthors = false;
        } else if($options == 2) {
            $includeTitles = false;
        }
        
        return $exportAsCSV ? $this->writeCSV($books, $includeTitles, $includeAuthors) : $this->writeXML($books, $includeTitles, $includeAuthors);
    }

    function writeCSV($books, $includeTitles, $includeAuthors) {
        $fileData = '';

        // Set the headers
        if($includeTitles === true) {
            $fileData .= 'Title';
        }

        if($includeTitles === true && $includeAuthors === true) {
            $fileData .= ',';
        }

        if($includeAuthors === true) {
            $fileData .= 'Author';
        }

        $fileData .= "\n";

        // Set the book data.
        foreach($books as $book) {
            if($includeTitles === true) {
                $fileData .= $book->title;
            }

            if($includeTitles === true && $includeAuthors === true) {
                $fileData .= ',';
            }

            if($includeAuthors === true) {
                $fileData .= $book->author;
            }

            $fileData .= "\n";
        }

        return $fileData;
    }

    function writeXML($books, $includeTitles, $includeAuthors) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<books>' . "\n";
    
        // Set the book data.
        foreach ($books as $book) {
            $xml .= '<book>';
    
            if ($includeTitles === true) {
                $xml .= '<title>' . $book->title . '</title>';
            }
    
            if ($includeAuthors === true) {
                $xml .= '<author>' . $book->author . '</author>';
            }
    
            $xml .= '</book>' . "\n";
        }
    
        $xml .= '</books>';
    
        return $xml;
    }
}