<div class="col-xxl-4 col-md-4">
    <div class="card info-card sales-card">
        <div class="card-body">
            <h5 class="card-title">Quantity Sold: <span>| Month</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                    <h6> <span id="quantitySold"></span></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $.ajax({
        url: '{{ route('getSalesData') }}',
        method: 'GET',
        success: function(response) {
            // Update the UI with the fetched data
            $('#quantitySold').text(response.quantitySold);
            $('#totalSalesAmount').text(response.totalSalesAmount);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
</script>
