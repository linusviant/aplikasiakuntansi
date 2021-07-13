@extends('layouts.admin')
@push('script-page')
    <script>
        $(document).on('click', '.code', function () {
            var type = $(this).val();
            if (type == 'manual') {
                $('#manual').removeClass('d-none');
                $('#manual').addClass('d-block');
                $('#auto').removeClass('d-block');
                $('#auto').addClass('d-none');
            } else {
                $('#auto').removeClass('d-none');
                $('#auto').addClass('d-block');
                $('#manual').removeClass('d-block');
                $('#manual').addClass('d-none');
            }
        });

        $(document).on('click', '#code-generate', function () {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#auto-code').val(result);
        });
    </script>
@endpush
@section('page-title')
    {{__('Coupon')}}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Coupon')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Coupon')}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <h4>{{__('Manage Coupon')}}</h4>
                            @can('create coupon')
                                <a href="#" data-url="{{ route('coupons.create') }}" data-ajax-popup="true" data-title="{{__('Create New Coupon')}}" class="btn btn-icon icon-left btn-primary">
                                    <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                    <span class="btn-inner--text"> {{__('Create')}}</span>
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body p-10">
                        <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-flush" id="dataTable">
                                            <thead class="thead-light">
                                            <tr>

                                                <th> {{__('Name')}}</th>
                                                <th> {{__('Code')}}</th>
                                                <th> {{__('Discount (%)')}}</th>
                                                <th> {{__('Limit')}}</th>
                                                <th> {{__('Used')}}</th>
                                                <th class="text-right"> {{__('Action')}}</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach ($coupons as $coupon)

                                                <tr class="font-style">
                                                    <td>{{ $coupon->name }}</td>
                                                    <td>{{ $coupon->code }}</td>
                                                    <td>{{ $coupon->discount }}</td>
                                                    <td>{{ $coupon->limit }}</td>
                                                    <td>{{ $coupon->used_coupon() }}</td>
                                                    <td class="action text-right">

                                                        <a href="{{ route('coupons.show',$coupon->id) }}" class="btn btn-info btn-action mr-1">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        @can('edit coupon')
                                                            <a href="#!" class="btn btn-primary btn-action mr-1" data-url="{{ route('coupons.edit',$coupon->id) }}" data-ajax-popup="true" data-title="{{__('Edit Coupon')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                        @endcan
                                                        @can('delete coupon')
                                                            <a href="#" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$coupon->id}}').submit();">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id],'id'=>'delete-form-'.$coupon->id]) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </td>
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
    </section>
@endsection
