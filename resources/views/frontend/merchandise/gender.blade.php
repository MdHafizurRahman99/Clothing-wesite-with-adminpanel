@extends('layouts.frontend.master')
@section('css')
    <style>
        .gender-link {
            display: block;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .gender-link:hover {
            transform: scale(1.05);
        }

        .gender-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin: 50px;

        }

        .gender-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .gender-link:hover .gender-image-container {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>
    {{-- <style>
        .gender-link {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .gender-link:hover {
            color: #666;
        }

        .cat-item {
            text-align: center;
        }

        .gender-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin: 50px;
        }

        .gender-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .gender-name {
            margin-top: 1rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .gender-link:hover .gender-image-container {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style> --}}
@endsection
@section('content')
    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Select</span>
        </h2>
        <div class="row px-xl-5 pb-3 justify-content-center">
            @php
                $genders = ['Man', 'Women', 'Kids', 'Unisex'];
            @endphp
            @foreach ($genders as $gender)
                @if ($products->where('gender', $gender)->isNotEmpty())
                    {{-- <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mt-2"> --}}
                    <a class="gender-link"
                        href="{{ route('shop.products', ['product_for' => 'Buy Blank', 'category_id' => $category_id, 'gender' => $gender]) }}">
                        <div class="gender-image-container">
                            @if ($gender == 'Man')
                                <img class="img-fluid gender-image" src="{{ asset('frontend/img/Gender images/Man.png') }}"
                                    alt="{{ $gender }}">
                            @elseif($gender == 'Women')
                                <img class="img-fluid gender-image"
                                    src="{{ asset('frontend/img/Gender images/women.png') }}" alt="{{ $gender }}">
                            @elseif($gender == 'Kids')
                                <img class="img-fluid gender-image" src="{{ asset('frontend/img/Gender images/kids.png') }}"
                                    alt="{{ $gender }}">
                            @elseif($gender == 'Unisex')
                                <img class="img-fluid gender-image" src="" alt="{{ $gender }}">
                            @endif

                        </div>
                    </a>
                    {{-- </div> --}}
                @endif
            @endforeach
        </div>
        {{-- <div class="row px-xl-5 pb-3 justify-content-center">
            @foreach ($genders as $gender)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mt-2">
                    <a class="text-decoration-none gender-link" href="{{ route('shop.show', ['shop' => $gender]) }}">
                        <div class="cat-item d-flex flex-column align-items-center mb-4">
                            <div class="gender-image-container">
                                <img class="img-fluid gender-image" src="{{ asset($gender->image) }}"
                                    alt="{{ $gender->gender_name }}">
                            </div>
                            <h6 class="gender-name mt-2">{{ $gender->gender_name }}</h6>
                        </div>
                    </a>
                </div>
            @endforeach
        </div> --}}
    </div>
    <!-- Categories End -->
@endsection
