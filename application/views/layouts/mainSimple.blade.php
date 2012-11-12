<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>TechTravel</title>
{{ Asset::styles() }}
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div> <!-- /container -->
{{ Asset::scripts() }}
    </body>
</html>