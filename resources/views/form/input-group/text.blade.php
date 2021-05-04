@isset($title)
{!! Form::label($name, $title, ['class' => 'form-label']) !!}
@endisset
<div class="input-group mb-3">
    <input placeholder="{{ $placeholder }}" name="{{$name}}" type="text" class="form-control {{ $class ?? ''}} @error($name) is-invalid @enderror">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fa fa-{{ $icon ?? 'circle' }}"></span>
        </div>
    </div>
    
    @error($name)
    <div class="invalid-feedback">
        <strong>{{ $errors->first($name) }}</strong>
    </div>
    @enderror
</div>