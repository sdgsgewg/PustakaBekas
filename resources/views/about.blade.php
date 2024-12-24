@extends('layouts.main')

@section('css')
    <style>
        .img-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        .shadow-lg {
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('container')
    <div class="row justify-content-center align-items-center mt-5">
        <div class="col-11">
            <div class="row d-flex flex-wrap">
                <!-- Image Section -->
                <div class="col-12 col-lg-5 mb-4 mb-lg-0 d-flex justify-content-center">
                    <div class="img-wrapper rounded-circle overflow-hidden shadow-lg" style="width: 400px; height: 400px;">
                        <img src="{{ secure_asset('img/about.jpg') }}" alt="About Us Image" class="">
                    </div>
                </div>

                <!-- Text Section -->
                <div class="col-12 col-lg-7">
                    <h1 class="mb-3 fw-bold">About Us</h1>
                    <p class="fs-5">
                        Our platform, <span class="fw-bold">PustakaBekas</span> is dedicated to simplifying book
                        transactions by enabling users to buy, sell, or trade
                        books effortlessly. We aim to make books more accessible, reduce costs, and promote sustainability
                        through our trade feature, which allows users to exchange books they no longer need for ones they
                        desire.
                    </p>
                    <p class="fs-5">
                        With user-friendly tools, you can upload photos, provide detailed descriptions, and set prices to
                        ensure
                        transparent and seamless transactions.
                        {{-- Our chat feature fosters direct communication, making
                        negotiations and coordination easy. --}}
                    </p>
                    <p class="fs-5">
                        We’re more than a marketplace—we’re a community for book lovers, promoting affordability,
                        sustainability, and connection. Join us and discover a smarter way to enjoy books!
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
