@extends('layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">{{ $title }}</h1>
    </div>

    <div class="col-lg-12 d-flex flex-column align-items-center">

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show col-lg-6" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-4" style="width: 200px; height: 200px;">
            @if ($user->image)
                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                    class="img-thumbnail rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <img src="{{ asset('img/male icon.png') }}" alt="{{ $user->name }}" class="img-thumbnail rounded-circle"
                    style="width: 100%; height: 100%; object-fit: cover;">
            @endif
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" value="{{ $user->name }}">
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" value="{{ $user->address }}" readonly>
        </div>

        <div class="col-12 col-md-6 mb-3">
            <label for="phoneNumber" class="form-label">Phone Number</label>
            <input type="text" class="form-control" value="{{ $user->phoneNumber }}" readonly>
        </div>

        <a class="btn btn-primary mt-4 text-decoration-none text-white"
            href="{{ route('users.edit', ['user' => $user->username]) }}">
            Update Profile
        </a>
    </div>
@endsection
