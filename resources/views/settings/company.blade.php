@extends('layouts.admin')
@php
    $logo=asset(Storage::url('logo/'));
    $company_logo=Utility::getValByName('company_logo');
    $company_small_logo=Utility::getValByName('company_small_logo');
    $company_favicon=Utility::getValByName('company_favicon');

@endphp
@section('page-title')
    {{__('Settings')}}
@endsection
@push('css-page')
    <link href="{{ asset('assets/modules/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('script-page')
    <script>
        $(document).on("change", "select[name='invoice_template'], input[name='invoice_color']", function () {
            var template = $("select[name='invoice_template']").val();
            var color = $("input[name='invoice_color']:checked").val();
            $('#invoice_frame').attr('src', '{{url('/invoices/preview')}}/' + template + '/' + color);
        });

        $(document).on("change", "select[name='proposal_template'], input[name='proposal_color']", function () {
            var template = $("select[name='proposal_template']").val();
            var color = $("input[name='proposal_color']:checked").val();
            $('#proposal_frame').attr('src', '{{url('/proposal/preview')}}/' + template + '/' + color);
        });

        $(document).on("change", "select[name='bill_template'], input[name='bill_color']", function () {
            var template = $("select[name='bill_template']").val();
            var color = $("input[name='bill_color']:checked").val();
            $('#bill_frame').attr('src', '{{url('/bill/preview')}}/' + template + '/' + color);
        });
    </script>
    <script src="{{ asset('assets/modules/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Settings')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Settings')}}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between w-100">
                            <h4>{{__('Settings')}}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="setting-tab">
                            <ul class="nav nav-pills mb-3" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="contact-tab4" data-toggle="tab" href="#business-setting" role="tab" aria-controls="" aria-selected="false">{{__('Business Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#system-setting" role="tab" aria-controls="" aria-selected="false">{{__('System Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#company-setting" role="tab" aria-controls="" aria-selected="false">{{__('Company Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab5" data-toggle="tab" href="#proposal-template-setting" role="tab" aria-controls="" aria-selected="false">{{__('Proposal Print Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab5" data-toggle="tab" href="#template-setting" role="tab" aria-controls="" aria-selected="false">{{__('Invoice Print Setting')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab5" data-toggle="tab" href="#bill-template-setting" role="tab" aria-controls="" aria-selected="false">{{__('Bill Print Setting')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade fade show active" id="business-setting" role="tabpanel" aria-labelledby="profile-tab3">
                                    <div class="company-setting-wrap">
                                        {{Form::model($settings,array('route'=>'business.setting','method'=>'POST','enctype' => "multipart/form-data"))}}
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h5>{{__('Logo')}}</h5>
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail h-150">
                                                                <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail thumbnail-h3"></div>
                                                            <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="company_logo" id="logo">
                                                            </span>
                                                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                            </div>
                                                        </div>
                                                        <p class="mt-3 text-primary"> {{__('These Logo will appear on Bill and Invoice as well.')}}</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h5>{{__('Small Logo')}}</h5>
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail h-150">
                                                                <img src="{{$logo.'/'.(isset($company_small_logo) && !empty($company_small_logo)?$company_small_logo:'small_logo.png')}}" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail thumbnail-h3"></div>
                                                            <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="company_small_logo" id="company_small_logo">
                                                            </span>
                                                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h5>{{__('Favicon')}}</h5>
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail h-150">
                                                                <img src="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail thumbnail-h3"></div>
                                                            <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new"> {{__('Select image')}} </span>
                                                                <span class="fileinput-exists"> {{__('Change')}} </span>
                                                                <input type="hidden">
                                                                <input type="file" name="company_favicon" id="company_favicon">
                                                            </span>
                                                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> {{__('Remove')}} </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @error('logo')
                                                    <span class="invalid-logo" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                     </span>
                                                    @enderror
                                                </div>
                                                <div class="row mt-20">
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('title_text',__('Title Text')) }}
                                                        {{Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))}}
                                                        @error('title_text')
                                                        <span class="invalid-title_text" role="alert">
                                                             <strong class="text-danger">{{ $message }}</strong>
                                                             </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                                <div class="tab-pane fade fade" id="system-setting" role="tabpanel" aria-labelledby="profile-tab3">
                                    <div class="company-setting-wrap">
                                        {{Form::model($settings,array('route'=>'system.settings','method'=>'post'))}}
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    {{Form::label('site_currency',__('Currency *')) }}
                                                    {{Form::text('site_currency',null,array('class'=>'form-control font-style'))}}
                                                    @error('site_currency')
                                                    <span class="invalid-site_currency" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('site_currency_symbol',__('Currency Symbol *')) }}
                                                    {{Form::text('site_currency_symbol',null,array('class'=>'form-control'))}}
                                                    @error('site_currency_symbol')
                                                    <span class="invalid-site_currency_symbol" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="example3cols3Input">{{__('Currency Symbol Position')}}</label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="custom-control custom-radio mb-3">

                                                                    <input type="radio" id="customRadio5" name="site_currency_symbol_position" value="pre" class="custom-control-input" @if(@$settings['site_currency_symbol_position'] == 'pre') checked @endif>
                                                                    <label class="custom-control-label" for="customRadio5">{{__('Pre')}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="custom-control custom-radio mb-3">
                                                                    <input type="radio" id="customRadio6" name="site_currency_symbol_position" value="post" class="custom-control-input" @if(@$settings['site_currency_symbol_position'] == 'post') checked @endif>
                                                                    <label class="custom-control-label" for="customRadio6">{{__('Post')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="site_date_format" class="form-control-label">{{__('Date Format')}}</label>
                                                    <select type="text" name="site_date_format" class="form-control selectric" id="site_date_format">
                                                        <option value="M j, Y" @if(@$settings['site_date_format'] == 'M j, Y') selected="selected" @endif>Jan 1,2015</option>
                                                        <option value="d-m-Y" @if(@$settings['site_date_format'] == 'd-m-Y') selected="selected" @endif>d-m-y</option>
                                                        <option value="m-d-Y" @if(@$settings['site_date_format'] == 'm-d-Y') selected="selected" @endif>m-d-y</option>
                                                        <option value="Y-m-d" @if(@$settings['site_date_format'] == 'Y-m-d') selected="selected" @endif>y-m-d</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="site_time_format" class="form-control-label">{{__('Time Format')}}</label>
                                                    <select type="text" name="site_time_format" class="form-control selectric" id="site_time_format">
                                                        <option value="g:i A" @if(@$settings['site_time_format'] == 'g:i A') selected="selected" @endif>10:30 PM</option>
                                                        <option value="g:i a" @if(@$settings['site_time_format'] == 'g:i a') selected="selected" @endif>10:30 pm</option>
                                                        <option value="H:i" @if(@$settings['site_time_format'] == 'H:i') selected="selected" @endif>22:30</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('invoice_prefix',__('Invoice Prefix')) }}
                                                    {{Form::text('invoice_prefix',null,array('class'=>'form-control'))}}
                                                    @error('invoice_prefix')
                                                    <span class="invalid-invoice_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('proposal_prefix',__('Proposal Prefix')) }}
                                                    {{Form::text('proposal_prefix',null,array('class'=>'form-control'))}}
                                                    @error('proposal_prefix')
                                                    <span class="invalid-proposal_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('bill_prefix',__('Bill Prefix')) }}
                                                    {{Form::text('bill_prefix',null,array('class'=>'form-control'))}}
                                                    @error('bill_prefix')
                                                    <span class="invalid-bill_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('customer_prefix',__('Customer Prefix')) }}
                                                    {{Form::text('customer_prefix',null,array('class'=>'form-control'))}}
                                                    @error('customer_prefix')
                                                    <span class="invalid-customer_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('vender_prefix',__('Vender Prefix')) }}
                                                    {{Form::text('vender_prefix',null,array('class'=>'form-control'))}}
                                                    @error('vender_prefix')
                                                    <span class="invalid-vender_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('invoice_color',__('Invoice/Bill Color Theme')) }}
                                                    {{Form::text('invoice_color',null,array('class'=>'form-control jscolor'))}}
                                                    @error('invoice_color')
                                                    <span class="invalid-invoice_color" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('footer_title',__('Invoice/Bill Footer Title')) }}
                                                    {{Form::text('footer_title',null,array('class'=>'form-control'))}}
                                                    @error('footer_title')
                                                    <span class="invalid-footer_title" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {{Form::label('footer_notes',__('Invoice/Bill Footer Notes')) }}
                                                    {{Form::text('footer_notes',null,array('class'=>'form-control'))}}
                                                    @error('footer_notes')
                                                    <span class="invalid-footer_notes" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                        </div>
                                        {{Form::close()}}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="company-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="email-setting-wrap">
                                        <div class="row">
                                            {{Form::model($settings,array('route'=>'company.settings','method'=>'post'))}}
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_name *',__('Company Name *')) }}
                                                        {{Form::text('company_name',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_name')
                                                        <span class="invalid-company_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_address',__('Address')) }}
                                                        {{Form::text('company_address',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_address')
                                                        <span class="invalid-company_address" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_city',__('City')) }}
                                                        {{Form::text('company_city',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_city')
                                                        <span class="invalid-company_city" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_state',__('State')) }}
                                                        {{Form::text('company_state',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_state')
                                                        <span class="invalid-company_state" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_zipcode',__('Zip/Post Code')) }}
                                                        {{Form::text('company_zipcode',null,array('class'=>'form-control'))}}
                                                        @error('company_zipcode')
                                                        <span class="invalid-company_zipcode" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group  col-md-6">
                                                        {{Form::label('company_country',__('Country')) }}
                                                        {{Form::text('company_country',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_country')
                                                        <span class="invalid-company_country" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_telephone',__('Telephone')) }}
                                                        {{Form::text('company_telephone',null,array('class'=>'form-control'))}}
                                                        @error('company_telephone')
                                                        <span class="invalid-company_telephone" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_email',__('System Email *')) }}
                                                        {{Form::text('company_email',null,array('class'=>'form-control'))}}
                                                        @error('company_email')
                                                        <span class="invalid-company_email" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('company_email_from_name',__('Email (From Name) *')) }}
                                                        {{Form::text('company_email_from_name',null,array('class'=>'form-control font-style'))}}
                                                        @error('company_email_from_name')
                                                        <span class="invalid-company_email_from_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('registration_number',__('Company Registration Number *')) }}
                                                        {{Form::text('registration_number',null,array('class'=>'form-control'))}}
                                                        @error('registration_number')
                                                        <span class="invalid-registration_number" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        {{Form::label('vat_number',__('VAT Number *')) }}
                                                        {{Form::text('vat_number',null,array('class'=>'form-control'))}}
                                                        @error('vat_number')
                                                            <span class="invalid-vat_number" role="alert">
                                                                <strong class="text-danger">{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-right">
                                                {{Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))}}
                                            </div>
                                            {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="proposal-template-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <form id="setting-form" method="post" action="{{route('proposal.template.setting')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="address">{{__('Proposal Template')}}</label>
                                                        <select class="form-control" name="proposal_template">
                                                            @foreach(Utility::templateData()['templates'] as $key => $template)
                                                                <option value="{{$key}}" {{(isset($settings['proposal_template']) && $settings['proposal_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Color Input')}}</label>
                                                        <div class="row gutters-xs">
                                                            @foreach(Utility::templateData()['colors'] as $key => $color)
                                                                <div class="col-auto">
                                                                    <label class="colorinput">
                                                                        <input name="proposal_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['proposal_color']) && $settings['proposal_color'] == $color) ? 'checked' : ''}}>
                                                                        <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">
                                                        {{__('Save')}}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-10">
                                                @if(isset($settings['proposal_template']) && isset($settings['proposal_color']))
                                                    <iframe id="proposal_frame" class="w-100" height="100%" frameborder="0" src="{{route('proposal.preview',[$settings['proposal_template'],$settings['proposal_color']])}}"></iframe>
                                                @else
                                                    <iframe id="proposal_frame" class="w-100" height="100%" frameborder="0" src="{{route('proposal.preview',['template1','fffff'])}}"></iframe>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="template-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <form id="setting-form" method="post" action="{{route('template.setting')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="address">{{__('Invoice Template')}}</label>
                                                        <select class="form-control" name="invoice_template">
                                                            @foreach(Utility::templateData()['templates'] as $key => $template)
                                                                <option value="{{$key}}" {{(isset($settings['invoice_template']) && $settings['invoice_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Color Input')}}</label>
                                                        <div class="row gutters-xs">
                                                            @foreach(Utility::templateData()['colors'] as $key => $color)
                                                                <div class="col-auto">
                                                                    <label class="colorinput">
                                                                        <input name="invoice_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['invoice_color']) && $settings['invoice_color'] == $color) ? 'checked' : ''}}>
                                                                        <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">
                                                        {{__('Save')}}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-10">
                                                @if(isset($settings['invoice_template']) && isset($settings['invoice_color']))
                                                    <iframe id="invoice_frame" class="w-100" height="100%" frameborder="0" src="{{route('invoice.preview',[$settings['invoice_template'],$settings['invoice_color']])}}"></iframe>
                                                @else
                                                    <iframe id="invoice_frame" class="w-100" height="100%" frameborder="0" src="{{route('invoice.preview',['template1','fffff'])}}"></iframe>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bill-template-setting" role="tabpanel" aria-labelledby="contact-tab4">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <form id="setting-form" method="post" action="{{route('bill.template.setting')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="address">{{__('Bill Template')}}</label>
                                                        <select class="form-control" name="bill_template">
                                                            @foreach(Utility::templateData()['templates'] as $key => $template)
                                                                <option value="{{$key}}" {{(isset($settings['bill_template']) && $settings['bill_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Color Input')}}</label>
                                                        <div class="row gutters-xs">
                                                            @foreach(Utility::templateData()['colors'] as $key => $color)
                                                                <div class="col-auto">
                                                                    <label class="colorinput">
                                                                        <input name="bill_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['bill_color']) && $settings['bill_color'] == $color) ? 'checked' : ''}}>
                                                                        <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">
                                                        {{__('Save')}}
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-10">
                                                @if(isset($settings['bill_template']) && isset($settings['bill_color']))
                                                    <iframe id="bill_frame" class="w-100" height="100%" frameborder="0" src="{{route('bill.preview',[$settings['bill_template'],$settings['bill_color']])}}"></iframe>
                                                @else
                                                    <iframe id="bill_frame" class="w-100" height="100%" frameborder="0" src="{{route('bill.preview',['template1','fffff'])}}"></iframe>
                                                @endif
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
