<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Undefined</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/css/mdb.min.css" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/index.css?v=0.1') }}" rel="stylesheet">
        <link href="{{ asset('css/search.css?v=0.1') }}" rel="stylesheet">
        <link href="{{ asset('css/popup.css?v=0.1') }}" rel="stylesheet">
        <link href="{{ asset('css/show.css?v=0.1') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick.css?v=0.1') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick-theme.css?v=0.1') }}"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('slick/slick.min.js?v=0.1') }}"></script>
    </head>

    <body style="margin-left: 300px !important;">

        <div id="app" style="height: 100% !important;">
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
        <!-- JQuery -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            jQuery.noConflict();
            $(function() {
                $('.slider').slick({
                    infinite: true,
                    dots: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    },{
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    }
                    ]
                });
            });
        </script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>
    </body>
</html>
