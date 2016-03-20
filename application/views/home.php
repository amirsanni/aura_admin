<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Log in</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?=base_url()?>public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/css/form-elements.css">
        <link rel="stylesheet" href="<?=base_url()?>public/css/style.css">
        <link rel="stylesheet" href="<?=base_url()?>public/css/main.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">

            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1>Admin Log in </h1>
                            <div style="font-size:100px">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="bg-primary text-center">
                                <span id="errMsg"></span>
                            </div>
                            <div class="form-bottom">
                                <form id="loginForm">
                                    <div class="form-group">
                                        <label class="sr-only" for="email">E-mail</label>
                                        <input type="email" placeholder="Email" class="form-control checkField" id="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="password">Password</label>
                                        <input type="password" placeholder="Password" class="form-control checkField" id="password" required>
                                    </div>
                                    <button type="submit" class="btn">Log in!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- Javascript -->
        <script src="<?=base_url()?>public/js/jquery.min.js"></script>
        <script src="<?=base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>public/js/jquery.backstretch.min.js"></script>
        <script src="<?=base_url()?>public/js/main.js"></script>
        <script src="<?=base_url()?>public/js/access.js"></script>
        <!--Javascript--->

    </body>

</html>