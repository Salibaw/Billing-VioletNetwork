@section('content')
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Sales Card -->
                    @include('sales.salesCard')
                    <!-- End Sales Card -->

                    <!-- Production Cost Card -->
                    @include('sales.costCard')
                    <!-- End Production Cost Card -->

                    <!-- Revenue Card -->
                    @include('sales.revenueCard')
                    <!-- End Revenue Card -->

                    <!-- Reports -->
                    {{-- @include('sales.reportChart')  --}}
                    <!-- End Reports -->

                    <!-- Recent Sales -->
                    @include('sales.recentSales')
                    <!-- End Recent Sales -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Website Traffic -->
                @include('chart.salesChart')
                <!-- End Website Traffic -->
            </div><!-- End Right side columns -->
        </div>
    </section>
@endsection
