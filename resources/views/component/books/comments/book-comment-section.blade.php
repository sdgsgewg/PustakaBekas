<div class="mt-0">
    <hr>
    <h2 class="mb-3">Discussions</h2>

    <!-- Comment Form -->
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            <textarea name="comment" id="comment" class="form-control" placeholder="Write your comment here" rows="3" required
                oninput="handlePostBtn()" onclick="toggleCommentButtonVisibility()"></textarea>
        </div>
        <!-- Button Container -->
        <div id="commentBtnContainer" class="justify-content-end gap-3" style="display: none;">
            <button id="cancel" type="button" class="btn btn-secondary"
                onclick="hideCommentButtonContainer()">Cancel</button>
            <button id="post" type="submit" class="btn btn-primary" disabled>Post</button>
        </div>
    </form>

    <hr>

    @if ($comments->count() > 0)
        <!-- Existing Comments -->
        <div class="comments-list">
            @foreach ($comments as $comment)
                <div class="mb-3">
                    @include('component.books.comments.comment-section')
                </div>
            @endforeach
        </div>
        <hr>
    @endif
</div>
