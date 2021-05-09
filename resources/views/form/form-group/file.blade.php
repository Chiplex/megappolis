@php
    if(!$options->has('class')) $options->put('class', 'form-control')
@endphp
<div class="form-group row">
    @if($options->has('title'))
        {!! Form::label($options->get('name'), $options->get('title'), ['class' => 'col-form-label col-sm-4']) !!}
    @endif
    <div class="col-sm-8">
        {!! Form::file($options->get('name'), $options->except(['name', 'value'])->all()) !!}
    </div>
</div>
@error($options->get('name'))
<p class="text-danger">
    <strong>{{ $errors->first($options->get('name')) }}</strong>
</p>
@enderror