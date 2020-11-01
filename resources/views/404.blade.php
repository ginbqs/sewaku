<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="{{ asset('404.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div id="clouds">
                    <div class="cloud x1"></div>
                    <div class="cloud x1_5"></div>
                    <div class="cloud x2"></div>
                    <div class="cloud x3"></div>
                    <div class="cloud x4"></div>
                    <div class="cloud x5"></div>
                </div>
                <div class='c'>
                    <div class='_404'>404</div>
                    <hr>
                    <div class='_1'>THE PAGE</div>
                    <div class='_2'>WAS NOT FOUND</div>
                    <a class='btn' href='#'>BACK TO MARS</a>
                </div>
            </div>
        </div>
    </body>
</html>