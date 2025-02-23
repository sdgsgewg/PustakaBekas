@extends('layouts.main')

@section('container')
    <div class="row justify-content-center my-4">
        <div class="col-11 col-md-8 col-lg-7 d-flex justify-content-between pb-2 border-bottom">
            <h1>{{ $title }}</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12 d-flex flex-column align-items-center">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show col-lg-6" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="img-thumbnail rounded-circle overflow-hidden mb-4" style="width: 200px; height: 200px;">
                @if ($user->image)
                    <img src="{{ secure_asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                        class="rounded-circle">
                @else
                    <img src="{{ secure_asset('img/' . $user->gender . ' icon.png') }}" alt="{{ $user->name }}"
                        class="rounded-circle">
                @endif
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" value="{{ $user->username }}" readonly>
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
    </div>
@endsection
