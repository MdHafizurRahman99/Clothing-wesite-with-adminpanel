@extends('layouts.admin.master')

@section('title')
    Manage Sleeve Configurations
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn {
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid form-container">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                There is invalid information in Form Data
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- @if (Auth::user()->can('sleeve-configs.create')) --}}
            <h2>Manage Sleeve Configurations</h2>
            <form id="sleeveConfigForm" method="POST" action="{{ route('sleeve-configs.store') }}">
                @csrf
                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select class="form-control" id="product_id" name="product_id" required>
                        <option value="" disabled selected>Select a product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="left_image_left">Left Image Left</label>
                    <input type="number" step="any" class="form-control" id="left_image_left" name="left_image_left" value="{{ old('left_image_left') }}" required>
                    @error('left_image_left')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="left_image_rotate">Left Image Rotate</label>
                    <input type="number" step="any" class="form-control" id="left_image_rotate" name="left_image_rotate" value="{{ old('left_image_rotate') }}" required>
                    @error('left_image_rotate')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sleeve_top">Sleeve Top</label>
                    <input type="number" step="any" class="form-control" id="sleeve_top" name="sleeve_top" value="{{ old('sleeve_top') }}" required>
                    @error('sleeve_top')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="left_image_right">Left Image Right</label>
                    <input type="number" step="any" class="form-control" id="left_image_right" name="left_image_right" value="{{ old('left_image_right') }}" required>
                    @error('left_image_right')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="left_image_right_rotate">Left Image Right Rotate</label>
                    <input type="number" step="any" class="form-control" id="left_image_right_rotate" name="left_image_right_rotate" value="{{ old('left_image_right_rotate') }}" required>
                    @error('left_image_right_rotate')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="right_image_left">Right Image Left</label>
                    <input type="number" step="any" class="form-control" id="right_image_left" name="right_image_left" value="{{ old('right_image_left') }}" required>
                    @error('right_image_left')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="right_image_rotate">Right Image Rotate</label>
                    <input type="number" step="any" class="form-control" id="right_image_rotate" name="right_image_rotate" value="{{ old('right_image_rotate') }}" required>
                    @error('right_image_rotate')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="right_image_right">Right Image Right</label>
                    <input type="number" step="any" class="form-control" id="right_image_right" name="right_image_right" value="{{ old('right_image_right') }}" required>
                    @error('right_image_right')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="right_image_right_rotate">Right Image Right Rotate</label>
                    <input type="number" step="any" class="form-control" id="right_image_right_rotate" name="right_image_right_rotate" value="{{ old('right_image_right_rotate') }}" required>
                    @error('right_image_right_rotate')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" id="resetForm">Reset</button>
            </form>
        {{-- @endif --}}

        <h3 class="mt-5">Existing Configurations</h3>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Sleeve Configurations List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Left Image Left</th>
                                <th>Left Image Rotate</th>
                                <th>Sleeve Top</th>
                                <th>Left Image Right</th>
                                <th>Left Image Right Rotate</th>
                                <th>Right Image Left</th>
                                <th>Right Image Rotate</th>
                                <th>Right Image Right</th>
                                <th>Right Image Right Rotate</th>
                                @if (Auth::user()->can('sleeve-configs.edit') || Auth::user()->can('sleeve-configs.delete'))
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="configTable">
                            @foreach ($configs as $config)
                                <tr>
                                    <td>{{ $config->product->display_name }}</td>
                                    <td>{{ $config->left_image_left }}</td>
                                    <td>{{ $config->left_image_rotate }}</td>
                                    <td>{{ $config->sleeve_top }}</td>
                                    <td>{{ $config->left_image_right }}</td>
                                    <td>{{ $config->left_image_right_rotate }}</td>
                                    <td>{{ $config->right_image_left }}</td>
                                    <td>{{ $config->right_image_rotate }}</td>
                                    <td>{{ $config->right_image_right }}</td>
                                    <td>{{ $config->right_image_right_rotate }}</td>
                                    @if (Auth::user()->can('sleeve-configs.edit') || Auth::user()->can('sleeve-configs.delete'))
                                        <td>
                                            @if (Auth::user()->can('sleeve-configs.edit'))
                                                <button class="btn btn-sm btn-warning edit-config" data-id="{{ $config->id }}">Edit</button>
                                            @endif
                                            @if (Auth::user()->can('sleeve-configs.delete'))
                                                <button class="btn btn-sm btn-danger delete-config" data-id="{{ $config->id }}">Delete</button>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Check if DataTable is already initialized and destroy it if necessary
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }

            // Initialize DataTable
            $('#dataTable').DataTable({
                responsive: true,
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, targets: -1 } // Disable sorting on Actions column
                ],
                destroy: true // Allow reinitialization
            });

            // Edit configuration
            $('.edit-config').click(function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/api/sleeve-configs/${id}`,
                    method: 'GET',
                    success: function(data) {
                        $('#product_id').val(data.product_id);
                        $('#left_image_left').val(data.left_image_left);
                        $('#left_image_rotate').val(data.left_image_rotate);
                        $('#sleeve_top').val(data.sleeve_top);
                        $('#left_image_right').val(data.left_image_right);
                        $('#left_image_right_rotate').val(data.left_image_right_rotate);
                        $('#right_image_left').val(data.right_image_left);
                        $('#right_image_rotate').val(data.right_image_rotate);
                        $('#right_image_right').val(data.right_image_right);
                        $('#right_image_right_rotate').val(data.right_image_right_rotate);
                        $('#sleeveConfigForm').attr('action', `/api/sleeve-configs/${id}`);
                        $('#sleeveConfigForm').find('input[name="_method"]').remove();
                        $('#sleeveConfigForm').append('<input type="hidden" name="_method" value="PUT">');
                    },
                    error: function(xhr) {
                        alert('Error loading configuration');
                    }
                });
            });

            // Delete configuration
            $('.delete-config').click(function() {
                if (confirm('Are you sure you want to delete this configuration?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/api/sleeve-configs/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function() {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Error deleting configuration');
                        }
                    });
                }
            });

            // Reset form
            $('#resetForm').click(function() {
                $('#sleeveConfigForm')[0].reset();
                $('#sleeveConfigForm').attr('action', '{{ route("sleeve-configs.store") }}');
                $('#sleeveConfigForm').find('input[name="_method"]').remove();
            });

            // Clear form after successful submission
            $('#sleeveConfigForm').on('submit', function(e) {
                if ($(this).valid()) {
                    setTimeout(() => {
                        $('#sleeveConfigForm')[0].reset();
                        $('#sleeveConfigForm').attr('action', '{{ route("sleeve-configs.store") }}');
                        $('#sleeveConfigForm').find('input[name="_method"]').remove();
                    }, 1000);
                }
            });
        });
    </script>
@endsection
