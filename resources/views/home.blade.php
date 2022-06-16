<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proveedores</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
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
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="breadcrumb">
        <div class="row col-md-12 col-xs-12 col-sm-12">
            <div class="col-md-10">
                <h1>Principal </h1>
    
            </div>
            <div class="col-md-1">
                
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">
            {{-- <div class="card-body"> --}}
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div id="admin" class="content">
                        <admin-component></admin-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/fontawesome.js')}}"></script>
</html>