<!-- Compose Book Modal -->
<div id="modalContainerComposeBook" class="modal">
    <div class="modal-content rounded">
        <span class="close" id="btnCloseModal">&times;</span>
        <h4 style="margin: 0" id="modalTitle">Add Book</h4>
        <form method="post" action="{{route('books.store')}}">
            @csrf
            <input type="hidden" id="modalBookId" name="id">
            <div style="display: flex; flex-direction: column;">
                <label for="title">Title</label>
                <input type="text" id="modalBookTitle" name="title" required><br>
            </div>
            <div style="display: flex; flex-direction: column;">
                <label for="author">Author</label>
                <input type="text" id="modalBookAuthor" name="author" required><br>
            </div>
            <div style="display: flex; flex-direction: column; ">
                <label>&nbsp;</label>
                <input style="align-self: flex-end;" class="button green" type="submit" value="Save"/>
            </div>
        </form>
    </div>
</div>