<!DOCTYPE html>
<html>

    <head>
        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    </head>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            background-color: rgb(247, 247, 247);
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .row {
            text-align: right;
            width: 100%;
        }

        .my_header {
            overflow: hidden;
            background-color: #f1f1f1;
            padding: 20px 10px;
        }

        .my_header a {
            float: left;
            color: rgb(255, 255, 255);
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            line-height: 25px;
            border-radius: 4px;
        }

        .my_header a.logo {
            font-size: 25px;
            font-weight: bold;
        }

        .my_header a:hover {
            background-color: white;
            color: #0d6efd;
        }

        .my_header a.active {
            background-color: dodgerblue;
            color: white;
        }

        .my_header-right {
            float: right;
        }

        @media screen and (max-width: 500px) {
            .my_header a {
                float: none;
                display: block;
                text-align: left;
            }

            .my_header-right {
                float: none;
            }
        }

        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>

    <body>

        @yield('bodypart')

        <footer class="bg-primary text-center text-white" style="position: relative; bottom:0;">
            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © 2024 Copyright:
                <a class="text-white" href="#">VIPIN T</a>
            </div>
            <!-- Copyright -->
        </footer>
    </body>

</html>
