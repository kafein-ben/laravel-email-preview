<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - Aperçu des e-mails</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:700,400,300,300italic,700italic" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        *, *:before, *:after {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            font-family: "Lato", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            font-weight: 400;
            font-size: 14px;
            line-height: 18px;
            padding: 0;
            margin: 0;
            background: #f5f5f5;
        }

        .wrap {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 2px #ccc;
        }

        @media only screen and (max-width: 700px) {
            .wrap {
                padding: 15px;
            }
        }

        h1 {
            text-align: center;
            margin: 40px 0;
            font-size: 22px;
            font-weight: bold;
            color: #666;
        }

        a {
            color: #399ae5;
            text-decoration: none;
        }

        a:hover {
            color: #206ba4;
            text-decoration: none;
        }

        .block {
            clear: both;
            min-height: 50px;
            border-top: solid 1px #ECE9E9;
        }

        .block:first-child {
            border: none;
        }

        .block .img {
            width: 50px;
            height: 60px;
            display: block;
            float: right;
            font-size: 20px;
            padding-top: 20px;
            padding-left: 13px;
        }

        .block .date {
            margin-top: 4px;
            font-size: 70%;
            color: #666;
        }

        .block a:not(.img) {
            display: block;
            padding: 10px 15px;
            transition: all 0.35s;
            margin-right: 50px;
        }

        .block a:hover {
            text-decoration: none;
            background: #efefef;
        }

        .block a div {
            overflow: hidden;
            text-overflow: ellipsis;
        }

    </style>
</head>
<body>
<h1>Aperçu des e-mails</h1>

<div class="wrap">

    @forelse($emails as $email)
        @php $filename = pathinfo($email)['filename'] @endphp
        <div class="block">
            <a target="_blank" href="{{ route('emailpreview.download', $filename) }}" class="img fa fa-cloud-download"></a>
            <a target="_blank" href="{{ route('emailpreview.show', $filename) }}">
                <div class="name">
                    <div class="file">{{ substr($filename, strpos($filename, '_') + 1) }}</div>
                    <div class="date">Le {{ date("d/m/Y à H\hi", filemtime($email)) }}</div>
                </div>
            </a>
        </div>
    @empty
        <div class="block" style="text-align: center">
            Aucun e-mail disponible.
        </div>
    @endforelse

</div>

</body>
</html>
