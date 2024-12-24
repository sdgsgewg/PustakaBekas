<div class="modal fade" id="removeModal-{{ $book->id }}" tabindex="-1"
    aria-labelledby="removeModalLabel-{{ $book->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="removeModalLabel-{{ $book->id }}">
                    Confirm Removal
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to remove book "{{ $book->title }}" from the
                cart?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('carts.destroy', ['cart' => $cart->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <button type="submit" class="btn btn-primary">Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>
