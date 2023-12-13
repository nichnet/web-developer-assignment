<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Web Dev Assignment</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('styles.css') }}">
    </head>
    <body>

        @include('modal_message')
        @include('modal_compose_book')
        @include('modal_export', ['total_books' => $total_books])

        <div class="container">

            <center>
                <h2>Web Dev Assignment</h2>
                <img src="https://cdn.jsdelivr.net/npm/twemoji@11.3.0/2/svg/1f4d6.svg" width="64px"/>
            </center>

            <div style="margin: 12px 0; display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                <div style="display: flex">
                    <form action="{{ route('index') }}" method="get" style="display: inline-block;">
                        <input type="text" name="query" placeholder="Search..." value="{{ $query }}" />
                        <select name="sort" style="margin-left: 4px" class="border" onchange="submit()">
                            <option value="0" {{ $sort === '0' ? "selected" : '' }}>Sort by Title</option>
                            <option value="1" {{ $sort === '1' ? 'selected' : '' }}>Sort by Author</option>
                        </select>
                    </form>

                    @if($query !== null)
                        <button class="red" onclick="window.location.href='/'">Clear Search</button>
                    @endif

                    <p style="margin: 0 12px; display: flex; align-items: center; justify-content: center">{{ $total_books }} {{ $total_books == 1 ? "Result" : "Results" }}</p>
                </div>
                
                <div style="display: flex; flex-direction: row; align-items: center;">
                    <button class="green" onclick="showComposeBookModal();">Add Book</button>

                    @if(count($books) > 0)
                        <button class="button" id="btnOpenExportModal" onclick="showExportModal();">Export</button>
                    @endif
                </div>
            </div>


            @include('books_table', ['books' => $books])

            <div style=" justify-content: end;">
                
            </div>
    
            <p style="text-align: center; margin: 12px;">
                <a href="{{ route('index', ['page'=>1, 'query'=>$query]) }}" class="{{ $page->current_page <= 1 ? 'disabled-link' : '' }}">First</a>
                <a href="{{ route('index', ['page'=>$page->current_page - 1, 'query'=>$query]) }}" class="{{ $page->current_page <= 1 ? 'disabled-link' : '' }}">Prev</a>
                - {{ $page->current_page }} of {{ $page->total_pages }} - 
                <a href="{{ route('index', ['page'=>$page->current_page + 1, 'query'=>$query]) }}" class="{{ $page->current_page >= $page->total_pages ? 'disabled-link' : '' }}">Next</a>
                <a href="{{ route('index', ['page'=>$page->total_pages, 'query'=>$query]) }}" class="{{ $page->current_page >= $page->total_pages ? 'disabled-link' : '' }}">Last</a>
            </p>
        </div>

        <script src="{{ asset('js/modals.js') }}"></script>

        @if(session()->has('result'))
            <script>
                // Display an alert upon successful book addition
                window.onload = function() {
                    let result = @json(session('result'));
                    console.log(result);

                        let msg = "";

                        switch(result) {
                            case('success_created'):
                                msg = "Book added successfully!";
                                break;            
                            case('success_updated'):
                                msg = "The book has been updated!";
                                break;
                            case('success_deleted'):
                                msg = "Book deleted successfully!";
                                break;            
                            case('error_duplicate'):
                                msg = "This book already exists!";
                                break;        
                            case('error_not_found'):
                                msg = "The book couldn't be found!";
                                break;        
                            default:
                                msg = "Something went wrong!";
                                break;    
                        }
 
                        // Show the modal.
                        showMessageModal("Message", msg);

                }
            </script>
        @endif
    </body>
</html>
