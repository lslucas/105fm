@layout('layouts/main')
@section('navigation')
@parent
<li class="active"><a href="/customer">Customers</a></li>
@endsection
@section('content')
<div class="hero-unit">
    <div class="row">
        <div class="span6">
            <h1>Update Customer {{ $customer->hash_id }}</h1>
        </div>
    </div>
</div>
   @if (@$response)
    	
    	<div class="{{ $response['info'] }}">
    		<p>{{ $response['msg'] }}</p>
    	</div>
        
    @endif
    {{ Form::open("customer/update/$hash_id", 'PUT') }}
        
        <p>{{ Form::label('name', 'Nome') }}</p>
        <p>{{ Form::text('name', $customer->name, array('placeholder'=>'Seu nome')) }}</p>
        <p>{{ Form::label('age', 'Idade') }}</p>
        <p>{{ Form::text('age', $customer->age, array('placeholder'=>'Sua idade')) }}</p>
        <p>{{ Form::submit('Save', array('class' => 'btn')) }}</p>

    {{ Form::close() }}
        

@endsection