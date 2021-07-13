@extends('layouts.admin')
@section('page-title')
    {{__('Proposal Detail')}}
@endsection
@push('script-page')
    <script>

        $(document).on('change', '.status_change', function () {
            var status = this.value;
            var url = $(this).data('url');
            $.ajax({
                url: url + '?status=' + status,
                type: 'GET',
                cache: false,
                success: function (data) {

                },
            });
        });
    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Proposal')}}</h1>
            <div class="section-header-breadcrumb">
                @if(\Auth::guard('customer')->check())
                    <div class="breadcrumb-item active"><a href="{{route('customer.dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item"><a href="{{route('customer.proposal')}}">{{__('Proposal')}}</a></div>
                @else
                    <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item"><a href="{{route('proposal.index')}}">{{__('Proposal')}}</a></div>
                @endif
                <div class="breadcrumb-item">{{\Auth::user()->proposalNumberFormat($proposal->proposal_id)}}</div>
            </div>
        </div>
        @can('send proposal')
            @if($proposal->status!=4)
                <div class="row">
                    <div class="col-12">
                        <div class="activities">
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Create Proposal')}}</h6>
                                        </span>
                                        @can('edit proposal')
                                            <a href="{{ route('proposal.edit',$proposal->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Edit')}}
                                            </a>
                                        @endcan
                                    </div>
                                    <p><a href="#">{{__('Created on ')}} {{\Auth::user()->dateFormat($proposal->issue_date)}} </a></p>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Send Proposal')}}</h6></span>
                                        @if($proposal->status!=0)
                                            <p><a href="#">{{__('Sent on')}} {{\Auth::user()->dateFormat($proposal->send_date)}}  </a></p>
                                        @else
                                            @can('send proposal')
                                                <a href="{{ route('proposal.sent',$proposal->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                    {{__('Mark Sent')}}
                                                </a>
                                            @endcan
                                            <p><a href="#">{{__('Not Sent')}} </a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="far fa-money-bill-alt"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Proposal Status')}}</h6></span>
                                    </div>

                                    <a href="#!" class="float-right">
                                        <select class="form-control status_change font-style selectric" name="status" data-url="{{route('proposal.status.change',$proposal->id)}}">
                                            @foreach($status as $k=>$val)
                                                <option value="{{$k}}" {{($proposal->status==$k)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </a>
                                    @if($proposal->status == 0)
                                        <span class="badge badge-primary">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                    @elseif($proposal->status == 1)
                                        <span class="badge badge-warning">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                    @elseif($proposal->status == 2)
                                        <span class="badge badge-info">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                    @elseif($proposal->status == 3)
                                        <span class="badge badge-danger">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                    @elseif($proposal->status == 4)
                                        <span class="badge badge-success">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endcan
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    @if(\Auth::user()->type=='company')
                        @if($proposal->status!=0)
                            <div class="row mb-10">
                                <div class="col-lg-12">
                                    <div class="text-right">
                                        <a href="{{ route('proposal.sent',$proposal->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                            {{__('Resend Proposal')}}
                                        </a>
                                        <a href="{{ route('proposal.pdf', Crypt::encrypt($proposal->id))}}" target="_blank" class="btn btn-primary btn-action mr-1 float-right">
                                            {{__('Print')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="row mb-10">
                            <div class="col-lg-12">
                                <div class="text-right">

                                    <a href="{{ route('proposal.pdf', Crypt::encrypt($proposal->id))}}" target="_blank" class="btn btn-primary btn-action mr-1 float-right">
                                        {{__('Print')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>{{__('Proposal')}}</h2>
                                <div class="invoice-number">{{ AUth::user()->proposalNumberFormat($proposal->proposal_id) }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="font-style">
                                        <strong>{{__('Billed To')}}:</strong><br>
                                        {{!empty($customer->billing_name)?$customer->billing_name:''}}<br>
                                        {{!empty($customer->billing_phone)?$customer->billing_phone:''}}<br>
                                        {{!empty($customer->billing_address)?$customer->billing_address:''}}<br>
                                        {{!empty($customer->billing_zip)?$customer->billing_zip:''}}<br>
                                        {{!empty($customer->billing_city)?$customer->billing_city:'' .', '}} {{!empty($customer->billing_state)?$customer->billing_state:'',', '}} {{!empty($customer->billing_country)?$customer->billing_country:''}}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>{{__('Shipped To')}}:</strong><br>
                                        {{!empty($customer->shipping_name)?$customer->shipping_name:''}}<br>
                                        {{!empty($customer->shipping_phone)?$customer->shipping_phone:''}}<br>
                                        {{!empty($customer->shipping_address)?$customer->shipping_address:''}}<br>
                                        {{!empty($customer->shipping_zip)?$customer->shipping_zip:''}}<br>
                                        {{!empty($customer->shipping_city)?$customer->shipping_city:'' . ', '}} {{!empty($customer->shipping_state)?$customer->shipping_state:'' .', '}},{{!empty($customer->shipping_country)?$customer->shipping_country:''}}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <address>
                                        <strong>{{__('Status')}}:</strong><br>
                                        @if($proposal->status == 0)
                                            <span class="badge badge-primary">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                        @elseif($proposal->status == 1)
                                            <span class="badge badge-warning">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                        @elseif($proposal->status == 2)
                                            <span class="badge badge-info">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                        @elseif($proposal->status == 3)
                                            <span class="badge badge-danger">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                        @elseif($proposal->status == 4)
                                            <span class="badge badge-success">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                        @endif
                                    </address>
                                </div>
                                <div class="col-md-8 text-md-right">
                                    <address>
                                        <strong>{{__('Issue Date')}} :</strong><br>
                                        {{\Auth::user()->dateFormat($proposal->issue_date)}}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">{{__('Product Summary')}}</div>
                            <p class="section-lead">{{__('All items here cannot be deleted.')}}</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>{{__('Product')}}</th>
                                        <th class="text-center">{{__('Quantity')}}</th>
                                        <th class="text-center">{{__('Tax')}} (%)</th>
                                        @if($proposal->discount_apply==1)
                                            <th class="text-center">{{__('Discount')}}</th>
                                        @endif
                                        <th class="text-right">{{__('Price')}}</th>
                                    </tr>
                                    @foreach($iteams as $key =>$iteam)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{!empty($iteam->product)?$iteam->product->name:''}}</td>
                                            <td class="text-center">{{$iteam->quantity}}</td>
                                            <td class="text-center">{{$iteam->tax}}</td>
                                            @if($proposal->discount_apply==1)
                                                <td class="text-center">{{\Auth::user()->priceFormat($iteam->discount)}}</td>
                                            @endif
                                            <td class="text-right">{{\Auth::user()->priceFormat($iteam->price)}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-3">
                                    <div class="proposal-detail-item">
                                        <div class="proposal-detail-name">{{__('Tax')}}</div>
                                        <div class="proposal-detail-value">{{\Auth::user()->priceFormat($proposal->getTotalTax())}}</div>
                                    </div>
                                </div>
                                @if($proposal->discount_apply==1)
                                    <div class="col-lg-3 text-center">
                                        <div class="proposal-detail-item">
                                            <div class="proposal-detail-name">{{__('Discount')}}</div>
                                            <div class="proposal-detail-value">{{\Auth::user()->priceFormat($proposal->getTotalDiscount())}}</div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-3 text-center">
                                    <div class="proposal-detail-item">
                                        <div class="proposal-detail-name">{{__('Sub Total')}}</div>
                                        <div class="proposal-detail-value">{{\Auth::user()->priceFormat($proposal->getSubTotal())}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-right">
                                    <div class="proposal-detail-item">
                                        <div class="proposal-detail-name">{{__('Total')}}</div>
                                        <div class="proposal-detail-value proposal-detail-value-lg">{{\Auth::user()->priceFormat($proposal->getTotal())}}</div>
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
