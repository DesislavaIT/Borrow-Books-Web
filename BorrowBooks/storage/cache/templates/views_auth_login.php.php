<?php class_exists('Core\Web\Template') or exit; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css" />

        <link rel="stylesheet" href="assets/css/global.css" />
        
    <link rel="stylesheet" href="assets/css/auth.css" />


        <style type="text/css">
            .fa {
                display: inline-block;
                font: normal normal normal 16px/1 "FontAwesome";
                font-size: inherit;
                text-rendering: auto;
                line-height: inherit;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .mdi:before, .mdi-set {
                display: inline-block;
                font: normal normal normal 16px/1 "Material Design Icons";
                font-size: inherit;
                text-rendering: auto;
                line-height: inherit;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .fa-fw, .fa-fw:before, .mdi-fw:before {
                width: 1.25em;
                text-align: center;
            }
        </style>

        <title>Bookstore</title>
    </head>
    <body>
        
    <div class="page-layout">
        <div class="container">
            <header>
                <h2>Sign In</h2>
            </header>
            <form action="/login" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-actions" style="justify-content: center;">
                    <button class="button-primary button-rounded button-wide" type="submit">Log In</button>
                </div>
                <div class="form-links" style="justify-content: center;">
                    <p>Don't have an account? <a href="/register">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>

        
    </body>
</html>





