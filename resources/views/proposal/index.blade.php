@extends('layouts.admin')
@section('page-title')
    {{__('Proposal')}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Proposal')}}</h1>
            <div class="section-header-breadcrumb">
                @if(\Auth::guard('customer')->check())
                    <div class="breadcrumb-item active"><a href="{{route('customer.dashboard')}}">{{__('Dashboard')}}</a></div>
                @else
                    <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                @endif
                <div class="breadcrumb-item">{{__('Proposal')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Manage Proposal')}}</h4>
                                <div class="card-header-action">
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="btn btn-icon icon-left btn-primary"><i class="fas fa-filter"></i>{{__('Filter')}}</a>
                                        <div class="dropdown-menu dropdown-list dropdown-menu-right Filter-dropdown w-64">
                                            @if(!\Auth::guard('customer')->check())
                                                {{ Form::open(array('route' => array('proposal.index'),'method' => 'GET')) }}
                                            @else
                                                {{ Form::open(array('route' => array('customer.proposal'),'method' => 'GET')) }}
                                            @endif
                                            @if(!\Auth::guard('customer')->check())
                                                <div class="form-group">
                                                    {{ Form::label('customer', __('Customer')) }}
                                                    {{ Form::select('customer',$customer,isset($_GET['customer'])?$_GET['customer']:'', array('class' => 'form-control font-style selectric')) }}
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                {{ Form::label('issue_date', __('Date')) }}
                                                {{ Form::text('issue_date', isset($_GET['issue_date'])?$_GET['issue_date']:null, array('class' => 'form-control datepicker-range')) }}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('status', __('Status')) }}
                                                {{ Form::select('status', [''=>'All']+$status,isset($_GET['status'])?$_GET['status']:'', array('class' => 'form-control font-style selectric')) }}
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                                                @if(!\Auth::guard('customer')->check())
                                                    <a href="{{route('proposal.index')}}" class="btn btn-danger">{{__('Reset')}}</a>
                                                @else
                                                    <a href="{{route('customer.proposal')}}" class="btn btn-danger">{{__('Reset')}}</a>
                                                @endif
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                    @can('create proposal')
                                        <a href="{{ route('proposal.create') }}" class="btn btn-icon icon-left btn-primary">
                                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                            <span class="btn-inner--text"> {{__('Create')}}</span>
                                        </a>
                                    @endcan
                                </div>
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
                                                        <th> {{__('Proposal')}}</th>
                                                        @if(!\Auth::guard('customer')->check())
                                                            <th> {{__('Customer')}}</th>
                                                        @endif
                                                        <th> {{__('Category')}}</th>
                                                        <th> {{__('Issue Date')}}</th>
                                                        <th> {{__('Status')}}</th>
                                                        @if(Gate::check('edit proposal') || Gate::check('delete proposal') || Gate::check('show proposal'))
                                                            <th class="text-right"> {{__('Action')}}</th>
                                                        @endif
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach ($proposals as $proposal)
                                                        <tr class="font-style">
                                                            <td>
                                                                @if(\Auth::guard('customer')->check())
                                                                    <a class="btn btn-outline-primary" href="{{ route('customer.proposal.show',$proposal->id) }}">{{ AUth::user()->proposalNumberFormat($proposal->proposal_id) }}
                                                                    </a>
                                                                @else
                                                                    <a class="btn btn-outline-primary" href="{{ route('proposal.show',$proposal->id) }}">{{ AUth::user()->proposalNumberFormat($proposal->proposal_id) }}
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            @if(!\Auth::guard('customer')->check())
                                                                <td> {{!empty($proposal->customer)? $proposal->customer->name:'' }} </td>
                                                            @endif
                                                            <td>{{ !empty($proposal->category)?$proposal->category->name:''}}</td>
                                                            <td>{{ Auth::user()->dateFormat($proposal->issue_date) }}</td>
                                                            <td>
                                                                @if($proposal->status == 0)
                                                                    <span class="badge badge-primary">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                                @elseif($proposal->status == 1)
                                                                    <span class="badge badge-warning">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                                @elseif($proposal->status == 2)
                                                                    <span class="badge badge-danger">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                                @elseif($proposal->status == 3)
                                                                    <span class="badge badge-info">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                                @elseif($proposal->status == 4)
                                                                    <span class="badge badge-success">{{ __(\App\Proposal::$statues[$proposal->status]) }}</span>
                                                                @endif
                                                            </td>
                                                            @if(Gate::check('edit proposal') || Gate::check('delete proposal') || Gate::check('show proposal'))
                                                                <td class="action text-right">
                                                                    @can('convert invoice')
                                                                        <a href="#" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Convert to Invoice')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="You want to confirm convert to invoice. Press Yes to continue or Cancel to go back" data-confirm-yes="document.getElementById('proposal-form-{{$proposal->id}}').submit();">
                                                                            <i class="fas fa-exchange-alt"></i>
                                                                            {!! Form::open(['method' => 'get', 'route' => ['proposal.convert', $proposal->id],'id'=>'proposal-form-'.$proposal->id]) !!}
                                                                            {!! Form::close() !!}
                                                                        </a>
                                                                    @endcan
                                                                    @can('duplicate proposal')
                                                                        <a href="#" class="btn btn-success btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Duplicate')}}" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="You want to confirm duplicate this invoice. Press Yes to continue or Cancel to go back" data-confirm-yes="document.getElementById('duplicate-form-{{$proposal->id}}').submit();">
                                                                            <i class="fas fa-copy"></i>
                                                                            {!! Form::open(['method' => 'get', 'route' => ['proposal.duplicate', $proposal->id],'id'=>'duplicate-form-'.$proposal->id]) !!}
                                                                            {!! Form::close() !!}
                                                                        </a>
                                                                    @endcan
                                                                    @can('show proposal')
                                                                        @if(\Auth::guard('customer')->check())
                                                                            <a href="{{ route('customer.proposal.show',$proposal->id) }}" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                        @else
                                                                            <a href="{{ route('proposal.show',$proposal->id) }}" class="btn btn-info btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Detail')}}">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                        @endif
                                                                    @endcan
                                                                    @can('edit proposal')
                                                                        <a href="{{ route('proposal.edit',$proposal->id) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                            <i class="fas fa-pencil-alt"></i>
                                                                        </a>
                                                                    @endcan

                                                                    @can('delete proposal')
                                                                        <a href="#!" class="btn btn-danger btn-action " data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$proposal->id}}').submit();">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['proposal.destroy', $proposal->id],'id'=>'delete-form-'.$proposal->id]) !!}
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </td>
                                                            @endif
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
