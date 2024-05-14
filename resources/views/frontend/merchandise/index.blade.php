@extends('layouts.frontend.master')
@section('css')
    <style>
        .category-link {
            display: block;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .category-link:hover {
            transform: scale(1.05);
        }

        .category-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .category-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .category-link:hover .category-image-container {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>
    {{-- <style>
        .category-link {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .category-link:hover {
            color: #666;
        }

        .cat-item {
            text-align: center;
        }

        .category-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .category-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .category-name {
            margin-top: 1rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .category-link:hover .category-image-container {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style> --}}
@endsection
@section('content')
    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span
                class="bg-secondary pr-3">Categories</span></h2>
        <div class="row px-xl-5 pb-3 justify-content-center">
            @foreach ($categories as $category)
                @if ($products->where('category_id', $category->id)->where('product_for', 'Buy Blank')->isNotEmpty())
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mt-2">
                        <a class="category-link" href="{{ route('shop.show', ['product_for'=>'Buy Blank','shop' => $category->id]) }}">
                            <div class="category-image-container">
                                <img class="img-fluid category-image" src="{{ asset($category->image) }}"
                                    alt="{{ $category->category_name }}">
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
        {{-- <div class="row px-xl-5 pb-3 justify-content-center">
            @foreach ($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1 mt-2">
                    <a class="text-decoration-none category-link" href="{{ route('shop.show', ['shop' => $category->id]) }}">
                        <div class="cat-item d-flex flex-column align-items-center mb-4">
                            <div class="category-image-container">
                                <img class="img-fluid category-image" src="{{ asset($category->image) }}"
                                    alt="{{ $category->category_name }}">
                            </div>
                            <h6 class="category-name mt-2">{{ $category->category_name }}</h6>
                        </div>
                    </a>
                </div>
            @endforeach
        </div> --}}
    </div>
    <!-- Categories End -->
@endsection
