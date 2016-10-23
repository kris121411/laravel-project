<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SUPPORTZEBRA</title>
        <link href="{{ URL::asset('ext/resources/css/ext-all-neptune.css') }}" rel="stylesheet" />
        <script src="{{ URL::asset('ext/ext-all.js') }}"></script>
        <script src="{{ URL::asset('js/login.js') }}"></script>
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content {
                text-align: center;
                padding-top: 40px
                
            }
            .title {
                font-size: 84px;

            }
            .m-b-md {
                margin-bottom: 30px;
            }
            .x-body {
             background: url("{{ URL::asset('images/background.jpg') }}");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                <img src="{{ URL::asset('images/logo2.png') }}" width="30% !important">
                </div>
                <div class="content_container" id='content_container' >

                </div> 
            </div>
        </div>
    </body>
</html>
