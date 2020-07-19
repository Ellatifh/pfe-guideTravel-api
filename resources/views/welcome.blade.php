<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GUIDE TRAVEL APP</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #636b6f;
                color: #fff;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 80vh;
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
                color: #fff;
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
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    GUIDE TRAVEL APP
                </div>

                <div class="links">
                    <a href="/api/v1/login">Login</a>
                    <a href="/api/v1/signup">Sign-up</a>
                    <a href="/api/v1/categories">Categories</a>
                    <a href="/api/v1/cities">Cities</a>
                    <a href="/api/v1/hebergements">Hebergements</a>
                    <a href="/api/v1/events">Events</a>
                    <a href="/api/v1/restaurants">Restaurants</a>
                    <a href="/api/v1/shoppings">Shoppings</a>
                    <a href="/api/v1/loisirs">Loisirs</a>
                    <a href="/api/v1/infos">Infos</a>
                </div>
            </div>
        </div>
        <div class="content">
            <h6>Projet de fin d'étude de la filiére MIAM 2019/2020<br>Etablissement : IT-LEARNING CASABLANCA <br>POLE DEVELOPPEMENT / FST SETTAT</h6>
        </div>
    </body>
</html>
