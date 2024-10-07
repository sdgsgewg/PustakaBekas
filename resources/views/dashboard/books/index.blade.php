@extends('dashboard.layouts.main')

@section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Books</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive small col-lg-12">
        <a href="{{ route('auth.books.create') }}" class="btn btn-primary mb-3">Create new book</a>

        @if ($books->count())
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Author</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->genre->name }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ number_format($book->price, 0, ',', '.') }}</td>
                            <td>

                                <a href="{{ route('auth.books.show', ['book' => $book->slug]) }}"
                                    class="badge bg-info">
                                    <i class="bi bi-eye icon"></i>
                                </a>

                                <a href="{{ route('auth.books.edit', ['book' => $book->slug]) }}"
                                    class="badge bg-warning">
                                    <i class="bi bi-pencil-square icon"></i>
                                </a>

                                <form action="{{ route('auth.books.destroy', ['book' => $book->slug]) }}"
                                    method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="badge bg-danger border-0"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-x-circle icon"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <tbody>
                <tr>
                    <td class="col-lg-8">
                        <p class="text-center">No book found.</p>
                    </td>
                </tr>
            </tbody>
        @endif
    </div>
@endsection
