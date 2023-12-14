<!-- Book Item Row -->
<tr>
    <!-- Conditional Formatting, bold based on sorting type. -->
    <td>{!! $sort == 0 ? '<b>' . @e($book->title) . '</b>' : @e($book->title) !!}</td>
    <td>{!! $sort == 1 ? '<b>' . @e($book->author) . '</b>' : @e($book->author) !!}</td>
    <td>
        <button class="green" onclick="showComposeBookModal({{ json_encode($book->id) }}, {{ json_encode($book->title) }}, {{json_encode($book->author) }});">Edit</button>
    </td>
    <td class="fit-content">
        <form method="post" action="{{ route('books.destroy', $book->id) }}" onsubmit="return confirm('Are you sure you want to delete this book?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="button red">Delete</button>
        </form>    
    </td>
</tr>