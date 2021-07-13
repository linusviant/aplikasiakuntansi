@extends('layouts.admin')
@section('page-title')
    {{__('Account Statement')}}
@endsection
@push('script-page')
    <script src="{{ asset('assets/js/jspdf.min.js') }} "></script>
    <script src="{{ asset('assets/js/html2canvas.min.js') }} "></script>
    <script>

        $(document).ready(function() {
            $('#custom-dataTable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                "order": [[0, "desc"]]
            } );
        } );
    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Account Statement')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Account Statement')}}</div>
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

                            <div class="dropdown-menu dropdown-list dropdown-menu-right Filter-dropdown ">
                                {{ Form::open(array('route' => array('report.account.statement'),'method' => 'GET')) }}
                                <div class="form-group">
                                    {{ Form::label('account', __('Account')) }}
                                    {{ Form::select('account',$account,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('from', __('From')) }}
                                    {{ Form::text('from', isset($_GET['from'])?$_GET['from']:null, array('class' => 'form-control datepicker')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('to', __('To')) }}
                                    {{ Form::text('to', isset($_GET['to'])?$_GET['to']:null, array('class' => 'form-control datepicker')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('type', __('Type')) }}
                                    {{ Form::select('type',$types,isset($_GET['type'])?$_GET['type']:'', array('class' => 'form-control font-style selectric')) }}
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                                    <a href="{{route('report.account.statement')}}" class="btn btn-danger">{{__('Reset')}}</a>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12" id="statement-container">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Statement Summary')}}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">

                                                <table class="table table-flush tbl-border" >
                                                    <tbody>
                                                    <tr>
                                                        <th> {{__('Account')}}</th>
                                                        <td>{{!empty($_GET['account'])?$accountName->holder_name.' , '.$accountName->bank_name:'All'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th> {{__('From')}}</th>
                                                        <td>{{isset($_GET['from'])?$_GET['from']:$from}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th> {{__('To')}}</th>
                                                        <td>{{isset($_GET['to'])?$_GET['to']:$to}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th> {{__('Type')}}</th>
                                                        <td>{{isset($_GET['type'])?$_GET['type']:'All'}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-flush" id="custom-dataTable">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th> {{__('Date')}}</th>
                                                        <th> {{__('Description')}}</th>
                                                        <th> {{__('Type')}}</th>
                                                        <th> {{__('Amount')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($reportData['credit'] as $credit)
                                                        <tr class="font-style">
                                                            <td>{{ Auth::user()->dateFormat($credit->date) }}</td>
                                                            <td> {{$credit->description}} </td>
                                                            <td>{{__('Credit')}}</td>
                                                            <td>{{ Auth::user()->priceFormat($credit->amount) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    @foreach ($reportData['debit'] as $debit)
                                                        <tr class="font-style">
                                                            <td>{{ Auth::user()->dateFormat($debit->date) }}</td>
                                                            <td> {{$debit->description}} </td>
                                                            <td>{{__('Debit')}}</td>
                                                            <td>{{ Auth::user()->priceFormat($debit->amount) }}</td>
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
