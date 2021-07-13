@extends('layouts.admin')
@push('script-page')

@endpush
@section('page-title')
    {{__('Coupon Detail')}}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Coupon')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('coupons.index')}}">{{__('Coupon')}}</a></div>
                <div class="breadcrumb-item">{{__('Coupon Detail')}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <h4>{{__('Manage Coupon Detail')}}</h4>
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
                                                <th> {{__('User')}}</th>
                                                <th> {{__('Date')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($userCoupons as $userCoupon)
                                                <tr class="font-style">
                                                    <td>{{ !empty($userCoupon->userDetail)?$userCoupon->userDetail->name:'' }}</td>
                                                    <td>{{ $userCoupon->created_at }}</td>
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
