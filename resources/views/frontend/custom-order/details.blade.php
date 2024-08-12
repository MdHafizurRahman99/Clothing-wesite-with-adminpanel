@extends('layouts.frontend.master')

@section('content')
    <div class="container">
        <h1>Custom Order Details</h1>
        <a href="{{ route('custom-order.index') }}" class="btn btn-primary mb-3">Back to List</a>
        <table class="table table-bordered">
            {{-- <tr>
                <th>ID</th>
                <td>{{ $order->id }}</td>
            </tr> --}}
            <tr>
                <th>Target</th>
                <td>{{ $order->target }}</td>
            </tr>
            <tr>
                <th>Category</th>
                <td>{{ $order->category }}</td>
            </tr>
            <tr>
                <th>Subcategory</th>
                <td>{{ $order->subcategory }}</td>
            </tr>
            <tr>
                <th>Looking For</th>
                <td>{{ implode(', ', json_decode($order->looking_for)) }}</td>
            </tr>
            <tr>
                <th>Additional Services</th>
                <td>{{ implode(', ', json_decode($order->additional_services)) }}</td>
            </tr>
            <tr>
                <th>Inspiration Images</th>
                <td>
                    {{-- @dd($images) --}}
                    @foreach($images as $image)
                        <img src="{{ asset( $image->image_url) }}" alt="Inspiration Image" width="100">
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Number of Products</th>
                <td>{{ $order->number_of_products }}</td>
            </tr>
            <tr>
                <th>Quantity per Product</th>
                <td>{{ $order->quantity_per_model }}</td>
            </tr>
            <tr>
                <th>Project Budget</th>
                <td>{{ $order->project_budget }}</td>
            </tr>
            <tr>
                <th>Sample Delivery Date</th>
                <td>{{ $order->sample_delivery_date }}</td>
            </tr>
            <tr>
                <th>Production Delivery Date</th>
                <td>{{ $order->production_delivery_date }}</td>
            </tr>
            <tr>
                <th>Project Description</th>
                <td>{{ $order->project_description }}</td>
            </tr>
        </table>
    </div>
@endsection

{{-- @section('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(to right, #0d6efd, #6c757d);
        }
    </style>
@endsection --}}

@section('js')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
