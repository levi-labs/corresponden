@extends('layouts.main.master')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        {{-- <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav> --}}
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">



                            <div class="card-body">
                                @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                    <h5 class="card-title">Unread <span></span></h5>
                                @else
                                    <h5 class="card-title">Users <span></span></h5>
                                @endif


                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                            <i class="bi bi-envelope"></i>
                                        @else
                                            <i class="bi bi-people"></i>
                                        @endif

                                    </div>
                                    <div class="ps-3">
                                        @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                            <h6>{{ $count_unread }}</h6>
                                        @else
                                            <h6>{{ $count_user }}</h6>
                                        @endif

                                        {{-- <span class="text-success small pt-1 fw-bold">12</span> <span
                                            class="text-muted small pt-2 ps-1">increase</span> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">



                            <div class="card-body">
                                @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                    <h5 class="card-title">Inbox</h5>
                                @else
                                    <h5 class="card-title">Archived Letter<span> | Internal</span></h5>
                                @endif


                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                            <i class="bi bi-envelope"></i>
                                        @else
                                            <i class="bi bi-archive"></i>
                                        @endif

                                    </div>
                                    <div class="ps-3">
                                        @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                            <h6>{{ $inbox }}</h6>
                                        @else
                                            <h6>{{ $archive_incoming }}</h6>
                                        @endif

                                        {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span
                                            class="text-muted small pt-2 ps-1">increase</span> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">


                            <div class="card-body">
                                @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                    <h5 class="card-title">Sent</h5>
                                @else
                                    <h5 class="card-title">Archived Letter <span>| External</span></h5>
                                @endif
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                            <i class="bi bi-envelope"></i>
                                        @else
                                            <i class="bi bi-archive"></i>
                                        @endif
                                    </div>
                                    <div class="ps-3">
                                        @if (auth('web')->user()->role == 'student' || auth('web')->user()->role == 'lecturer')
                                            <h6>{{ $sent }}</h6>
                                        @else
                                            <h6>{{ $archive_outgoing }}</h6>
                                        @endif

                                        {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span
                                            class="text-muted small pt-2 ps-1">decrease</span> --}}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <!-- Reports -->
                    @if (auth('web')->user()->role == 'admin' || auth('web')->user()->role == 'staff')
                        <div class="col-12">
                            <div class="card">


                                <div class="card-body">
                                    <h5 class="card-title">Reports <span>/System Activity</span></h5>

                                    <!-- Line Chart -->
                                    <div id="reportsChart"></div>

                                    <script>
                                        let dates = {!! json_encode($dates) !!};
                                        let activityCounts = {!! json_encode($activityCounts) !!};
                                        let dates_arsip_masuk = {!! json_encode($dates_arsip_masuk) !!};
                                        let activityCounts_arsip_masuk = {!! json_encode($activityCounts_arsip_masuk) !!};
                                        let dates_arsip_keluar = {!! json_encode($dates_arsip_keluar) !!};
                                        let activityCounts_arsip_keluar = {!! json_encode($activityCounts_arsip_keluar) !!};
                                        document.addEventListener("DOMContentLoaded", () => {

                                            new ApexCharts(document.querySelector("#reportsChart"), {
                                                series: [{
                                                    name: 'Activity',
                                                    data: activityCounts,
                                                }, {
                                                    name: 'Arsip Masuk',
                                                    data: activityCounts_arsip_masuk
                                                }, {
                                                    name: 'Arsip Keluar',
                                                    data: activityCounts_arsip_keluar
                                                }],
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
                                                colors: ['#4154f1', '#2eca6a', '#ff771d'],
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
                                                // xaxis: {
                                                //     type: 'datetime',
                                                //     // categories: [dates, dates_arsip_masuk, dates_arsip_keluar],
                                                // },
                                                tooltip: {
                                                    x: {
                                                        format: 'dd/MM/yy HH:mm'
                                                    },
                                                }
                                            }).render();
                                        });
                                    </script>


                                    <!-- End Line Chart -->

                                </div>

                            </div>
                        </div><!-- End Reports -->
                    @endif

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Activity <span>| Today</span></h5>

                        <div class="activity">
                            <style>
                                .my-font {
                                    font-size: 0.760rem;
                                    //wrap
                                }
                            </style>
                            @foreach ($recentActivity as $item)
                                <p class="my-font">
                                    {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                </p>
                                <div class="activity-item d-flex">

                                    <div class="activite-label me-3">
                                    </div>
                                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                    <div class="activity-content">
                                        {{ $item->activity_type }}
                                    </div>

                                </div><!-- End activity item-->
                            @endforeach


                        </div>

                    </div>
                </div><!-- End Recent Activity -->



            </div><!-- End Right side columns -->

        </div>
    </section>
@endsection
