@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Book Genres</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-8" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive small col-lg-8">
        <a href="{{ route('admin.genres.create') }}" class="btn btn-primary mb-3">Create New Genre</a>

        <div class="accordion" id="accordionExample">
            @foreach ($categories as $ctg)
                <?php $idx = 0; ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ session('category_id') == $ctg->id ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}"
                            aria-expanded="{{ session('category_id') == $ctg->id ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $loop->iteration }}">
                            {{ $ctg->name }}
                        </button>
                    </h2>
                    <div id="collapse{{ $loop->iteration }}"
                        class="accordion-collapse collapse {{ session('category_id') == $ctg->id ? 'show' : '' }}"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Genre Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($genres as $genre)
                                        @if ($genre->category_id == $ctg->id)
                                            <?php $idx++; ?>
                                            <tr>
                                                <td>{{ $idx }}</td>
                                                <td>{{ $genre->name }}</td>
                                                <td>

                                                    <a href="{{ route('admin.genres.edit', ['genre' => $genre->slug]) }}"
                                                        class="badge bg-warning">
                                                        <i class="bi bi-pencil-square icon"></i>
                                                    </a>

                                                    <button type="button" class="badge bg-danger border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal-{{ $genre->id }}">
                                                        <i class="bi bi-x-circle icon"></i>
                                                    </button>

                                                    <div class="modal fade" id="deleteModal-{{ $genre->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel-{{ $genre->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5"
                                                                        id="deleteModalLabel-{{ $genre->id }}">
                                                                        Confirm Deletion</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete the genre
                                                                    "{{ $genre->name }}"?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="{{ route('admin.genres.destroy', ['genre' => $genre->slug]) }}"
                                                                        method="POST" class="d-inline">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ secure_asset('js/script.js') }}"></script>
@endsection
