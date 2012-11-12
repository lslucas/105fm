<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title>TechTravel</title>
{{ Asset::styles() }}
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="home">TechTravel</a>
                    <div class="nav-collapse">
                        <ul class="nav">
                            @section('navigation')
                            <li ><a href="home">Home</a></li>

                            @yield_section
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">
            @yield('content')
            <hr>
            <footer>
            <p>&copy; TechTravel {{ date('Y') }}</p>
            </footer>
        </div> <!-- /container -->
        <div class="modal hide fade">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Modal header</h3>
          </div>
          <div class="modal-body">
            <p>One fine body…</p>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn">Close</a>
            <a href="#" class="btn btn-primary action" data-dismiss="modal"></a>
          </div>
        </div>
{{ Asset::scripts() }}
    </body>
</html>