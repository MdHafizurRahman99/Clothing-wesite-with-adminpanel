@extends('layouts.frontend.master')
@section('css')
    <style>
        .form {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1100px;
            margin: 20px auto;
            padding: 20px;
            background: #F9FAFB;
        }



        h1 {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            /* text-align: left; */

        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: .875rem;
        }

        .icon-group {
            display: flex;
            gap: 20px;
        }

        .icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s;
        }

        .icon:hover,
        .icon.selected {
            opacity: 1;
        }

        .icon span {
            margin-top: 5px;
            font-size: 14px;
        }

        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            color: #888;
        }

        /*
                        button {
                            background: #000000;
                            color: #fff;
                            border: none;
                            padding: 12px 20px;
                            font-size: 18px;
                            border-radius: 4px;
                            cursor: pointer;
                            transition: background 0.3s;
                        }

                        button:hover {
                            background: #000000;
                        } */

        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            color: #888;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .file-upload:hover {
            border-color: #000000;
        }

        .file-upload-text {
            color: #000000;
            text-decoration: underline;
            cursor: pointer;
        }

        #preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Reset some default styles */
        /* Reset some default styles */
        body,
        h1,
        label,
        input,
        select,
        textarea,
        button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General body styling */
        /* body {
                                            font-family: 'Arial', sans-serif;
                                            background-color: #f4f7f6;
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            min-height: 100vh;
                                            margin: 0;
                                        } */

        /* Container for the form */
        .form-container {
            width: 60%;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        /* Header style */
        h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
            /* text-align: left; */
        }

        /* Form style */
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Form group styling */
        .form-group {
            margin-bottom: 20px;
            /* width: 28rem; */
        }

        .form-input {
            width: 28rem;
        }
        .form-textarea {
            width: 100%;
        }

        /* Label styling */
        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #555;
            /* text-align: left; */
        }

        /* Input, select, textarea styling */
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus,
        input[type="file"]:focus {
            border-color: #000000;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            outline: none;
        }

        /* Icon group styling */
        .icon-group {
            display: flex;
            gap: 10px;
            width: 100%;
            /* justify-content: space-between; */
        }

        .icon {
            flex: 1;
            max-width: 100px;
            /* Ensuring uniform width */
            text-align: center;
            padding: 10px;
            background: #f4f7f6;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .icon input:checked+label {
            background: #000000;
            color: white;
            transform: scale(1.05);
        }

        .icon label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-radius: 6px;
        }

        .icon-emoji {
            font-size: 24px;
        }

        .icon-text {
            margin-top: 5px;
            font-size: 14px;
        }

        .label-width {
            width: 5rem;
        }

        .label-width-6 {
            width: 6rem;
        }

        /* Button styling */
        button {
            padding: 15px;
            background-color: #757575;
            color: rgb(255, 255, 255);
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #000000;
            transform: scale(1.02);
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }

            .icon-group {
                flex-direction: column;
            }

            .icon {
                max-width: none;
                /* Remove width constraint for better stacking */
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
        }

        .form-row .form-group {
            flex: 1;
            margin-right: 1rem;
        }

        .form-row .form-group:last-child {
            margin-right: 0;
        }
    </style>
@endsection

@section('content')
<div class="form">
    <form class="quotation-form" action="{{ route('custom-order.update', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h1>Edit Custom Order</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Target -->
        <div class="form-group form-input">
            <label>Target *</label>
            <div class="icon-group" id="target-group">
                <div class="icon">
                    <input type="radio" name="target" value="Women" id="target-women" hidden {{ old('target', $order->target) == 'Women' ? 'checked' : '' }}>
                    <label class="label-width" for="target-women">
                        <span class="icon-emoji">👤</span>
                        <span class="icon-text">Women</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="radio" name="target" value="Unisex" id="target-unisex" hidden {{ old('target', $order->target) == 'Unisex' ? 'checked' : '' }}>
                    <label class="label-width" for="target-unisex">
                        <span class="icon-emoji">👤</span>
                        <span class="icon-text">Unisex</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="radio" name="target" value="Men" id="target-men" hidden {{ old('target', $order->target) == 'Men' ? 'checked' : '' }}>
                    <label class="label-width" for="target-men">
                        <span class="icon-emoji">👤</span>
                        <span class="icon-text">Men</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="radio" name="target" value="Kids" id="target-kids" hidden {{ old('target', $order->target) == 'Kids' ? 'checked' : '' }}>
                    <label class="label-width" for="target-kids">
                        <span class="icon-emoji">👤</span>
                        <span class="icon-text">Kids</span>
                    </label>
                </div>
            </div>
            @error('target') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Category -->
        <div class="form-group form-input">
            <label>Category *</label>
            <div class="icon-group" id="category-group">
                <div class="icon">
                    <input type="radio" name="category" value="Clothes" id="category-clothes" hidden {{ old('category', $order->category) == 'Clothes' ? 'checked' : '' }}>
                    <label class="label-width-6" for="category-clothes">
                        <span class="icon-emoji">👕</span>
                        <span class="icon-text">Clothes</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="radio" name="category" value="Accessories" id="category-accessories" hidden {{ old('category', $order->category) == 'Accessories' ? 'checked' : '' }}>
                    <label class="label-width-6" for="category-accessories">
                        <span class="icon-emoji">👓</span>
                        <span class="icon-text">Accessories</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="radio" name="category" value="Outerwear" id="category-outerwear" hidden {{ old('category', $order->category) == 'Outerwear' ? 'checked' : '' }}>
                    <label class="label-width-6" for="category-outerwear">
                        <span class="icon-emoji">🧥</span>
                        <span class="icon-text">Outerwear</span>
                    </label>
                </div>
            </div>
            @error('category') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Subcategory -->
        <div class="form-group form-input">
            <label for="subcategory">Subcategory *</label>
            <select id="subcategory" name="subcategory" required>
                <option value="">Select subcategory</option>
                <option value="shirts" {{ old('subcategory', $order->subcategory) == 'shirts' ? 'selected' : '' }}>Shirts</option>
                <option value="pants" {{ old('subcategory', $order->subcategory) == 'pants' ? 'selected' : '' }}>Pants</option>
            </select>
            @error('subcategory') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Looking for -->
        <div class="form-group form-input">
            <label>What are you looking for? *</label>
            <div class="icon-group">
                <div class="icon">
                    <input type="checkbox" name="looking_for[]" value="Only Prototypes & Samples" id="production-prototype" hidden {{ is_array(old('looking_for', $order->looking_for)) && in_array('Only Prototypes & Samples', old('looking_for', $order->looking_for)) ? 'checked' : '' }}>
                    <label for="production-prototype">
                        <span class="icon-emoji">📋</span>
                        <span class="icon-text">Only Prototypes & Samples</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="checkbox" name="looking_for[]" value="Production Bulk" id="production-bulk" hidden {{ is_array(old('looking_for', $order->looking_for)) && in_array('Production Bulk', old('looking_for', $order->looking_for)) ? 'checked' : '' }}>
                    <label for="production-bulk">
                        <span class="icon-emoji">📋</span>
                        <span class="icon-text">Production Bulk</span>
                    </label>
                </div>
            </div>
            @error('looking_for') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Additional Services -->
        <div class="form-group form-input">
            <label>Are you looking for additional services?</label>
            <div class="icon-group">
                <div class="icon">
                    <input type="checkbox" name="additional_services[]" value="Design & Tech Pack" id="production-design" hidden {{ is_array(old('additional_services', $order->additional_services)) && in_array('Design & Tech Pack', old('additional_services', $order->additional_services)) ? 'checked' : '' }}>
                    <label class="label-width-6" for="production-design">
                        <span class="icon-emoji">📐</span>
                        <span class="icon-text">Design & Tech Pack</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="checkbox" name="additional_services[]" value="Raw material sourcing" id="production-material" hidden {{ is_array(old('additional_services', $order->additional_services)) && in_array('Raw material sourcing', old('additional_services', $order->additional_services)) ? 'checked' : '' }}>
                    <label class="label-width-6" for="production-material">
                        <span class="icon-emoji">🧵</span>
                        <span class="icon-text">Raw material sourcing</span>
                    </label>
                </div>
            </div>
            @error('additional_services') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Inspiration Images -->
        <div class="form-group form-input">
            <label for="inspiration-images">Upload inspiration images of your product *</label>
            <div class="file-upload" id="file-upload">
                <input type="file" id="inspiration-images" name="inspiration_images[]" multiple accept="image/*" style="display: none;">
                <p>Drag and drop some files here, or <span class="file-upload-text">click to select files</span></p>
                <div id="preview-container">
                    @foreach($images as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Inspiration image" width="100">
                    @endforeach
                </div>
            </div>
            @error('inspiration_images') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Number of Products -->
        <div class="form-row">
            <div class="form-group form-input">
                <label for="products">Number of products *</label>
                <input type="number" id="products" name="number_of_products" class="form-control" value="{{ old('number_of_products', $order->number_of_products) }}" required>
            </div>
            @error('number_of_products') <p class="text-danger">{{ $message }}</p> @enderror

            <!-- Quantity per product -->
            <div class="form-group form-input">
                <label for="quantity">Quantity per product *</label>
                <input type="number" id="quantity" name="quantity_per_model" class="form-control" value="{{ old('quantity_per_model', $order->quantity_per_model) }}" required>
            </div>
            @error('quantity_per_model') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Budget -->
        <div class="form-group form-input">
            <label for="budget">Project budget *</label>
            <select id="budget" name="project_budget" class="form-control" required>
                <option value="">Select a production budget</option>
                <option value="1000-5000" {{ old('project_budget', $order->project_budget) == '1000-5000' ? 'selected' : '' }}>$1,000 - $5,000</option>
                <option value="5000-10000" {{ old('project_budget', $order->project_budget) == '5000-10000' ? 'selected' : '' }}>$5,000 - $10,000</option>
            </select>
            @error('project_budget') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Sample and Production Delivery Dates -->
        <div class="form-row">
            <div class="form-group form-input">
                <label for="sample-date">Sample Delivery dates *</label>
                <select id="sample-date" name="sample_delivery_date" class="form-control" required>
                    <option value="">Select range for sample</option>
                    <option value="2-4weeks" {{ old('sample_delivery_date', $order->sample_delivery_date) == '2-4weeks' ? 'selected' : '' }}>2-4 weeks</option>
                    <option value="4-6weeks" {{ old('sample_delivery_date', $order->sample_delivery_date) == '4-6weeks' ? 'selected' : '' }}>4-6 weeks</option>
                </select>
                @error('sample_delivery_date') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="form-group form-input">
                <label for="production-date">Production Delivery dates *</label>
                <select id="production-date" name="production_delivery_date" class="form-control" required>
                    <option value="">Select range for production</option>
                    <option value="4-6weeks" {{ old('production_delivery_date', $order->production_delivery_date) == '4-6weeks' ? 'selected' : '' }}>4-6 weeks</option>
                    <option value="6-8weeks" {{ old('production_delivery_date', $order->production_delivery_date) == '6-8weeks' ? 'selected' : '' }}>6-8 weeks</option>
                </select>
                @error('production_delivery_date') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Project Description -->
        <div class="form-group form-textarea">
            <label for="project-description">Tell us more about you, your project, and your particular support needs *</label>
            <textarea id="project-description" name="project_description" class="form-control" rows="4" required>{{ old('project_description', $order->project_description) }}</textarea>
            @error('project_description') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <button type="submit">Update Request</button>
    </form>
</div>

    {{-- <form class="quotation-form" action="{{ route('custom-order.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <h1>Request for Custom Order</h1>



        <div class="form-group">
            <label>Target *</label>
            <div class="icon-group" id="target-group">
                <div class="icon">
                    <input type="radio" name="target" value="Women" id="target-women" hidden>
                    <label class="label-width" for="target-women">
                        <span class="icon-emoji">👤</span>
                        <span class="icon-text">Women</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="radio" name="target" value="Unisex" id="target-unisex" hidden checked>
                    <label class="label-width" for="target-unisex">
                        <span class="icon-emoji">👤</span>
                        <span class="icon-text">Unisex</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="radio" name="target" value="Men" id="target-men" hidden>
                    <label class="label-width" for="target-men">
                        <span class="icon-emoji">👤</span>
                        <span class="icon-text">Men</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="radio" name="target" value="Kids" id="target-kids" hidden>
                    <label class="label-width" for="target-kids">
                        <span class="icon-emoji">👤</span>
                        <span class="icon-text">Kids</span>
                    </label>
                </div>
            </div>
            @error('target')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>Category *</label>
            <div class="icon-group" id="category-group">
                <div class="icon">
                    <input type="radio" name="category" value="Clothes" id="category-clothes" hidden checked>
                    <label class="label-width-6" for="category-clothes">
                        <span class="icon-emoji">👕</span>
                        <span class="icon-text">Clothes</span>
                    </label>
                </div>

                <div class="icon">
                    <input type="radio" name="category" value="Accessories" id="category-accessories" hidden>
                    <label class="label-width-6" for="category-accessories">
                        <span class="icon-emoji">👓</span>
                        <span class="icon-text">Accessories</span>
                    </label>
                </div>

                <div class="icon">
                    <input type="radio" name="category" value="Outerwear" id="category-outerwear" hidden>
                    <label class="label-width-6" for="category-outerwear">
                        <span class="icon-emoji">🧥</span>
                        <span class="icon-text">Outerwear</span>
                    </label>
                </div>
            </div>
            @error('category')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="subcategory">Subcategory *</label>
            <select id="subcategory" name="subcategory" required>
                <option value="">Select subcategory</option>
                <option value="shirts">Shirts</option>
                <option value="pants">Pants</option>
            </select>
            @error('subcategory')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>What are you looking for? *</label>
            <div class="icon-group">
                <div class="icon">
                    <input type="checkbox" name="looking_for[]" value="Only Prototypes & Samples"
                        id="production-prototype" hidden>
                    <label for="production-prototype">
                        <span class="icon-emoji">📋</span>
                        <span class="icon-text"> Only Prototypes & Samples</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="checkbox" name="looking_for[]" value="Production Bulk" id="production-bulk" hidden>
                    <label for="production-bulk">
                        <span class="icon-emoji">📋</span>
                        <span class="icon-text"> Production Bulk</span>
                    </label>
                </div>
            </div>
            @error('looking_for')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>Are you looking for additional services?</label>
            <div class="icon-group">
                <div class="icon">
                    <input type="checkbox" name="additional_services[]" value="Design & Tech Pack"
                        id="production-design" hidden>
                    <label class="label-width-6" for="production-design">
                        <span class="icon-emoji">📐</span>
                        <span class="icon-text"> Design & Tech Pack</span>
                    </label>
                </div>
                <div class="icon">
                    <input type="checkbox"name="additional_services[]" value="Raw material sourcing"
                        id="production-material" hidden>
                    <label class="label-width-6" for="production-material">
                        <span class="icon-emoji">🧵</span>
                        <span class="icon-text"> Raw material sourcing</span>
                    </label>
                </div>
            </div>
            @error('additional_services')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="inspiration-images">Upload inspiration images of your product *</label>
            <div class="file-upload" id="file-upload">
                <input type="file" id="inspiration-images" name="inspiration_images[]" multiple accept="image/*"
                    style="display: none;">
                <p>Drag and drop some files here, or <span class="file-upload-text">click to select files</span></p>
                <div id="preview-container"></div>
            </div>
            @error('inspiration_images')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="products">Number of products *</label>
                <input type="number" id="products" name="number_of_products" class="form-control" required>
            </div>
            @error('number_of_products')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="form-group">
                <label for="quantity">Quantity per product *</label>
                <input type="number" id="quantity" name="quantity_per_product" class="form-control" required>
            </div>
            @error('quantity_per_product')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="budget">Project budget *</label>
            <select id="budget" name="project_budget" class="form-control" required>
                <option value="">Select a production budget</option>
                <option value="1000-5000">$1,000 - $5,000</option>
                <option value="5000-10000">$5,000 - $10,000</option>
            </select>
            @error('project_budget')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="sample-date">Sample Delivery dates *</label>
                <select id="sample-date" name="sample_delivery_date" class="form-control" required>
                    <option value="">Select range for sample</option>
                    <option value="2-4weeks">2-4 weeks</option>
                    <option value="4-6weeks">4-6 weeks</option>
                </select>
                @error('sample_delivery_date')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="production-date">Production Delivery dates *</label>
                <select id="production-date" name="production_delivery_date" class="form-control" required>
                    <option value="">Select range for production</option>
                    <option value="4-6weeks">4-6 weeks</option>
                    <option value="6-8weeks">6-8 weeks</option>
                </select>
                @error('production_delivery_date')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="project-description">Tell us more about you, your project, and your particular support needs
                *</label>
            <textarea id="project-description" name="project_description" class="form-control" rows="4" required></textarea>
            @error('project_description')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit">Submit Request</button>
    </form> --}}
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileUpload = document.getElementById('file-upload');
            const fileInput = document.getElementById('inspiration-images');
            const previewContainer = document.getElementById('preview-container');

            fileUpload.addEventListener('click', () => {
                fileInput.click();
            });

            fileUpload.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUpload.style.borderColor = '#007bff';
            });

            fileUpload.addEventListener('dragleave', () => {
                fileUpload.style.borderColor = '#ddd';
            });

            fileUpload.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUpload.style.borderColor = '#ddd';
                handleFiles(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', () => {
                handleFiles(fileInput.files);
            });

            function handleFiles(files) {
                previewContainer.innerHTML = '';
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('preview-image');
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        console.warn('Skipping non-image file:', file.name);
                    }
                });
            }
        });


        document.querySelectorAll('#target-group .icon input').forEach((input) => {
            input.addEventListener('change', () => {
                document.querySelectorAll('#target-group .icon label').forEach((label) => {
                    label.style.background = '#f4f7f6';
                    label.style.color = 'black';
                    label.style.transform = 'scale(1)';
                });

                if (input.checked) {
                    input.nextElementSibling.style.background = '#000000';
                    input.nextElementSibling.style.color = 'white';
                    input.nextElementSibling.style.transform = 'scale(1.05)';
                }
            });
        });

        document.querySelectorAll('#category-group .icon input').forEach((input) => {
            input.addEventListener('change', () => {
                document.querySelectorAll('#category-group .icon label').forEach((label) => {
                    label.style.background = '#f4f7f6';
                    label.style.color = 'black';
                    label.style.transform = 'scale(1)';
                });

                if (input.checked) {
                    input.nextElementSibling.style.background = '#000000';
                    input.nextElementSibling.style.color = 'white';
                    input.nextElementSibling.style.transform = 'scale(1.05)';
                }
            });
        });
    </script>
@endsection
