@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script src="{{ asset('assets/js/jspdf.min.js') }} "></script>
    <script src="{{ asset('assets/js/html2canvas.min.js') }} "></script>
    <script>
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
            <h1>{{__('Tax Summary')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Tax Summary')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row text-right mb-10">
                <div class="col-12">
                    <a href="#" data-toggle="dropdown" class="btn btn-icon icon-left btn-primary">
                        <i class="fas fa-filter"></i>{{__('Filter')}}
                    </a>
                    <a href="#" onclick="saveAsPDF();" class="btn btn-icon icon-left btn-primary pdf-btn" id="download-buttons">
                        <i class="fas fa-download"></i>{{__('Download')}}
                    </a>
                    <div class="card-header-action">
                        <div class="dropdown">
                            <div class="dropdown-menu dropdown-list dropdown-menu-right Filter-dropdown">
                                {{ Form::open(array('route' => array('report.tax.summary'),'method' => 'GET')) }}
                                <div class="form-group">
                                    {{ Form::label('year', __('Year')) }}
                                    {{ Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                                    <a href="{{route('report.tax.summary')}}" class="btn btn-danger">{{__('Reset')}}</a>
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
                                <h4>{{__('Tax Summary')}}</h4> <h4><b>{{$currentYear}}</b></h4>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <h4>{{__('Income')}}</h4>
                                                <table class="table table-flush border" id="dataTable-manual">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>{{__('Tax')}}</th>
                                                        @foreach($monthList as $month)
                                                            <th>{{$month}}</th>
                                                        @endforeach
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($incomes as $i=>$income)
                                                        <tr>
                                                            <td>{{$income['tax']}}</td>
                                                            @foreach($income['data'] as $j=>$data)
                                                                <td>{{\Auth::user()->priceFormat($data)}}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-sm-12">
                                                <h4>{{__('Expense')}}</h4>
                                                <table class="table table-flush border" id="dataTable-manual">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>{{__('Tax')}}</th>
                                                        @foreach($monthList as $month)
                                                            <th>{{$month}}</th>
                                                        @endforeach
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($expenses as $i=>$expense)
                                                        <tr>
                                                            <td>{{$expense['tax']}}</td>
                                                            @foreach($expense['data'] as $j=>$data)
                                                                <td>{{\Auth::user()->priceFormat($data)}}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
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


