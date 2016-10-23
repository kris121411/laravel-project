

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SUPPORTZEBRA</title>
        <link href="{{ URL::asset('ext/resources/css/ext-all-neptune.css') }}" rel="stylesheet" />
        <script src="{{ URL::asset('ext/ext-all.js') }}"></script>
           <script type="text/javascript" src="{{ URL::asset('js/user.js') }}"></script>
           <script type="text/javascript" src="{{ URL::asset('js/date_time.js') }}"></script>

       

        <style>
            html, body {
                background-color: #fff;
                color: red;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 100%;
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
              .container {
                width: 98% !important;
                min-height: 95%;
                height: 96% !important;
                border: solid 1px #ccc;
                overflow: auto;
                border-radius: 15px 15px 15px 15px;
                background: #ffffff;
            
                text-align: left;
            }
            .main_container {
                width: 99.7% !important;
                min-height: 95%;
                height: 95% !important;
                border: solid 1px #ccc;
                overflow: auto;
                background: #ffffff;
                text-align: left;
            }
            .logo_container {
                height: 15% !important;
                border: solid 1px #ccc;
                background: orange;
                text-align: left;
            }
            .systeminfo_container {
                height: 5% !important;
                border: solid 1px #ccc;
                overflow: auto;
                background: #157fcc;
                text-align: left;
                color: white;
                font-size:116%;
                padding: 6px 0px 0px 10px;
            }
            .content_container {
                height: 78% !important;
                border: solid 1px #ccc;
                background: white;
            }
            .buttom_container {
                height:4% !important;
                border: solid 1px #ccc;
                background: orange;
                text-align: center;
                padding: 2px 0px 0px 0px;
            }
            .logout {
             float:right;
             margin-right:10px;
             }
              .back_menu {
             float:right;
             margin-right:40px;
             }
           
            a:link, a:visited {
            background-color: #157fcc;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        table {
                font-family: 'Raleway', sans-serif;
                width: 100%;
            }

            th {
                text-align: center;
                padding: 8px;
            }
            td
            {
                text-align: left;
                 padding: 4px;
            }

            .button {
                background-color: #add2ed !important;
                color: #157fcc !important;
                padding: 15px 32px;
                text-align: center;
                cursor: pointer;
                border-radius: 12px;
                display: block;
                width: 300px !important;
                font-size:116%;
                border: hidden !important;
            }
            .button:hover { 
             background-color: #157fcc !important;
             color: White !important;
            }
            .btn
            {
           
            background-image: none;
            border-radius: 12px;
            }
            
        </style>
    </head>
    <body>

        <div class="flex-center position-ref full-height">
        <div class="container" >
            <div class="main_container" >
                    <div class="logo_container" >
                    <img src="{{ URL::asset('images/logo2.png') }}" width="25% !important">              
                   </div>  
                    <div class="systeminfo_container" id='systeminfo' > 
                    User: <b>{{ Session::get('user_fname')}} {{ Session::get('user_lname')}}</b>   |   IP Address: <b>{{ Session::get('ip_address')}} </b>   |    Time: 
                    <span  id='clock' > 
                    <script type="text/javascript">window.onload = date_time('clock');</script>
                   </span>  
                   
                   <span class="logout" id='logout'> 
                   <a href= "{{ URL::asset('logout') }}"><b>Log out</b></a>    
                   </span>
                    <span class="back_menu" id='back_menu'> 
                   <a href= "{{ URL::asset('/home/permissions') }}"><b>Return to PERMISSIONS</b></a>    
                   </span>
                   </div>  
                    <div class="content_container" id='content_container' > 
                    </div> 
           </div>
            <div class="buttom_container">
                   <b>SUPPORTZEBRA an FBC Company</b> 
                    </div>  
           </div>
        </div>
    </body>

</html>

