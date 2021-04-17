<div class="card card-info">
    {!! Form::open($form) !!}
        <div class="card-header">
            <div class="card-tools">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        <div class="card-body">
            @foreach ($collection as $item)
                @include($item['tipo'], $item['elementos'])
            @endforeach
        </div>
    {!! Form::close() !!}
</div>