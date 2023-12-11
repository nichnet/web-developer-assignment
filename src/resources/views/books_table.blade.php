<!-- Books Table -->
<table class="rounded">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book) 
            @include('book_item', ['book' => $book])
        @endforeach
    </tbody>
</table>