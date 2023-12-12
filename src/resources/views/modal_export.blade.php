<!-- Export Modal -->
<div id="modalContainerExport" class="modal">
    <div class="modal-content rounded">
        <span class="close" id="btnCloseModal">&times;</span>
        <h4 style="margin: 0">Export File</h4>
        <form method="get" action="{{route('books.export')}}">
            <input type="hidden" name="query" value="{{ $query }}">
            <input type="hidden" name="currentPage" value="{{ $page->current_page }}">
            <div style="display:flex; flex-direction: column; margin: 12px">
                <label>Books</label>
                <label for="exportAllPages"><input type="radio"  id="exportAllPages" name="exportAllPages" value="true" checked/>All ({{$total_books}}) Books</label>
                <label for="exportCurrentPage"><input type="radio" id="exportCurrentPage" name="exportAllPages" value="false"/>This Page Only</label>
            </div>
            <div style="display:flex; flex-direction: column; margin: 12px">
                <label>Export Options</label>
                <select name="exportOptions" class="border" style="width: 100%; max-width: 200px;">
                    <option value="0">Both Titles & Authors</option>
                    <option value="1">Only Titles</option>
                    <option value="2">Only Authors</option>
                </select>
                <label>Sort</label>
                <select name="sort" class="border" style="width: 100%; max-width: 200px;">
                    <option value="0">Sort by Title</option>
                    <option value="1">Sort by Author</option>
                </select>
            </div>
            <div style="display:flex; flex-direction: column; margin: 12px">
                <label>File Type</label>
                <label for="exportTypeCSV"><input type="radio" id="exportTypeCSV" name="exportAsCSV" value="true" checked/>CSV</label>
                <label for="exportTypeXML"><input type="radio" id="exportTypeXML" name="exportAsCSV" value="false"/>XML</label>
            </div>
            <div class="right-align">
                <input type="submit" class="button" value="Export"/>
            </div>
        </form>
    </div>
</div>