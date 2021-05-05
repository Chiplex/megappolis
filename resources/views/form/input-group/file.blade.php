@if($options->has('title'))
    {!! Form::label($options->get('name'), $options->get('title'), ['class' => 'form-label']) !!}
@endif
@php
    if (!$options->has('class')) $options->put('class','form-control');
@endphp
<div class="input-group mb-3">
    {!! Form::file($options->get('name'), $options->except(['name', 'title'])->all()) !!}
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fa fa-{{ $options->get('icon', 'circle') }}"></span>
        </div>
    </div>
</div>
@error($options->get('name'))
<p class="text-danger">
    <strong>{{ $errors->first($options->get('name')) }}</strong>
</p>
@enderror