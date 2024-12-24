<div class="modal fade" id="proposeTradeModal" tabindex="-1" aria-labelledby="proposeTradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="proposeTradeModalLabel">
                    Propose Book Trade
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form for proposing a trade -->
            <form action="{{ route('trades.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_2" class="form-label">User to trade with:</label>
                        <input type="hidden" class="form-control" id="user_2_id" name="user_2_id"
                            value="{{ $book->seller->id }}">
                        <input type="text" class="form-control" id="user_2" name="user_2"
                            value="{{ $book->seller->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="book_2" class="form-label">Book you want to receive:</label>
                        <input type="hidden" class="form-control" id="book_2_id" name="book_2_id"
                            value="{{ $book->id }}">
                        <input type="text" class="form-control" id="book_2" name="book_2"
                            value="{{ $book->title }}" readonly>
                        <input type="text" class="form-control"
                            value="{{ 'Rp' . number_format($book->price, 2, ',', '.') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="book_1_id" class="form-label">Select your book:</label>
                        <select name="book_1_id" id="book_1_id" class="form-select">
                            <option value="">Select a book</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }} |
                                    Rp{{ number_format($book->price, 2, ',', '.') }}</option>
                            @endforeach
                        </select>
                        <small class="fst-italic text-muted">*You can only trade books within a 10% price range.</small>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Propose Trade</button>
                </div>
            </form>
        </div>
    </div>
</div>
