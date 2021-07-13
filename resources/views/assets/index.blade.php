@extends('layouts.admin')
@section('page-title')
    {{__('Assets')}}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Assets')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Assets')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>{{__('Manage Assets')}}</h4>
                                @can('create assets')
                                    <div class="col-auto">
                                        <a href="#" data-url="{{ route('account-assets.create') }}" data-ajax-popup="true" data-title="{{__('Create New Assets')}}" class="btn btn-icon icon-left btn-primary">
                                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                            <span class="btn-inner--text"> {{__('Create')}}</span>
                                        </a>
                                    </div>
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
                                                        <th> {{__('Name')}}</th>
                                                        <th> {{__('Purchase Date')}}</th>
                                                        <th> {{__('Supported Date')}}</th>
                                                        <th> {{__('Amount')}}</th>
                                                        <th> {{__('Description')}}</th>
                                                        <th class="text-right"> {{__('Action')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($assets as $asset)
                                                        <tr>
                                                            <td class="font-style">{{ $asset->name }}</td>
                                                            <td class="font-style">{{ \Auth::user()->dateFormat($asset->purchase_date) }}</td>
                                                            <td class="font-style">{{ \Auth::user()->dateFormat($asset->supported_date) }}</td>
                                                            <td class="font-style">{{ \Auth::user()->priceFormat($asset->amount) }}</td>
                                                            <td class="font-style">{{ $asset->description }}</td>
                                                            <td class="action text-right">
                                                                @can('edit assets')
                                                                    <a href="#" class="btn btn-primary btn-action mr-1" data-url="{{ route('account-assets.edit',$asset->id) }}" data-ajax-popup="true" data-title="{{__('Edit Assets')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('delete assets')
                                                                    <a href="#" class="btn btn-danger btn-action" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$asset->id}}').submit();">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['account-assets.destroy', $asset->id],'id'=>'delete-form-'.$asset->id]) !!}
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
            </div>

        </div>
    </section>
@endsection
