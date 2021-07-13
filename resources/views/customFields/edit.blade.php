{{ Form::model($customField, array('route' => array('custom-field.update', $customField->id), 'method' => 'PUT')) }}
<div class="row">
    <div class="form-group col-md-12">
        {{Form::label('name',__('Custom Field Name'))}}
        {{Form::text('name',null,array('class'=>'form-control','required'=>'required'))}}
    </div>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
        {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
    </div>
</div>
{{ Form::close() }}





