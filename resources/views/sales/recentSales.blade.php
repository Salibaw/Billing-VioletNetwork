<div class="col-12">
    <div class="card recent-sales overflow-auto">
        <div class="card-body">
            <h5 class="card-title">Recent Sales</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <input class="form-control searchBill" placeholder="Search..." type="search" name="search"
                        title="Search within table">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="fromDate" placeholder="From Date">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="toDate" placeholder="To Date">
                </div>
            </div>
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">Bill No</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Category</th>
                    </tr>
                </thead>
                <tbody id="billData">
                    <!-- Data will be populated here by AJAX -->
                </tbody>
            </table>
            <div>Total Quantity: <span id="totalQuantity"></span></div>
            <div>Total Amount: <span id="totalAmount"></span></div>
        </div>
    </div>
</div>

<!-- Modal to show bill details -->
<div class="modal fade" id="billDetailsModal" tabindex="-1" aria-labelledby="billDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="billDetailsModalLabel">Bill Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <p><strong>Bill No:</strong> <span id="billNo"></span></p>
                        <p><strong>Product:</strong> <span id="productName1"></span></p>
                        <p><strong>Quantity:</strong> <span id="quantity"></span></p>
                        <p><strong>Price:</strong> <span id="price"></span></p>
                        <p><strong>Total:</strong> <span id="totalAmount1"></span></p>
                    </div>
                    <div class="col">
                        <p><strong>Category:</strong> <span id="category"></span></p>
                        <p><strong>Customer number:</strong> <span id="customerNumber"></span></p>
                        <p><strong>Date:</strong> <span id="date"></span></p>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button id="download-pdf" class="btn btn-primary me-2">Download PDF</button>
                    <button id="download-excel" class="btn btn-success">Download Excel</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        fetchBillData();

        function fetchBillData(query = '', fromDate = '', toDate = '') {
            $.ajax({
                url: '{{ route('getAllSales') }}',
                method: 'GET',
                data: {
                    query: query,
                    fromDate: fromDate,
                    toDate: toDate
                },
                success: function(response) {
                    console.log(response);
                    let billData = '';
                    $.each(response.bills, function(index, bill) {
                        billData += `
                        <tr>
                            <td>${bill.billNo}</td>
                            <td>${bill.product ? bill.product.name : 'N/A'}</td>
                            <td>${bill.productQuantity}</td>
                            <td>${bill.productMrp}</td>
                            <td>${bill.salesCategory}</td>
                            <td><button class="btn btn-outline-info btn-sm viewDetails" data-id="${bill.id}">Details</button></td>
                        </tr>
                    `;
                    });
                    $('#billData').html(billData);
                    $('#totalQuantity').text(response.totalQuantity);
                    $('#totalAmount').text(response.totalAmount);
                    // Attach click event to details buttons
                    $('.viewDetails').click(function() {
                        const billId = $(this).data('id');
                        fetchBillDetails(billId);
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        $('.searchBill').on('input', function() {
            let query = $(this).val();
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            fetchBillData(query, fromDate, toDate);
        });

        $('#fromDate, #toDate').on('change', function() {
            let query = $('.searchBill').val();
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            fetchBillData(query, fromDate, toDate);
        });

        function formatDate(dateString) {
            let options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }

        function fetchBillDetails(billId) {
            $.ajax({
                url: `/sales/${billId}`, // Update the URL according to your route
                method: 'GET',
                success: function(response) {
                    // Populate bill details in the modal
                    $('#billNo').text(response.bill.billNo);
                    $('#productName1').text(response.bill.product ? response.bill.product.name :
                        'N/A');
                    $('#quantity').text(response.bill.productQuantity);
                    $('#price').text(response.bill.productMrp);
                    $('#category').text(response.bill.salesCategory);
                    $('#customerNumber').text(response.bill.phone || 'N/A');
                    $('#date').text(formatDate(response.bill.created_at));

                    // Calculate total amount
                    const totalAmount = response.bill.productQuantity * response.bill.productMrp;
                    $('#totalAmount1').text(` ${totalAmount.toFixed(2)}`);

                    // Show the modal
                    $('#billDetailsModal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        // Event listener for clicking the "Download PDF" button
        $('#download-pdf').click(function() {
            // Generate PDF
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF('p', 'pt', 'a4');

            // Add bill details to PDF
            const content = `
            Bill No: ${$('#billNo').text()}
            Product: ${$('#productName1').text()}
            Quantity: ${$('#quantity').text()}
            Price: ${$('#price').text()}
            Total Amount: ${$('#totalAmount1').text()}
            Category: ${$('#category').text()}
            Customer number: ${$('#customerNumber').text()}
            Date: ${$('#date').text()}
        `;
            pdf.text(content, 50, 50);

            // Save PDF
            pdf.save('bill-details.pdf');
        });

        // Event listener for clicking the "Download Excel" button
        $('#download-excel').click(function() {
            // Generate Excel
            const wb = XLSX.utils.book_new();
            const wsData = [
                ["Field", "Value"],
                ["Bill No", $('#billNo').text()],
                ["Product", $('#productName1').text()],
                ["Quantity", $('#quantity').text()],
                ["Price", $('#price').text()],
                ["Total Amount", $('#totalAmount1').text()],
                ["Category", $('#category').text()],
                ["Customer number", $('#customerNumber').text()],
                ["Date", $('#date').text()]
            ];
            const ws = XLSX.utils.aoa_to_sheet(wsData);
            XLSX.utils.book_append_sheet(wb, ws, "Bill Details");

            // Save Excel
            XLSX.writeFile(wb, 'bill-details.xlsx');
        });

        // Event listener for clicking the "Details" button
        $('.viewDetails').click(function() {
            const billId = $(this).data('id');
            fetchBillDetails(billId);
        });
    });
</script>
