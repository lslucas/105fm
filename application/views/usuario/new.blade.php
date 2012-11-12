@layout('layouts/main')
@section('navigation')
<li class="active"><a href="/customer">Customers</a></li>
@endsection
@section('content')
<div class="hero-unit">
    <div class="row">
        <div class="span6">
            <h1>New Customer</h1>
           
        </div>
    </div>


</div>
<div class="">
     @if (@$response)
                
        <div class="{{ $response['info'] }}">
            <p>{{ $response['msg'] }}</p>
        </div>
                
    @endif
    {{ Form::open('customer/new', 'PUT') }}
        
        <p>{{ Form::label('name', 'Nome') }}</p>
        <p>{{ Form::text('name', null, array('placeholder'=>'Seu nome')) }}</p>
        <p>{{ Form::label('age', 'Idade') }}</p>
        <p>{{ Form::text('age', null, array('placeholder'=>'Sua idade')) }}</p>
        <p>{{ Form::submit('Save', array('class' => 'btn')) }}</p>

    {{ Form::close() }}
</div>
@endsection