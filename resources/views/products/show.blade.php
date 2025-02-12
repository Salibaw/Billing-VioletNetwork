@include('header')
@include('nav')

@php
    $userId = Auth::id();
    $products = \App\Models\Product::where('user_id', $userId)->get();
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title text-center">Sales Report</h5>
                    <div class="filter text-center">
                        <label for="product-select">Select Product:</label>
                        <select id="product-select" class="form-control mb-3">
                            <option value="">Select a product</option>
                            @foreach ($products as $product)
                                <option class="product-link" data-id="{{ $product->id }}" value="{{ $product->id }}">
                                    {{ $product->name }}</option>
                            @endforeach
                        </select>
                        <div class="date-filters row">
                            <div class="col-md-6">
                                <label for="fromDate">From Date:</label>
                                <input type="date" class="form-control" id="fromDate">
                            </div>
                            <div class="col-md-6">
                                <label for="toDate">To Date:</label>
                                <input type="date" class="form-control" id="toDate">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .filter label {
        display: block;
        margin-bottom: 0.5rem;
    }

    .filter .form-control {
        width: 100%;
    }

    .date-filters .col-md-6 {
        margin-bottom: 1rem;
        /* Optional: adds space between rows on smaller screens */
    }
</style>

<div class="col-12" id="product-details">
    <div class="card recent-sales overflow-auto">
        <div class="card-body" style="display: none;">
            <h5 class="card-title">Product Details</h5>
            <div id="product-info"></div>
            <button id="back-button" class="btn btn-primary">Back</button>
            <hr>
            <!-- Sales Sections (Discount, Retail, Wholesale) -->
            <h5 class="card-title">Discount Sales</h5>
            <div class="row">
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Quantity <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart" id="discount-total-quantity"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">P & L <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="discount-total-profit"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="discount-total-amount"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Retail Sales -->
            <h5 class="card-title">Retail Sales</h5>
            <div class="row">
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Quantity <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart" id="retail-total-quantity"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">P & L <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="retail-total-profit"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="retail-total-amount"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Wholesale Sales -->
            <h5 class="card-title">Wholesale Sales</h5>
            <div class="row">
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Quantity <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart" id="wholesale-total-quantity"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">P & L <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="wholesale-total-profit"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee" id="wholesale-total-amount"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button id="download-pdf" class="btn btn-primary me-2">Download PDF</button>
                <button id="download-excel" class="btn btn-success">Download Excel</button>
            </div>
        </div>
    </div>
</div>

@include('footer')

<!-- Include jQuery (if not already included) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include jsPDF and SheetJS libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        // Hide product details section initially
        $('#product-details .card-body').hide();

        function fetchProductDetails(productId, fromDate = '', toDate = '') {
            $.ajax({
                url: '/products/' + productId,
                method: 'GET',
                success: function(response) {
                    // Display the product details
                    $('#product-info').html(`
                            <h1>${response.product.name}</h1>
                            <p>Category: ${response.product.category.name}</p>
                            <p>Product Code: ${response.product.code}</p>
                            <p>Production Cost: ${response.product.cost}</p>
                            <p>Date Range: ${fromDate} to ${toDate}</p>
                        `);
                    // Fetch sales categories
                    fetchSalesCategories(productId, response.product.cost, fromDate, toDate);
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        function fetchSalesCategories(productId, productCost, fromDate, toDate) {
            $.ajax({
                url: '/sales/product/' + productId,
                method: 'GET',
                data: {
                    fromDate: fromDate,
                    toDate: toDate
                },
                success: function(response) {
                    // Calculate sales data
                    calculateSalesData(response.discountSales, '#discount-total-quantity',
                        '#discount-total-amount', '#discount-total-profit', productCost);
                    calculateSalesData(response.retailSales, '#retail-total-quantity',
                        '#retail-total-amount', '#retail-total-profit', productCost);
                    calculateSalesData(response.wholesaleSales, '#wholesale-total-quantity',
                        '#wholesale-total-amount', '#wholesale-total-profit', productCost);
                    // Show product details section
                    $('#product-details .card-body').show();
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        function calculateSalesData(sales, quantitySelector, amountSelector, profitSelector, productCost) {
            let totalQuantity = 0;
            let totalAmount = 0;
            let totalProfit = 0;
            $.each(sales, function(index, sale) {
                const quantity = sale.productQuantity;
                const mrp = sale.productMrp;
                totalQuantity += quantity;
                totalAmount += quantity * mrp;
                totalProfit += (quantity * mrp) - (quantity * productCost);
            });
            // Update the UI with the calculated data
            $(quantitySelector).text(totalQuantity);
            $(amountSelector).text(totalAmount);
            $(profitSelector).text(totalProfit);
        }

        $('#product-select').change(function() {
            const productId = $(this).val();
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            if (productId) {
                fetchProductDetails(productId, fromDate, toDate);
            }
        });

        $('#fromDate, #toDate').on('change', function() {
            const productId = $('#product-select').val();
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            if (productId) {
                fetchProductDetails(productId, fromDate, toDate);
            }
        });

        $(document).on('click', '#back-button', function() {
            $('#product-details .card-body').hide();
            $('#product-select').val(''); // Reset the select box
            $('#fromDate').val(''); // Reset the date inputs
            $('#toDate').val('');
        });

        // PDF Download Functionality
        $('#download-pdf').on('click', function() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Set text color to red
            doc.setTextColor(255, 0, 0);
            doc.text('Product Sales Invoice', 70, 10);

            // Reset text color to black (optional, if you have more text that should be black)
            doc.setTextColor(0, 0, 0);

            doc.text($('#product-info').text(), 50, 22);

            // Add sales data
            doc.setTextColor(0, 0, 255);

            doc.text('Discount Sales:', 10, 30);
            doc.setTextColor(0, 0, 0);
            doc.text('Total Quantity: ' + $('#discount-total-quantity').text(), 10, 40);
            doc.text('P & L: ' + $('#discount-total-profit').text(), 10, 50);
            doc.text('Total Sales: ' + $('#discount-total-amount').text(), 10, 60);

            doc.setTextColor(0, 0, 255);
            doc.text('Retail Sales:', 10, 80);
            doc.setTextColor(0, 0, 0);
            doc.text('Total Quantity: ' + $('#retail-total-quantity').text(), 10, 90);
            doc.text('P & L: ' + $('#retail-total-profit').text(), 10, 100);
            doc.text('Total Sales: ' + $('#retail-total-amount').text(), 10, 110);

            doc.setTextColor(0, 0, 255);
            doc.text('Wholesale Sales:', 10, 130);
            doc.setTextColor(0, 0, 0);
            doc.text('Total Quantity: ' + $('#wholesale-total-quantity').text(), 10, 140);
            doc.text('P & L: ' + $('#wholesale-total-profit').text(), 10, 150);
            doc.text('Total Sales: ' + $('#wholesale-total-amount').text(), 10, 160);

            doc.save('sales_report.pdf');
        });

        // Excel Download Functionality
        $('#download-excel').on('click', function() {
            const wb = XLSX.utils.book_new();

            // Product details
            const productInfoHtml = $('#product-info').html();
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            const dateRange =
                `Date Range: ${fromDate ? fromDate : 'N/A'} to ${toDate ? toDate : 'N/A'}`;

            // Strip HTML tags from the product info
            const productInfoText = productInfoHtml.replace(/<\/?[^>]+(>|$)/g, '').split('\n').filter(
                line => line.trim() !== '');

            const productDetails = [
                ['Product Details'],
                ...productInfoText.map(text => [text]),
                []
            ];

            // Sales data
            const ws_data = [
                ['Category', 'Total Quantity', 'P & L', 'Total Sales'],
                ['Discount Sales', $('#discount-total-quantity').text(), $('#discount-total-profit')
                    .text(), $('#discount-total-amount').text()
                ],
                ['Retail Sales', $('#retail-total-quantity').text(), $('#retail-total-profit')
                    .text(), $('#retail-total-amount').text()
                ],
                ['Wholesale Sales', $('#wholesale-total-quantity').text(), $(
                    '#wholesale-total-profit').text(), $('#wholesale-total-amount').text()]
            ];

            const combinedData = productDetails.concat(ws_data);
            const ws = XLSX.utils.aoa_to_sheet(combinedData);
            XLSX.utils.book_append_sheet(wb, ws, 'Sales Report');
            XLSX.writeFile(wb, 'sales_report.xlsx');
        });

    });
</script>
