<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Sales <span>| This Month</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $bedroom_total }}</h6>
                                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">Revenue <span>| This Month</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Rp{{ number_format($bedroom_count, 0, ',', '.') }}</h6>
                                    <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-4 col-md-6">

                    <div class="card info-card customers-card">

                        <div class="card-body">
                            <h5 class="card-title">Customers <span>| This Month</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $customer_total }}</h6>
                                    <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- End Customers Card -->

                <!-- Bedroom Availabel Card -->
                <div class="col-xxl-4 col-md-6">

                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Bedroom Available</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ri-hotel-bed-line"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $bedroom_available }}</h6>
                                    <span class="text-success small pt-1 fw-bold">20%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- End Bedroom Available Card -->

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title">Recent Sales <span>| This Month</span></h5>

                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Bedroom</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking_data as $see)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $see->user->name }}</td>
                                            <td>{{ $see->bedroom->name }}</td>
                                            <td>{{ $see->bedroom->price }}</td>
                                            @if ($see->status == 'pending')
                                                <td class="badge bg-warning mt-2 text-light">Pending</td>
                                            @endif
                                            @if ($see->status == 'paid')
                                                <td class="badge bg-success mx-3 mt-2 text-light">Paid</td>
                                            @endif
                                            @if ($see->status == 'rejected')
                                                <td class="badge bg-danger mt-2 text-light">Rejected</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div><!-- End Recent Sales -->

                {{-- Chart --}}
                <div class="container mt-5">
                    <h2 class="fs-2">Revenue and Total Customers per Bedroom</h2>
                    <div>
                        <label for="month">Choose Month:</label>
                        <select id="month" class="form-select" style="width: 20%" onchange="loadChartData()">
                            <option value="0" selected disabled>{{ date('F') }}</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <canvas id="revenueChart" width="100" height="100"></canvas>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    let revenueChart;

                    function loadChartData() {
                        const month = document.getElementById('month').value;

                        axios.get(`/api/data-revenue?month=${month}`)
                            .then(response => {
                                const data = response.data;

                                if (revenueChart) revenueChart.destroy();

                                const ctx = document.getElementById('revenueChart').getContext('2d');
                                revenueChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: data.label,
                                        datasets: [{
                                                label: 'Revenue (Rp)',
                                                data: data.revenue,
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Total Customer',
                                                data: data.customer,
                                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                                borderColor: 'rgba(153, 102, 255, 1)',
                                                borderWidth: 1
                                            }
                                        ]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            })
                            .catch(error => console.error(error));
                    }

                    document.addEventListener('DOMContentLoaded', loadChartData);
                </script>

            </div>
        </div>
    </div>
</section>
