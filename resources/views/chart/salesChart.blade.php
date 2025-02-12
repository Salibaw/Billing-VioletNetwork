<div class="card">
  <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <li class="dropdown-header text-start">
              <h6>Filter</h6>
          </li>
          <li><a class="dropdown-item filter-category" href="#" data-category="retail">Retail</a></li>
          <li><a class="dropdown-item filter-category" href="#" data-category="wholesales">Wholesale</a></li>
          <li><a class="dropdown-item filter-category" href="#" data-category="discount">Discount</a></li>
      </ul>
  </div>

  <div class="card-body pb-0">
      <h5 class="card-title">Total Sales <span id="selected-category">| Retail</span></h5>
      <div id="salesChart" style="min-height: 400px;" class="echart"></div>
  </div>
</div>

<!-- Include jQuery and ECharts if not already included in your layout -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

<script>
$(document).ready(function() {
  let chart;
  const initialCategory = 'retail';
  const colors = {};

  // Function to initialize the chart
  function initializeChart(data) {
      chart = echarts.init(document.querySelector("#salesChart"));
      chart.setOption({
          tooltip: {
              trigger: 'item'
          },
          legend: {
              top: '5%',
              left: 'center'
          },
          series: [{
              name: 'Sales Quantity',
              type: 'pie',
              radius: ['40%', '70%'],
              avoidLabelOverlap: false,
              label: {
                  show: false,
                  position: 'center'
              },
              emphasis: {
                  label: {
                      show: true,
                      fontSize: '18',
                      fontWeight: 'bold'
                  }
              },
              labelLine: {
                  show: false
              },
              data: data
          }]
      });
  }

  // Function to fetch data and update the chart
  function fetchDataAndUpdateChart(category) {
      $.ajax({
          url: `/sales/total/${category}`,
          method: 'GET',
          success: function(response) {
              const data = response.products.map(product => {
                  if (!colors[product.name]) {
                      colors[product.name] = getRandomColor();
                  }
                  return {
                      value: product.totalQuantity,
                      name: product.name,
                      itemStyle: {
                          color: colors[product.name]
                      }
                  };
              });

              if (chart) {
                  chart.setOption({
                      series: [{
                          data: data
                      }]
                  });
              } else {
                  initializeChart(data);
              }

              $('#selected-category').text(`| ${category.charAt(0).toUpperCase() + category.slice(1)}`);
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
</script>
