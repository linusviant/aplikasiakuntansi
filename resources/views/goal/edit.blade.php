{{ Form::model($goal, array('route' => array('goal.update', $goal->id), 'method' => 'PUT')) }}
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('name', __('Name')) }}
        {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('amount', __('Amount')) }}
        {{ Form::number('amount', null, array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
    </div>
    <div class="form-group  col-md-12">
        <div class="input-group">
            {{ Form::label('type', __('Type')) }}
            {{ Form::select('type',$types,null, array('class' => 'form-control customer-sel font-style selectric ','required'=>'required')) }}
        </div>
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('from', __('From')) }}
        {{ Form::text('from',null, array('class' => 'form-control custom-datepicker')) }}
    </div>
    <div class="form-group  col-md-6">
        {{ Form::label('tp', __('To')) }}
        {{ Form::text('to',null, array('class' => 'form-control custom-datepicker')) }}
    </div>
    <div class="form-group col-md-12">
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" name="is_display" id="is_display" {{$goal->is_display==1?'checked':''}}>
            <label class="custom-control-label" for="is_display">{{__('Is Dashoard Display')}}</label>
        </div>
    </div>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
        {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
    </div>
</div>
{{ Form::close() }}


