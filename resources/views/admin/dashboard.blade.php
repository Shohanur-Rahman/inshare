@extends('layouts.admin_layout') @section('content')



    <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-5 col-xs-12 mb-5 application-box">
            <div class="card">
                <div class="card-body bg-green">
                    <div class="counter-ui ">
                        <span class="count-number">{{$arrayData}}</span>
                        @if($arrayData <= 1)
                            <span class="count-folder">Application</span>
                        @else
                            <span class="count-folder">Applications</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">




        <div class="col-md-12 col-sm-12 col-xs-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <div id="raChart"></div>
                </div>
            </div>
        </div>


    </div>


    <script>
        $(document).ready(function () {
            ActiveLeftSideMenuOnLoad(".dashboard_menu", 0);
            createRaChart();;
        });


        $(document).bind("kendo:skinChange", createRaChart);


        function createRaChart() {
            $("#raChart").kendoChart(

                {
                    dataSource: {
                        transport: {
                            read: {
                                url: "{{route('get_directory_pie_chart_data')}}",
                                dataType: "json"
                            }
                        },
                        sort: {
                            field: "year",
                            dir: "asc"
                        }
                    },
                    height: 800,
                    title: {
                        text: "Applications"
                    },
                    legend: {
                        position: "bottom"
                    },
                    seriesDefaults: {
                        type: "pie",
                        template: "#= category #: \n #= value#"
                    },
                    series:
                        [{
                            field: "total_count",
                            categoryField: "folder_name",
                        }],
                    categoryAxis: {
                        labels: {
                            rotation: -45
                        },
                        majorGridLines: {
                            visible: false
                        }
                    },
                    valueAxis: {
                        labels: {
                            format: "N0"
                        },
                        majorUnit: 200,
                        line: {
                            visible: false
                        }
                    },
                    tooltip: {
                        visible: true,
                        template: "#= category #: \n #= value#"
                    }
                }

            );
        }


    </script>

@endsection
