<div class="modal fade" id="maxQtyModal-{{ $book->id }}" tabindex="-1"
    aria-labelledby="maxQtyModalLabel-{{ $book->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="maxQtyModalLabel-{{ $book->id }}">
                    Quantity Limit Reached
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You have reached the maximum allowed quantity for "{{ $book->title }}"
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>