@extends('layouts.admin')
@section('page-title')
    {{__('Credit Note')}}
@endsection
@push('script-page')
    <script>
        $(document).on('change', '#bill', function () {

            var id = $(this).val();
            var url = "{{route('bill.get')}}";

            $.ajax({
                url: url,
                type: 'get',
                cache: false,
                data: {
                    'bill_id': id,

                },
                success: function (data) {
                    $('#amount').val(data)
                },

            });

        })
    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Credit Note')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Debit Note')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Manage Debit Note')}}</h4>
                                @can('create debit note')
                                    <a href="#" data-url="{{ route('bill.custom.debit.note') }}" data-ajax-popup="true" data-title="{{__('Create New Debit Note')}}" class="btn btn-icon icon-left btn-primary">
                                        <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                        <span class="btn-inner--text"> {{__('Create')}}</span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body p-0">
                                <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-flush" id="dataTable">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th> {{__('Bill')}}</th>
                                                        <th> {{__('Vendor')}}</th>
                                                        <th> {{__('Date')}}</th>
                                                        <th> {{__('Amount')}}</th>
                                                        <th> {{__('Description')}}</th>
                                                        <th class="text-right"> {{__('Action')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach ($bills as $bill)
                                                        @if(!empty($bill->debitNote))
                                                            @foreach ($bill->debitNote as $debitNote)

                                                                <tr class="font-style">
                                                                    <td>
                                                                        <a class="btn btn-outline-primary" href="{{ route('bill.show',$debitNote->bill) }}">{{ AUth::user()->billNumberFormat($bill->bill_id) }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ (!empty($bill->vender)?$bill->vender->name:'') }}</td>
                                                                    <td>{{ Auth::user()->dateFormat($debitNote->date) }}</td>
                                                                    <td>{{ Auth::user()->priceFormat($debitNote->amount) }}</td>
                                                                    <td>{{$debitNote->description}}</td>
                                                                    <td class="text-right">
                                                                        @can('edit debit note')
                                                                            <a data-url="{{ route('bill.edit.debit.note',[$debitNote->bill,$debitNote->id]) }}" data-ajax-popup="true" data-title="{{__('Add Debit Note')}}" data-toggle="tooltip" data-original-title="{{__('Credit Note')}}" href="#" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                                <i class="fas fa-pencil-alt"></i>
                                                                            </a>
                                                                        @endcan
                                                                        @can('edit debit note')
                                                                            <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$debitNote->id}}').submit();">
                                                                                <i class="fas fa-trash"></i>
                                                                            </a>
                                                                            {!! Form::open(['method' => 'DELETE', 'route' => array('bill.delete.debit.note', $debitNote->bill,$debitNote->id),'id'=>'delete-form-'.$debitNote->id]) !!}
                                                                            {!! Form::close() !!}
                                                                        @endcan
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
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
