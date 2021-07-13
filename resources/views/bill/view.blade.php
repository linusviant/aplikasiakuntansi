@extends('layouts.admin')
@section('page-title')
    {{__('Bill Detail')}}
@endsection
@push('script-page')
    <script>
        $(document).on('click', '#shipping', function () {
            var url = $(this).data('url');
            var is_display = $("#shipping").is(":checked");
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'is_display': is_display,
                },
                success: function (data) {
                    // console.log(data);
                }
            });
        })
    </script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Bill')}}</h1>
            <div class="section-header-breadcrumb">
                @if(\Auth::guard('vender')->check())
                    <div class="breadcrumb-item active"><a href="{{route('vender.dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item"><a href="{{route('vender.bill')}}">{{__('Bill')}}</a></div>
                @else
                    <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item"><a href="{{route('bill.index')}}">{{__('Bill')}}</a></div>
                @endif

                <div class="breadcrumb-item">{{ AUth::user()->billNumberFormat($bill->bill_id) }}</div>
            </div>
        </div>
        @can('send bill')
            @if($bill->status!=4)
                <div class="row">
                    <div class="col-12">
                        <div class="activities">
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                <span class="text-job text-primary"><h6>{{__('Create Bill')}}</h6>
                                </span>
                                        @can('edit invoice')
                                            <a href="{{ route('bill.edit',$bill->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Edit')}}
                                            </a>
                                        @endcan
                                    </div>
                                    <p>{{__('Status')}} : <a href="#">{{__('Created on ')}} {{\Auth::user()->dateFormat($bill->bill_date)}} </a></p>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Send Bill')}}</h6></span>

                                        @if($bill->status!=0)
                                            <p>{{__('Status')}} : <a href="#">{{__('Sent on')}} {{\Auth::user()->dateFormat($bill->send_date)}}  </a></p>
                                        @else
                                            @can('send bill')
                                                <a href="{{ route('bill.sent',$bill->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                    {{__('Mark Sent')}}
                                                </a>
                                            @endcan
                                            <p>{{__('Status')}} : <a href="#">{{__('Not Sent')}} </a></p>
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
                                        <span class="text-job text-primary"><h6>{{__('Get Paid')}}</h6></span>
                                    </div>
                                    @if($bill->status!=0)
                                        @can('create payment bill')
                                            <a href="#!" data-url="{{ route('bill.payment',$bill->id) }}" data-ajax-popup="true" data-title="{{__('Add Payment')}}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Add Payment')}}
                                            </a>
                                        @endcan
                                    @endif
                                    <p>{{__('Status')}} : <a href="#">{{__('Awaiting payment')}} </a></p>
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
                        @if($bill->status!=0)
                            <div class="row mb-10">
                                <div class="col-lg-12">
                                    <div class="text-right">
                                        @if(!empty($billPayment))
                                            <a href="#" data-url="{{ route('bill.debit.note',$bill->id) }}" data-ajax-popup="true" data-title="{{__('Add Debit Note')}}" data-toggle="tooltip" data-original-title="{{__('Debit Note')}}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Add Debit Note')}}
                                            </a>
                                        @endif
                                        <a href="{{ route('bill.sent',$bill->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                            {{__('Resend Bill')}}
                                        </a>
                                        <a href="{{ route('bill.pdf', Crypt::encrypt($bill->id))}}" target="_blank" class="btn btn-primary btn-action mr-1 float-right">
                                            {{__('Print')}}
                                        </a>
                                        <div class="form-group ">
                                            <div class="custom-control custom-checkbox shipping">
                                                <input class="custom-control-input" type="checkbox" name="shipping" id="shipping" value="{{$bill->shipping_display}}" {{($bill->shipping_display==1)?'checked':''}}   data-url="{{route('bill.shipping.print',$bill->id)}}">
                                                <label class="custom-control-label" for="shipping">{{__('Print shipping address in invoice ?')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="row mb-10">
                            <div class="col-lg-12">
                                <div class="text-right">
                                    <a href="#" data-url="{{route('vender.bill.send',$bill->id)}}" data-ajax-popup="true" data-title="{{__('Send Bill')}}" class="btn btn-primary btn-action mr-1 float-right">
                                        {{__('Send Mail')}}
                                    </a>
                                    <a href="{{ route('bill.pdf', Crypt::encrypt($bill->id))}}" target="_blank" class="btn btn-primary btn-action mr-1 float-right">
                                        {{__('Print')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>{{__('Bill')}}</h2>
                                <div class="invoice-number">{{ AUth::user()->billNumberFormat($bill->bill_id) }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="font-style">
                                        <strong>{{__('Billed To')}}:</strong><br>
                                        {{!empty($vendor->billing_name)?$vendor->billing_name:''}}<br>
                                        {{!empty($vendor->billing_phone)?$vendor->billing_phone:''}}<br>
                                        {{!empty($vendor->billing_address)?$vendor->billing_address:''}}<br>
                                        {{!empty($vendor->billing_zip)?$vendor->billing_zip:''}}<br>
                                        {{!empty($vendor->billing_city)?$vendor->billing_city:'' .', '}} {{!empty($vendor->billing_state)?$vendor->billing_state:'',', '}} {{!empty($vendor->billing_country)?$vendor->billing_country:''}}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>{{__('Shipped To')}}:</strong><br>
                                        {{!empty($vendor->shipping_name)?$vendor->shipping_name:''}}<br>
                                        {{!empty($vendor->shipping_phone)?$vendor->shipping_phone:''}}<br>
                                        {{!empty($vendor->shipping_address)?$vendor->shipping_address:''}}<br>
                                        {{!empty($vendor->shipping_zip)?$vendor->shipping_zip:''}}<br>
                                        {{!empty($vendor->shipping_city)?$vendor->shipping_city:'' .', '}} {{!empty($vendor->shipping_state)?$vendor->shipping_state:'',', '}} {{!empty($vendor->shipping_country)?$vendor->shipping_country:''}}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <address>
                                        <strong>{{__('Status')}}:</strong><br>
                                        @if($bill->status == 0)
                                            <span class="badge badge-primary">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 1)
                                            <span class="badge badge-warning">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 2)
                                            <span class="badge badge-danger">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 3)
                                            <span class="badge badge-info">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @elseif($bill->status == 4)
                                            <span class="badge badge-success">{{ __(\App\Invoice::$statues[$bill->status]) }}</span>
                                        @endif
                                    </address>
                                </div>
                                <div class="col-md-4 text-md-center">
                                    <address>
                                        <strong>{{__('Issue Date')}} :</strong><br>
                                        {{\Auth::user()->dateFormat($bill->bill_date)}}<br><br>
                                    </address>
                                </div>
                                <div class="col-md-4 text-md-right">
                                    <address>
                                        <strong>{{__('Due Date')}} :</strong><br>
                                        {{\Auth::user()->dateFormat($bill->due_date)}}<br><br>
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
                                        @if($bill->discount_apply==1)
                                            <th class="text-center">{{__('Discount')}}</th>
                                        @endif
                                        <th class="text-right">{{__('Price')}}</th>
                                    </tr>

                                    @foreach($iteams as $key =>$iteam)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{!empty($iteam->product())?$iteam->product()->name:''}}</td>
                                            <td class="text-center">{{$iteam->quantity}}</td>
                                            <td class="text-center">{{$iteam->tax}}</td>
                                            @if($bill->discount_apply==1)
                                                <td class="text-center">{{\Auth::user()->priceFormat($iteam->discount)}}</td>
                                            @endif
                                            <td class="text-right">{{\Auth::user()->priceFormat($iteam->price)}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-3">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Tax')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat($bill->getTotalTax())}}</div>
                                    </div>
                                </div>
                                @if($bill->discount_apply==1)
                                    <div class="col-lg-3 text-center">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">{{__('Discount')}}</div>
                                            <div class="invoice-detail-value">{{\Auth::user()->priceFormat($bill->getTotalDiscount())}}</div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-3 text-center">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Sub Total')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat($bill->getSubTotal())}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Total')}}</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">{{\Auth::user()->priceFormat($bill->getTotal())}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">

                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Paid')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat($bill->getTotal()-$bill->getDue()-($bill->billTotalDebitNote()))}}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Debit Note')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat(($bill->billTotalDebitNote()))}}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Due')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat($bill->getDue())}}</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">{{__('Payment Summary')}}</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th>{{__('Date')}}</th>
                                        <th class="text-center">{{__('Amount')}}</th>
                                        <th class="text-center">{{__('Account')}}</th>
                                        <th class="text-center">{{__('Payment')}}</th>
                                        <th class="text-center">{{__('Reference')}}</th>
                                        <th class="text-center">{{__('Description')}}</th>
                                        @can('delete payment bill')
                                            <th class="text-right">{{__('Action')}}</th>
                                        @endcan
                                    </tr>
                                    @foreach($bill->payments as $key =>$payment)
                                        <tr>
                                            <td>{{\Auth::user()->dateFormat($payment->date)}}</td>
                                            <td class="text-center">{{\Auth::user()->priceFormat($payment->amount)}}</td>
                                            <td class="text-center">{{!empty($payment->bankAccount)?$payment->bankAccount->bank_name.' '.$payment->bankAccount->holder_name:''}}</td>
                                            <td class="text-center">{{!empty($payment->paymentMethod)?$payment->paymentMethod->name:''}}</td>
                                            <td class="text-center">{{$payment->reference}}</td>
                                            <td class="text-center">{{$payment->description}}</td>
                                            <td class="text-right">
                                                @can('delete bill product')
                                                    <a href="#!" class="btn btn-danger btn-action" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$payment->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'post', 'route' => ['bill.payment.destroy',$bill->id,$payment->id],'id'=>'delete-form-'.$payment->id]) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">{{__('Debit Note Summary')}}</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th>{{__('Date')}}</th>
                                        <th class="text-center">{{__('Amount')}}</th>
                                        <th class="text-center">{{__('Description')}}</th>
                                        @if(Gate::check('edit debit note') || Gate::check('delete debit note'))
                                            <th class="text-right">{{__('Action')}}</th>
                                        @endif
                                    </tr>
                                    @foreach($bill->debitNote as $key =>$debitNote)
                                        <tr>
                                            <td>{{\Auth::user()->dateFormat($debitNote->date)}}</td>
                                            <td class="text-center">{{\Auth::user()->priceFormat($debitNote->amount)}}</td>
                                            <td class="text-center">{{$debitNote->description}}</td>
                                            <td class="text-right">
                                                @can('edit debit note')
                                                    <a data-url="{{ route('bill.edit.debit.note',[$debitNote->bill,$debitNote->id]) }}" data-ajax-popup="true" data-title="{{__('Add Debit Note')}}" data-toggle="tooltip" data-original-title="{{__('Debit Note')}}" href="#" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('delete debit note')
                                                    <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$debitNote->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => array('bill.delete.debit.note', $debitNote->bill,$debitNote->id),'id'=>'delete-form-'.$debitNote->id]) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
