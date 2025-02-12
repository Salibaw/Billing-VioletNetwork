@include('header')
@include('nav')

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@php
$userId = Auth::id();
    $categories = \App\Models\Category::where('user_id', $userId)->get();
    $products = \App\Models\Product::where('user_id', $userId)->get();
@endphp

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Product Form <span>| Add your products</span></h5>
                <!-- product Form for entering details of product-->
                <form class="row g-3" action="{{ route('storeProduct') }}" method="POST">
                    @csrf
                    <div class="col-12">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control @error('productName') is-invalid @enderror"
                            id="productName" name="productName" value="{{ old('productName') }}">
                        @error('productName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="productId" class="form-label">Product ID</label>
                        <input type="number" class="form-control @error('productId') is-invalid @enderror"
                            id="productId" name="productId" value="{{ old('productId') }}">
                        @error('productId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="productCost" class="form-label">Product Cost</label>
                        <input type="number" class="form-control @error('productCost') is-invalid @enderror"
                            id="productCost" name="productCost" value="{{ old('productCost') }}">
                        @error('productCost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="productCategory" class="form-label">Product Category</label>
                        <select class="form-select @error('productCategory') is-invalid @enderror" id="productCategory"
                            name="productCategory">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option class="text-capitalize" value="{{ $category->id }}"
                                    {{ old('productCategory') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('productCategory')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Category Form <span>| Add your categories</span></h5>
                <div class="col-12">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addCatModal">Add New Category</button>
                    @include('addCat')
                </div>
                <br>
                <ul class="text-capitalize">
                    @foreach ($categories as $category)
                        <li>
                            <button class="btn btn-outline-danger btn-sm ri-delete-bin-5-line"
                                onclick="deleteCategory({{ $category->id }})"></button>
                            <button class="btn btn-outline-primary btn-sm ri-edit-2-line"
                                onclick="editCategory({{ $category->id }}, '{{ $category->name }}')"></button>
                            &nbsp;<strong>{{ $category->name }}</strong>
                        </li>
                    @endforeach
                </ul>
                <h5 class="card-title">Products</h5>
                <ul class="text-capitalize">
                    @foreach ($products as $product)
                        <li>
                            <button class="btn btn-outline-danger btn-sm ri-delete-bin-5-line"
                                onclick="deleteProduct({{ $product->id }})"></button>
                            <button class="btn btn-outline-primary btn-sm ri-edit-2-line"
                                onclick="editProduct({{ $product->id }})"></button>
                            &nbsp;<strong>{{ $product->name }}</strong>-({{ $product->code }})
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


    {{-- modal --}}
    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCatModal" tabindex="-1" aria-labelledby="editCatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCatModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <input type="hidden" id="editCatId">
                        <div class="mb-3">
                            <label for="editCatName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editCatName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProdModal" tabindex="-1" aria-labelledby="editProdModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProdModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="editProdId">
                        <div class="mb-3">
                            <label for="editProdName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProdName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProdCategory" class="form-label">Category</label>
                            <select id="editProdCategory" class="form-control" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="editProdCode" class="form-label">Product Code</label>
                            <input type="text" class="form-control" id="editProdCode" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProdCost" class="form-label">Production Cost</label>
                            <input type="number" class="form-control" id="editProdCost" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteCategory(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
            // Get the CSRF token value
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Include the CSRF token in your AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            // Perform AJAX request to delete the category
            $.ajax({
                url: '/delete-category/' + categoryId,
                method: 'DELETE',
                success: function(response) {
                    // Reload the page or update the UI as needed
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('An error occurred while deleting the category.');
                }
            });
        }
    }

    function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            // Perform AJAX request to delete the product
            // Get the CSRF token value
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Include the CSRF token in your AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $.ajax({
                url: '/delete-product/' + productId,
                method: 'DELETE',
                success: function(response) {
                    // Reload the page or update the UI as needed
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('An error occurred while deleting the product.');
                }
            });
        }
    }

    function editCategory(id, name) {
        $('#editCatId').val(id);
        $('#editCatName').val(name);
        $('#editCatModal').modal('show');
    }

    function editProduct(id) {
        $.ajax({
            url: '/singleProduct/' + id,
            method: 'GET',
            success: function(response) {
                console.log(response); // Debug: check the response object

                const product = response.product;
                const categories = response.categories;

                $('#editProdId').val(product.id);
                $('#editProdName').val(product.name);
                $('#editProdCode').val(product.code);
                $('#editProdCost').val(product.cost);

                const categorySelect = $('#editProdCategory');
                categorySelect.empty();
                if (categories) {
                    categories.forEach(category => {
                        const selected = category.id === product.category_id ? 'selected' : '';
                        categorySelect.append(
                            `<option value="${category.id}" ${selected}>${category.name}</option>`
                        );
                    });
                }

                $('#editProdModal').modal('show');
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }




    $('#editCategoryForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editCatId').val();
        const name = $('#editCatName').val();
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // Include the CSRF token in your AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $.ajax({
            url: '/categories/' + id,
            method: 'PUT',
            data: {
                name: name
            },
            success: function(response) {
                location.reload(); // Reload the page to see the changes
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    });

    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editProdId').val();
        const name = $('#editProdName').val();
        const category = $('#editProdCategory').val();
        const code = $('#editProdCode').val();
        const cost = $('#editProdCost').val();
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // Include the CSRF token in your AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $.ajax({
            url: '/singleProduct/' + id,
            method: 'PUT',
            data: {
                name: name,
                category: category,
                code: code,
                cost: cost
            },
            success: function(response) {
                location.reload(); // Reload the page to see the changes
            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    });
</script>

@include('footer')
