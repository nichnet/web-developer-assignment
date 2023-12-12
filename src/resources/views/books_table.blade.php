<!-- Books Table -->
@if (count($books) > 0)
    <table class="highlighted border rounded">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th></th>
                <th class="fit-content"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book) 
                @include('book_item', ['book' => $book])
            @endforeach
        </tbody>
    </table>
@else
    <center>
        <h3>No books found!</h3>                
    </center>
@endif
