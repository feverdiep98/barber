@extends('admin.layout.master')
@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Product</p>
                        <h6 class="mb-0">{{ $totalCreatedProducts }} Products</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Services</p>
                        <h6 class="mb-0">{{ $totalCreatedServices }} Services</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Orders</p>
                        <h6 class="mb-0">{{ $totalOrders }} Orders</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Booking</p>
                        <h6 class="mb-0">{{ $totalBookings }} Booked</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <canvas id="barChart" width="100" height="500"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Pie Chart</h6>
                    <canvas id="pie-chart"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Pie Chart</h6>
                    <canvas id="pie-chart-2"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-custom')
    <script>
        var ctx = document.getElementById('pie-chart').getContext('2d');
        var data = {
            labels: @json($labels_product),
            datasets: [{
                data: @json($values_product),
                backgroundColor: ['#001848', '#301860', '#483078','#604878','#906090'], // Màu sắc cho từng phần
            }]
        };
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
        });

        var ctx2 = document.getElementById('pie-chart-2').getContext('2d');
        var data2 = {
            labels: @json($labels_booking),
            datasets: [{
                data: @json($values_booking),
                backgroundColor: ['#343838', '#005f6b', '#008c9e','#00b4cc','#00dffc','#3fb8af'], // Màu sắc cho từng phần
            }]
        };
        var pieChart2 = new Chart(ctx2, {
            type: 'pie',
            data: data2,
        });

        var barLabels = @json($barLabels);
        var barValues = @json($barValues);

        // Lấy thẻ canvas để vẽ biểu đồ
        var barChartCanvas = document.getElementById('barChart').getContext('2d');

        // Tạo biểu đồ thanh
        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Revenue',
                    data: barValues,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(255, 205, 86, 0.5)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,

                    }
                }
            }
        });
    </script>
@endsection
