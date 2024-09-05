@extends('AdminPanel.layouts.master')

@section('content')

    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics">
        <div class="row">

                <!--/ Line Chart -->
                <div class="col-lg-12 col-12">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <h4 class="card-title">{{trans('common.Statistics')}}</h4>
                            <div class="d-flex align-items-center">
                                <p class="card-text me-25 mb-0">{{trans('common.thisMonthStatistics')}}</p>
                            </div>
                        </div>
                        <div class="card-body statistics-body">
                            <div class="row justify-content-center">
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-md-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-primary me-1">
                                            <div class="avatar-content">
                                                <i data-feather="user" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0">230k</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.newClients')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-md-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-info me-1">
                                            <div class="avatar-content">
                                                <i data-feather="trending-up" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0">8.549k</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.followupsStats')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-success me-1">
                                            <div class="avatar-content">
                                                <i data-feather="dollar-sign" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0">$9745</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.totalRevenues')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-1">
                                            <div class="avatar-content">
                                                <i data-feather="box" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0">1.423k</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.expenses')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-primary me-1">
                                            <div class="avatar-content">
                                                <i data-feather="check" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0">1.423k</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.net')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            

            <!-- Avg Sessions Chart Card starts -->
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row pb-50">
                            <div class="col-sm-6 col-12 d-flex justify-content-between flex-column order-sm-1 order-2 mt-1 mt-sm-0">
                                <div class="mb-1 mb-sm-0">
                                    <h2 class="fw-bolder mb-25">0</h2>
                                    <p class="card-text fw-bold mb-2">{{trans('common.salesInLast7Days')}}</p>
                                    <div class="font-medium-2">
                                        <span class="text-success me-25">0%</span>
                                        <span>{{trans('common.vs last 7 days')}}<br>0</span>
                                    </div>
                                </div>
                                <!-- <button type="button" class="btn btn-primary">View Details</button> -->
                            </div>
                            <div class="col-sm-6 col-12 d-flex justify-content-between flex-column text-end order-sm-2 order-1">
                                <!-- <div class="dropdown chart-dropdown">
                                    <button class="btn btn-sm border-0 dropdown-toggle p-50" type="button" id="dropdownItem5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{trans('common.Last 7 Days')}}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownItem5">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div> -->
                                <div id="avg-sessions-chart"></div>
                            </div>
                        </div>
                        <hr />
                        <div class="row avg-sessions pt-50">
                            <div class="col-6 mb-2">
                                <p class="mb-50">مكالمات هاتفية: 50</p>
                                <div class="progress progress-bar-primary" style="height: 6px">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100" style="width: 50%"></div>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <p class="mb-50">زيارات بالشركة: 60</p>
                                <div class="progress progress-bar-warning" style="height: 6px">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="60" aria-valuemax="100" style="width: 60%"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="mb-50">معاينات خارجية: 70</p>
                                <div class="progress progress-bar-danger" style="height: 6px">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="70" aria-valuemax="100" style="width: 70%"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="mb-50">تعاقدات تامة: 90</p>
                                <div class="progress progress-bar-success" style="height: 6px">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="90" aria-valuemax="100" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Avg Sessions Chart Card ends -->
            <!-- Greetings Card starts -->
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="divider mt-0">
                            <div class="divider-text">{{trans('common.ShortCut')}}</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xl-4">
                        <div class="card bg-primary text-white text-center">
                            <div class="card-body">
                                <a href="{{route('admin.adminUsers')}}" class="text-white">
                                    {{trans('common.users')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xl-4">
                        <div class="card bg-primary text-white text-center">
                            <div class="card-body">
                                <a href="{{route('admin.clients')}}" class="text-white">
                                    {{trans('common.clients')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xl-4">
                        <div class="card bg-primary text-white text-center">
                            <div class="card-body">
                                <a href="{{route('admin.followups')}}" class="text-white">
                                    {{trans('common.followups')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-congratulations mb-0">
                    <div class="card-body text-center">
                        <img src="{{asset('AdminAssets/app-assets/images/elements/decore-left.png')}}" class="congratulations-img-left" alt="card-img-left" />
                        <img src="{{asset('AdminAssets/app-assets/images/elements/decore-right.png')}}" class="congratulations-img-right" alt="card-img-right" />
                        <div class="avatar avatar-xl bg-primary shadow">
                            <div class="avatar-content">
                                <i data-feather="award" class="font-large-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-1 text-white">{{trans('common.Congratulations')}}</h1>
                            <p class="card-text m-auto w-75">
                                لديك 23 موظف قاموا بتحقيق تارجت الشهر الحالي ويمكنك ملاحظتهم من خلال الولوج إلى التقارير الخاصة بالأفراد من قائمة التقارير
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Greetings Card ends -->

        </div>
    </section>
    <!-- Dashboard Analytics end -->

@stop

@section('new_style')
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/css-rtl/plugins/charts/chart-apex.css')}}">
@stop

@section('scripts')
    <script src="{{asset('AdminAssets/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
    <!-- BEGIN: Page JS-->
    <?php /*<script src="{{asset('AdminAssets/app-assets/js/scripts/pages/dashboard-analytics.js')}}"></script>*/?>
    <script src="{{asset('AdminAssets/app-assets/js/scripts/pages/app-invoice-list.js')}}"></script>
    <!-- END: Page JS-->
    <script>
        $(window).on('load', function () {
            var $avgSessionStrokeColor2 = '#ebf0f7';
            var $avgSessionsChart = document.querySelector('#avg-sessions-chart');
            var avgSessionsChartOptions;
            var avgSessionsChart;
            // Average Session Chart
            // ----------------------------------
            avgSessionsChartOptions = {
                chart: {
                    type: 'bar',
                    height: 200,
                    sparkline: { enabled: true },
                    toolbar: { show: false }
                },
                states: {
                    hover: {
                    filter: 'none'
                    }
                },
                colors: [
                    window.colors.solid.primary,
                    window.colors.solid.primary,
                    window.colors.solid.primary,
                    window.colors.solid.primary,
                    window.colors.solid.primary,
                    window.colors.solid.primary
                ],
                series: [
                    {
                        name: 'Sessions',
                        data: [75, 125, 20, 175, 125, 75, 25]
                    }
                ],
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        distributed: true,
                        endingShape: 'rounded'
                    }
                },
                tooltip: {
                    x: { show: false }
                },
                xaxis: {
                    type: 'numeric'
                }
            };
            avgSessionsChart = new ApexCharts($avgSessionsChart, avgSessionsChartOptions);
            avgSessionsChart.render();

        });
    </script>
@stop
