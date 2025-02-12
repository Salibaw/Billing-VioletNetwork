<div class="col-12">
    <div class="card">
        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item filter-category" href="#" data-category="retail">Retail</a></li>
                <li><a class="dropdown-item filter-category" href="#" data-category="wholesale">Wholesale</a></li>
                <li><a class="dropdown-item filter-category" href="#" data-category="discount">Discount</a></li>
            </ul>
        </div>
        <div class="card-body">
            <h5 class="card-title">Reports <span id="selected-category">/Retail</span></h5>
            <!-- Line Chart -->
            <div id="reportsChart"></div>
        </div>
    </div>
</div>

<!-- Include jQuery and ApexCharts if not already included in your layout -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        let chart;
        const initialCategory = 'retail';
        // Function to initialize the chart
        function initializeChart(data) {
            chart = new ApexCharts(document.querySelector("#reportsChart"), {
                series: data.series,
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                },
                markers: {
                    size: 4
                },
                colors: data.colors,
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    type: 'datetime',
                    categories: data.categories
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                }
            });
            chart.render();
        }
        // Function to fetch data and update the chart
        function fetchDataAndUpdateChart(category) {
            $.ajax({
                url: `/sales/total/${category}`,
                method: 'GET',
                success: function(response) {
                    const data = {
                        series: [],
                        categories: [],
                        colors: []
                    };
                    response.products.forEach(product => {
                        data.series.push({
                            name: product.name,
                            data: product.sales.map(sale => sale.quantity)
                        });
                        data.categories = product.sales.map(sale => sale.date);
                        data.colors.push(getRandomColor());
                    });
                    if (chart) {
                        chart.updateSeries(data.series);
                        chart.updateOptions({
                            colors: data.colors,
                            xaxis: {
                                categories: data.categories
                            }
                        });
                    } else {
                        initializeChart(data);
                    }
                    $('#selected-category').text(
                        `/${category.charAt(0).toUpperCase() + category.slice(1)}`);
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }
        // Helper function to generate a random color
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
        // Event handler for category selection
        $(document).on('click', '.filter-category', function(e) {
            e.preventDefault();
            const category = $(this).data('category');
            fetchDataAndUpdateChart(category);
        });
        // Initialize chart with default category
        fetchDataAndUpdateChart(initialCategory);
    });
</script>88
