@extends('layouts.admin')
@section('page-title')
    {{__('Bill Summary')}}
@endsection
@push('script-page')
    <script src="{{ asset('assets/js/jspdf.min.js') }} "></script>
    <script src="{{ asset('assets/js/html2canvas.min.js') }} "></script>
    <script>
        function saveAsPDF() {
            html2canvas(document.getElementById("bill-container"), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL();
                    var doc = new jsPDF("p", "pt", "a2");
                    doc.addImage(img, 10, 10);
                    doc.save('bill_report.pdf');
                }
            });
        }

        var SalesChart = (function () {
            var $chart = $('#chart-sales');

            function init($this) {
                var salesChart = new Chart($this, {
                    type: 'bar',
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
                            label: 'Bill',
                            data:{!! json_encode($billTotal) !!},
                        }]
                    },
                });
                $this.data('chart', salesChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();
    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Invoice Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Bill Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row text-right mb-10">
                <div class="col-12">
                    <div class="card-header-action">
                        <div class="dropdown ">

                            <a href="#" data-toggle="dropdown" class="btn btn-icon icon-left btn-primary">
                                <i class="fas fa-filter"></i>{{__('Filter')}}
                            </a>
                            <a href="#" onclick="saveAsPDF();" class="btn btn-icon icon-left btn-primary pdf-btn" id="download-buttons">
                                <i class="fas fa-download"></i>{{__('Download')}}
                            </a>
                            <div class="dropdown-menu dropdown-list dropdown-menu-right Filter-dropdown w-64">
                                {{ Form::open(array('route' => array('report.bill.summary'),'method' => 'GET')) }}
                                <div class="form-group">
                                    {{ Form::label('vender', __('Vender')) }}
                                    {{ Form::select('vender',$vender,isset($_GET['vender'])?$_GET['vender']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('bill_date', __('Date')) }}
                                    {{ Form::text('bill_date', isset($_GET['bill_date'])?$_GET['bill_date']:null, array('class' => 'form-control datepicker-range')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('status', __('Status')) }}
                                    {{ Form::select('status', [''=>'All'] + $status,isset($_GET['status'])?$_GET['status']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                                    <a href="{{route('report.bill.summary')}}" class="btn btn-danger">{{__('Reset')}}</a>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12" id="bill-container">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <ul class="nav nav-pills mb-3" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profile-tab3" data-toggle="tab" href="#summary" role="tab" aria-controls="" aria-selected="false">{{__('Summary')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#bills" role="tab" aria-controls="" aria-selected="false">{{__('Bill')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between ">
                                <b> {{date('Y')}}</b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="tab-content" id="myTabContent2">
                                                    <table class="table table-flush tbl-border" id="">
                                                        <tbody>
                                                        <tr>
                                                            <th> {{__('Total Bill')}}</th>
                                                            <td>{{Auth::user()->priceFormat($totalBill)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th> {{__('Total Paid')}}</th>
                                                            <td>{{Auth::user()->priceFormat($totalDueBill)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th> {{__('Total Due')}}</th>
                                                            <td>{{Auth::user()->priceFormat($totalPaidBill)}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="tab-pane fade fade" id="bills" role="tabpanel" aria-labelledby="profile-tab3">
                                                        <table class="table table-flush" id="">
                                                            <thead class="thead-light">
                                                            <tr>
                                                                <th> {{__('Bill')}}</th>
                                                                <th> {{__('Date')}}</th>
                                                                <th> {{__('Customer')}}</th>
                                                                <th> {{__('Category')}}</th>
                                                                <th> {{__('Status')}}</th>
                                                                <th> {{__('	Paid Amount')}}</th>
                                                                <th> {{__('Due Amount')}}</th>
                                                                <th> {{__('Payment Date')}}</th>
                                                                <th> {{__('Amount')}}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($bills as $bill)

                                                                <tr class="font-style">
                                                                    <td>
                                                                        <a class="btn btn-outline-primary" href="{{ route('bill.show',$bill->id) }}">
                                                                            {{ AUth::user()->billNumberFormat($bill->bill_id) }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ Auth::user()->dateFormat($bill->bill_date) }}</td>
                                                                    <td> {{!empty($bill->vender)? $bill->vender->name:'' }} </td>
                                                                    <td>{{ !empty($bill->category)?$bill->category->name:''}}</td>
                                                                    <td>
                                                                        @if($bill->status == 0)
                                                                            <b><span class="text-primary">{{ __(\App\Invoice::$statues[$bill->status]) }}</span></b>
                                                                        @elseif($bill->status == 1)
                                                                            <b> <span class="text-warning">{{ __(\App\Invoice::$statues[$bill->status]) }}</span></b>
                                                                        @elseif($bill->status == 2)
                                                                            <b> <span class="text-danger">{{ __(\App\Invoice::$statues[$bill->status]) }}</span></b>
                                                                        @elseif($bill->status == 3)
                                                                            <b> <span class="text-info">{{ __(\App\Invoice::$statues[$bill->status]) }}</span></b>
                                                                        @elseif($bill->status == 4)
                                                                            <b> <span class="text-success">{{ __(\App\Invoice::$statues[$bill->status]) }}</span></b>
                                                                        @endif
                                                                    </td>
                                                                    <td> {{\Auth::user()->priceFormat($bill->getTotal()-$bill->getDue())}}</td>
                                                                    <td> {{\Auth::user()->priceFormat($bill->getDue())}}</td>
                                                                    <td>{{!empty($bill->lastPayments)?\Auth::user()->dateFormat($bill->lastPayments->date):''}}</td>
                                                                    <td> {{\Auth::user()->priceFormat($bill->getTotal())}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="tab-pane fade fade show active" id="summary" role="tabpanel" aria-labelledby="profile-tab3">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <canvas id="chart-sales" height="300"></canvas>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
