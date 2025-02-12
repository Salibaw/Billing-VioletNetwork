@php
    $userId = Auth::id();
    $products = \App\Models\Product::where('user_id', $userId)->get();
@endphp

<div class="modal fade" id="addBillModal" tabindex="-1" aria-labelledby="addBillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBillModalLabel">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <!-- Product Form for entering bill of product-->
                    <form id="addBillForm" class="row g-3">
                        @csrf
                        <div class="col-md-6 ms-auto">
                            <label for="customerPhone" class="form-label">Customer Phone</label>
                            <input type="number" class="form-control" id="customerPhone" name="customerPhone">
                        </div>
                        <div class="col-md-6 ">
                            <label for="productName" class="form-label">Product Name</label>
                            <select class="form-select @error('productName') is-invalid @enderror" id="productName" name="productName">
                                <option value="">Select Name</option>
                                @foreach ($products as $product)
                                    <option class="text-capitalize" value="{{ $product->id }}"
                                        {{ old('productName') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="productNameError" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 ms-auto">
                            <label for="productId" class="form-label">Product Code</label>
                            <input type="number" class="form-control" id="productId" name="productId">
                        </div>
                        <div class="col-md-6 ">
                            <label for="productCat" class="form-label">Category</label>
                            <select class="form-select" id="productCat" name="productCat">
                                <option value="">Select Category</option>
                                <option value="wholesales">Wholesales</option>
                                <option value="retail">Retail</option>
                                <option value="discount">Discount</option>
                            </select>
                            <div id="productCatError" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 ms-auto">
                            <label for="productMrp" class="form-label">Product MRP</label>
                            <input type="number" class="form-control" id="productMrp" name="productMrp">
                            <div id="productCostError" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 ">
                            <label for="productQuantity" class="form-label">Product Quantity</label>
                            <input type="number" class="form-control" id="productQuantity" name="productQuantity">
                            <div id="productQuantityError" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 ms-auto">
                            <label for="total" class="form-label">Total</label>
                            <input type="text" class="form-control" id="total" name="total">
                            <div id="totalError" class="invalid-feedback"></div>
                        </div>
                    </form><!-- Product Form -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="saveBillBtn" type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to calculate total amount and format as currency
        function calculateTotal() {
            var mrp = parseFloat($('#productMrp').val());
            var quantity = parseInt($('#productQuantity').val());
            var total = isNaN(mrp) || isNaN(quantity) ? 0 : mrp * quantity;

            // Format ke mata uang Rupiah
            var formattedTotal = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });

            // Menampilkan hasil dalam input atau elemen lain
            $('#total').val(formattedTotal);
        }

        // Event listener untuk input perubahan MRP dan jumlah
        $('#productMrp, #productQuantity').on('input', calculateTotal);

        // Event listener untuk perubahan nama produk
        $('#productName').change(function() {
            var product_id = $(this).val();
            $.ajax({
                url: '{{ route('getProductName') }}',
                method: 'GET',
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    $('#productId').val(response.product_id);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        // Event listener untuk tombol simpan
        $('#saveBillBtn').click(function() {
            // Reset pesan error sebelumnya
            $('.invalid-feedback').html('').removeClass('is-invalid');

            // Kirim form dengan AJAX
            $.ajax({
                url: '{{ route('storeBill') }}',
                method: 'POST',
                data: $('#addBillForm').serialize(),
                success: function(response) {
                    // Handle sukses
                    console.log(response);
                    $('#addBillModal').modal('hide');
                    location.reload(); // Reload halaman atau perbarui data secara dinamis
                },
                error: function(xhr) {
                    // Handle error validasi
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key + 'Error').html(value[0]).addClass('is-invalid');
                            $('#' + key).addClass('is-invalid');
                        });
                    } else {
                        console.log(xhr.responseText);
                    }
                }
            });
        });
    });
</script>
