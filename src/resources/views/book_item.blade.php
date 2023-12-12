<!-- Book Item Row -->
<tr>
    <td>{{ $book->title}}</td>
    <td>{{ $book->author}}</td>
    <td>
        <button class="green" onclick="showComposeBookModal('{{$book->id}}', '{{$book->title}}', '{{$book->author}}');">Edit</button>
    </td>
    <td class="fit-content">
        <form method="post" action="{{ route('books.destroy', $book->id) }}" onsubmit="return confirm('Are you sure you want to delete this book?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="button red">Delete</button>
        </form>    
    </td>
</tr>