@extends('layouts.admin')
@section('page-title')
    {{__('Invoice Detail')}}
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
            <h1>{{__('Invoice')}}</h1>
            <div class="section-header-breadcrumb">
                @if(\Auth::guard('customer')->check())
                    <div class="breadcrumb-item active"><a href="{{route('customer.dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item"><a href="{{route('customer.invoice')}}">{{__('Invoice')}}</a></div>
                @else
                    <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                    <div class="breadcrumb-item"><a href="{{route('invoice.index')}}">{{__('Invoice')}}</a></div>
                @endif
                <div class="breadcrumb-item">{{\Auth::user()->invoiceNumberFormat($invoice->invoice_id)}}</div>
            </div>
        </div>
        @can('send invoice')
            @if($invoice->status!=4)
                <div class="row">
                    <div class="col-12">
                        <div class="activities">
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Create Invoice')}}</h6>
                                        </span>
                                        @can('edit invoice')
                                            <a href="{{ route('invoice.edit',$invoice->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Edit')}}
                                            </a>
                                        @endcan
                                    </div>
                                    <p>{{__('Status')}} : <a href="#">{{__('Created on ')}} {{\Auth::user()->dateFormat($invoice->issue_date)}} </a></p>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job text-primary"><h6>{{__('Send Invoice')}}</h6></span>
                                        @if($invoice->status!=0)
                                            <p>{{__('Status')}} : <a href="#">{{__('Sent on')}} {{\Auth::user()->dateFormat($invoice->send_date)}}  </a></p>
                                        @else
                                            @can('send invoice')
                                                <a href="{{ route('invoice.sent',$invoice->id) }}" class="btn btn-primary btn-action mr-1 float-right">
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
                                    @if($invoice->status!=0)
                                        @can('create payment invoice')
                                            <a href="#!" data-url="{{ route('invoice.payment',$invoice->id) }}" data-ajax-popup="true" data-title="{{__('Add Payment')}}" class="btn btn-primary btn-action mr-1 float-right">
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
                        @if($invoice->status!=0)
                            <div class="row mb-10">
                                <div class="col-lg-12">
                                    <div class="text-right">
                                        @if(!empty($invoicePayment))
                                            <a href="#" data-url="{{ route('invoice.credit.note',$invoice->id) }}" data-ajax-popup="true" data-title="{{__('Add Credit Note')}}" data-toggle="tooltip" data-original-title="{{__('Credit Note')}}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Add Credit Note')}}
                                            </a>
                                        @endif
                                        @if($invoice->status!=4)
                                            <a href="{{ route('invoice.payment.reminder',$invoice->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                                {{__('Payment Reminder')}}
                                            </a>
                                        @endif
                                        <a href="{{ route('invoice.sent',$invoice->id) }}" class="btn btn-primary btn-action mr-1 float-right">
                                            {{__('Resend Invoice')}}
                                        </a>
                                        <a href="{{ route('invoice.pdf', Crypt::encrypt($invoice->id))}}" target="_blank" class="btn btn-primary btn-action mr-1 float-right">
                                            {{__('Print')}}
                                        </a>
                                    </div>
                                    <div class="form-group ">
                                        <div class="custom-control custom-checkbox shipping">
                                            <input class="custom-control-input" type="checkbox" name="shipping" id="shipping" value="{{$invoice->shipping_display}}" {{($invoice->shipping_display==1)?'checked':''}}   data-url="{{route('invoice.shipping.print',$invoice->id)}}">
                                            <label class="custom-control-label" for="shipping">{{__('Print shipping address in invoice ?')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="row mb-10">
                            <div class="col-lg-12">
                                <div class="text-right">
                                    <a href="#" data-url="{{route('customer.invoice.send',$invoice->id)}}" data-ajax-popup="true" data-title="{{__('Send Invoice')}}" class="btn btn-primary btn-action mr-1 float-right">
                                        {{__('Send Mail')}}
                                    </a>
                                    <a href="{{ route('invoice.pdf', Crypt::encrypt($invoice->id))}}" target="_blank" class="btn btn-primary btn-action mr-1 float-right">
                                        {{__('Print')}}
                                    </a>

                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>{{__('Invoice')}}</h2>
                                <div class="invoice-number">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}</div>
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
                                        @if($invoice->status == 0)
                                            <span class="badge badge-primary">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 1)
                                            <span class="badge badge-warning">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 2)
                                            <span class="badge badge-danger">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 3)
                                            <span class="badge badge-info">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 4)
                                            <span class="badge badge-success">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @endif
                                    </address>
                                </div>
                                <div class="col-md-4 text-md-center">
                                    <address>
                                        <strong>{{__('Issue Date')}} :</strong><br>
                                        {{\Auth::user()->dateFormat($invoice->issue_date)}}<br><br>
                                    </address>
                                </div>
                                <div class="col-md-4 text-md-right">
                                    <address>
                                        <strong>{{__('Due Date')}} :</strong><br>
                                        {{\Auth::user()->dateFormat($invoice->due_date)}}<br><br>
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
                                        @if($invoice->discount_apply==1)
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
                                            @if($invoice->discount_apply==1)
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
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat($invoice->getTotalTax())}}</div>
                                    </div>
                                </div>
                                @if($invoice->discount_apply==1)
                                    <div class="col-lg-3 text-center">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">{{__('Discount')}}</div>
                                            <div class="invoice-detail-value">{{\Auth::user()->priceFormat($invoice->getTotalDiscount())}}</div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-3 text-center">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Sub Total')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat($invoice->getSubTotal())}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Total')}}</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">{{\Auth::user()->priceFormat($invoice->getTotal())}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">

                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Paid')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat(($invoice->getTotal()-$invoice->getDue())-($invoice->invoiceTotalCreditNote()))}}</div>
                                    </div>

                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Credit Note')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat(($invoice->invoiceTotalCreditNote()))}}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{__('Due')}}</div>
                                        <div class="invoice-detail-value">{{\Auth::user()->priceFormat($invoice->getDue())}}</div>
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
                                        @can('delete payment invoice')
                                            <th class="text-right">{{__('Action')}}</th>
                                        @endcan
                                    </tr>
                                    @foreach($invoice->payments as $key =>$payment)
                                        <tr>
                                            <td>{{\Auth::user()->dateFormat($payment->date)}}</td>
                                            <td class="text-center">{{\Auth::user()->priceFormat($payment->amount)}}</td>
                                            <td class="text-center">{{!empty($payment->bankAccount)?$payment->bankAccount->bank_name.' '.$payment->bankAccount->holder_name:''}}</td>
                                            <td class="text-center">{{!empty($payment->paymentMethod)?$payment->paymentMethod->name:''}}</td>
                                            <td class="text-center">{{$payment->reference}}</td>
                                            <td class="text-center">{{$payment->description}}</td>
                                            <td class="text-right">
                                                @can('delete invoice product')
                                                    <a href="#!" class="btn btn-danger btn-action" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$payment->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'post', 'route' => ['invoice.payment.destroy',$invoice->id,$payment->id],'id'=>'delete-form-'.$payment->id]) !!}
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
                            <div class="section-title">{{__('Credit Note Summary')}}</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th>{{__('Date')}}</th>
                                        <th class="text-center">{{__('Amount')}}</th>
                                        <th class="text-center">{{__('Description')}}</th>
                                        @if(Gate::check('edit credit note') || Gate::check('delete credit note'))
                                            <th class="text-right">{{__('Action')}}</th>
                                        @endif
                                    </tr>
                                    @foreach($invoice->creditNote as $key =>$creditNote)
                                        <tr>
                                            <td>{{\Auth::user()->dateFormat($creditNote->date)}}</td>
                                            <td class="text-center">{{\Auth::user()->priceFormat($creditNote->amount)}}</td>
                                            <td class="text-center">{{$creditNote->description}}</td>
                                            <td class="text-right">
                                                @can('edit credit note')
                                                    <a data-url="{{ route('invoice.edit.credit.note',[$creditNote->invoice,$creditNote->id]) }}" data-ajax-popup="true" data-title="{{__('Add Credit Note')}}" data-toggle="tooltip" data-original-title="{{__('Credit Note')}}" href="#" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('delete credit note')
                                                    <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$creditNote->id}}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => array('invoice.delete.credit.note', $creditNote->invoice,$creditNote->id),'id'=>'delete-form-'.$creditNote->id]) !!}
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
