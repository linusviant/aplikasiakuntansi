@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection

@push('script-page')
    <script src="{{ asset('assets/js/jspdf.min.js') }} "></script>
    <script src="{{ asset('assets/js/html2canvas.min.js') }} "></script>
    <script>
        var SalesChart = (function () {
            var $chart = $('#chart-sales');

            function init($this) {
                var salesChart = new Chart($this, {
                    type: 'line',
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    color: Charts.colors.gray[200],
                                    zeroLineColor: Charts.colors.gray[200]
                                },
                                ticks: {}
                            }]
                        }
                    },
                    data: {
                        labels: {!! json_encode($monthList) !!},
                        datasets: [{
                            label: 'Income',
                            data:{!! json_encode($chartIncomeArr) !!},
                        }]
                    },
                });
                $this.data('chart', salesChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();
        var year = '{{$currentYear}}';

        function saveAsPDF() {
            html2canvas(document.getElementById("chart-container"), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL();
                    var doc = new jsPDF("p", "pt", "a2");
                    doc.addImage(img, 10, 10);
                    doc.save(year + '_income_report.pdf');
                }
            });
        }
    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Income Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Income Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row text-right mb-10">
                <div class="col-12">
                    <a href="#" data-toggle="dropdown" class="btn btn-icon icon-left btn-primary" id="filter-buttons">
                        <i class="fas fa-filter"></i>{{__('Filter')}}
                    </a>
                    <a href="#" onclick="saveAsPDF();" class="btn btn-icon icon-left btn-primary pdf-btn" id="download-buttons">
                        <i class="fas fa-download"></i>{{__('Download')}}
                    </a>
                    <div class="card-header-action">
                        <div class="dropdown">
                            <div class="dropdown-menu dropdown-list dropdown-menu-right Filter-dropdown">
                                {{ Form::open(array('route' => array('report.income.summary'),'method' => 'GET')) }}
                                <div class="form-group">
                                    {{ Form::label('year', __('Year')) }}
                                    {{ Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('account', __('Account')) }}
                                    {{ Form::select('account',$account,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('category', __('Category')) }}
                                    {{ Form::select('category',$category,isset($_GET['category'])?$_GET['category']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('customer', __('Customer')) }}
                                    {{ Form::select('customer',$customer,isset($_GET['customer'])?$_GET['customer']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                                    <a href="{{route('report.income.summary')}}" class="btn btn-danger">{{__('Reset')}}</a>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12" id="chart-container">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Income Summary')}}</h4><h4><b>{{$currentYear}}</b></h4>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <canvas id="chart-sales" height="300"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-flush border font-style" id="dataTable-manual">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>{{__('Category')}}</th>
                                                        @foreach($monthList as $month)
                                                            <th>{{$month}}</th>
                                                        @endforeach
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <tr>
                                                        <td colspan="13"><b><h6>{{__('Revenue :')}}</h6></b></td>
                                                    </tr>
                                                    @foreach($incomeArr as $i=>$income)
                                                        <tr>
                                                            <td>{{$income['category']}}</td>
                                                            @foreach($income['data'] as $j=>$data)
                                                                <td>{{\Auth::user()->priceFormat($data)}}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="13"><b><h6>{{__('Invoice :')}}</h6></b></td>
                                                    </tr>
                                                    @foreach($invoiceArray as $i=>$invoice)
                                                        <tr>
                                                            <td>{{$invoice['category']}}</td>
                                                            @foreach($invoice['data'] as $j=>$data)
                                                                <td>{{\Auth::user()->priceFormat($data)}}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="13"><b><h6>{{__('Income = Revenue + Invoice :')}}</h6></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{__('Total')}}</td>
                                                        @foreach($chartIncomeArr as $i=>$income)
                                                            <td>{{\Auth::user()->priceFormat($income)}}</td>
                                                        @endforeach
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection


