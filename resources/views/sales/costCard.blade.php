<div class="col-xxl-4 col-md-4">
    <div class="card info-card revenue-card">
        <div class="card-body">
            <h5 class="card-title">P % L <span>|Sales - Cost</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-rupee"></i>
                </div>
                <div class="ps-3">
                    <h6><span id="totalProfit"></span></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('getSalesData') }}',
            method: 'GET',
            success: function(response) {
                console.log(response);
                // Update the UI with the fetched data
                $('#totalProfit').text(response.totalProfit);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    });
</script>
