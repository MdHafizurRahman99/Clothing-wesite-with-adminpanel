<!DOCTYPE html>
<html>

<head>
    <title>Manage Sleeve Configurations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
</head>

<body>
    <div class="container form-container">
        <h2>Manage Sleeve Configurations</h2>
        <form id="sleeveConfigForm" method="POST" action="{{ route('sleeve-configs.store') }}">
            @csrf
            <div class="form-group">
                <label for="product_id">Product</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} ({{ strtolower($product->id) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="left_image_left">Left Image Left</label>
                <input type="number" step="any" class="form-control" id="left_image_left" name="left_image_left"
                    required>
            </div>
            <div class="form-group">
                <label for="left_image_rotate">Left Image Rotate</label>
                <input type="number" step="any" class="form-control" id="left_image_rotate"
                    name="left_image_rotate" required>
            </div>
            <div class="form-group">
                <label for="sleeve_top">Sleeve Top</label>
                <input type="number" step="any" class="form-control" id="sleeve_top" name="sleeve_top" required>
            </div>
            <div class="form-group">
                <label for="left_image_right">Left Image Right</label>
                <input type="number" step="any" class="form-control" id="left_image_right" name="left_image_right"
                    required>
            </div>
            <div class="form-group">
                <label for="left_image_right_rotate">Left Image Right Rotate</label>
                <input type="number" step="any" class="form-control" id="left_image_right_rotate"
                    name="left_image_right_rotate" required>
            </div>
            <div class="form-group">
                <label for="right_image_left">Right Image Left</label>
                <input type="number" step="any" class="form-control" id="right_image_left" name="right_image_left"
                    required>
            </div>
            <div class="form-group">
                <label for="right_image_rotate">Right Image Rotate</label>
                <input type="number" step="any" class="form-control" id="right_image_rotate"
                    name="right_image_rotate" required>
            </div>
            <div class="form-group">
                <label for="right_image_right">Right Image Right</label>
                <input type="number" step="any" class="form-control" id="right_image_right"
                    name="right_image_right" required>
            </div>
            <div class="form-group">
                <label for="right_image_right_rotate">Right Image Right Rotate</label>
                <input type="number" step="any" class="form-control" id="right_image_right_rotate"
                    name="right_image_right_rotate" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <h3 class="mt-5">Existing Configurations</h3>
        <table class="table table-striped">
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="configTable">
                @foreach ($configs as $config)
                    <tr>
                        <td>{{ $config->product->name }}</td>
                        <td>{{ $config->left_image_left }}</td>
                        <td>{{ $config->left_image_rotate }}</td>
                        <td>{{ $config->sleeve_top }}</td>
                        <td>{{ $config->left_image_right }}</td>
                        <td>{{ $config->left_image_right_rotate }}</td>
                        <td>{{ $config->right_image_left }}</td>
                        <td>{{ $config->right_image_rotate }}</td>
                        <td>{{ $config->right_image_right }}</td>
                        <td>{{ $config->right_image_right_rotate }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-config"
                                data-id="{{ $config->id }}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-config"
                                data-id="{{ $config->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
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
                        $('#sleeveConfigForm').append(
                            '<input type="hidden" name="_method" value="PUT">');
                    },
                    error: function(xhr) {
                        alert('Error loading configuration');
                    }
                });
            });

            $('.delete-config').click(function() {
                if (confirm('Are you sure you want to delete this configuration?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/api/sleeve-configs/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
        });
    </script>
</body>

</html>
