@layout('layouts/main')
@section('navigation')
@parent
<li><a href="/about">About</a></li>
@endsection
@section('content')
<div class="hero-unit">
    <div class="row">
        <div class="span6">
            <h1>Welcome!</h1>
            <p>Lorem ipsum dolor, amet!</p>
            <p>Mais lorem ipsum!</p>
            <p><a href="about" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
        </div>
        <div class="span4">
            <img src="http://placehold.it/150x250" alt="Img!" />
        </div>
    </div>
</div>
<!-- Example row of columns -->
<div class="row">
    <div class="span3">
        <a href="#"><img src="http://placehold.it/270x150" alt="Get it" /></a>
    </div>
    <div class="span4">
        <a href="#"><img src="http://placehold.it/370x150" alt="Get it" /></a>
    </div>
    <div class="span4">
        <a href="#"><img src="http://placehold.it/370x150" alt="Get it " /></a>
    </div>
</div>
@endsection