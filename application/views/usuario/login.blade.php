@layout('layouts/main')
@section('content')
<div class="hero-unit">
    <div class="row">
        <div class="login-box">
            <h3>Login {{ Session::get('customerName') }}!</h3>
            {{ Form::open('login', 'POST') }}
                @if (Session::has('login_errors'))
                   <!-- check for login errors flash var -->
                    <span class="error">Usuário ou senha inválidos.</span>
                @endif
                <p>{{ Form::text('email', null, array('placeholder'=>'Email')) }}</p>
                <p>{{ Form::password('password', array('placeholder'=>'Senha')) }}</p>
                <p>{{ Form::submit('Login', array('style'=>'width:220px')) }}</p>
                {{ Form::hidden('customerCode', Session::get('customerCode')) }}
                <div class='row-fluid'>
                    <div class='span15'>
                        <div class='row-fluid'>
                            <div class='span6'>
                                {{ Form::checkbox('keepLogged', 1, true, array('id' => 'keepLogged')) }}
                                {{ Form::label('keepLogged', 'Manter logado', array('style'=>'display:inline-block')) }}
                            </div>
                            <div class='span5' style='float:right;'>
                                {{ HTML::link('forgot-password', 'Lembrar senha') }}
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::token() }}
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection