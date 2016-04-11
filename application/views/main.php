<?php
defined('BASEPATH') OR exit('');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title><?= $pageTitle ?></title>        
        
        <!--- LOAD FILES --->
	    <?php if($_SERVER['HTTP_HOST'] == "localhost"): ?>
	        <link rel="stylesheet" href="public/css/open_sans.css">
	        <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
	        <link rel="stylesheet" href="public/bootstrap/css/bootstrap-theme.min.css" media="screen">
	        <link rel="stylesheet" href="public/font-awesome/css/font-awesome.min.css">
	        <link rel="stylesheet" href="public/font-awesome/css/font-awesome-animation.min.css">
	        
	        <script src="public/js/jquery.min.js"></script>
	    	<script src="public/bootstrap/js/bootstrap.min.js"></script>
	        
		<?php else: ?>
	        <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
	        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.8/font-awesome-animation.min.css">
	        
	        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	    
		<?php endif; ?>
	        
	    <!-- Custom styles -->
		<link rel="stylesheet" href="public/css/main.css">
		
		<!-- custom js -->
		<script src="public/js/main.js"></script>
	        
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
    </head>

    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=base_url()?>">Logo</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbarIcons" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left visible-xs">
                        <li class="<?= $pageTitle == 'Dashboard' ? 'active' : '' ?>">
                            <a href="<?= site_url('dashboard') ?>">
                                <i class="fa fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="<?= $pageTitle == 'Users' ? 'active' : '' ?>">
                            <a href="<?= site_url('users') ?>">
                                <i class="fa fa-users"></i>
                                Users
                            </a>
                        </li>
                        <li class="<?= $pageTitle == 'Projects' ? 'active' : '' ?>">
                            <a href="<?= site_url('projects') ?>">
                                <i class="fa fa-tasks"></i>
                                Projects
                            </a>
                        </li>
                        <li class="<?= $pageTitle == 'Blogs' ? 'active' : '' ?>">
                            <a href="<?= site_url('blogs') ?>">
                                <i class="fa fa-rss"></i>
                                Blogs
                            </a>
                        </li>
                        <?php if($this->session->admin_role === "Super"): ?>
                        <li class="<?= $pageTitle == 'Administrators' ? 'active' : '' ?>">
                            <a href="<?= site_url('administrators') ?>">
                                <i class="fa fa-wrench"></i>
                                Admin Management
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user"></i> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu-header text-center">
                                    <strong>Account</strong>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-bell-o"></i> 
                                        Total Projects
                                        <span class="label label-info">42</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-envelope-o"></i>
                                        Messages
                                        <span class="label label-success">42</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="<?= site_url('logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div class="container-fluid">
            <div class="row content">
			<!-- Left sidebar -->
                <div class="col-sm-2 sidenav hidden-xs">
                    <br>
                    <ul class="nav nav-pills nav-stacked pointer">
                        <li class="<?= $pageTitle == 'Dashboard' ? 'active' : '' ?>">
                            <a href="<?= site_url('dashboard') ?>">
                                <i class="fa fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="<?= $pageTitle == 'Users' ? 'active' : '' ?>">
                            <a href="<?= site_url('users') ?>">
                                <i class="fa fa-users"></i>
                                Users
                            </a>
                        </li>
                        <li class="<?= $pageTitle == 'Projects' ? 'active' : '' ?>">
                            <a href="<?= site_url('projects') ?>">
                                <i class="fa fa-tasks"></i>
                                Projects
                            </a>
                        </li>
                        <li class="<?= $pageTitle == 'Blogs' ? 'active' : '' ?>">
                            <a href="<?= site_url('blogs') ?>">
                                <i class="fa fa-rss"></i>
                                Blogs
                            </a>
                        </li>
                        <?php if($this->session->admin_role === "Super"): ?>
                        <li class="<?= $pageTitle == 'Administrators' ? 'active' : '' ?>">
                            <a href="<?= site_url('administrators') ?>">
                                <i class="fa fa-wrench"></i>
                                Admin Management
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <br>
                </div>
                <!-- Left sidebar ends -->
                <br>
                <!-- Main content -->
                <div class="col-sm-10">
                    <?= isset($pageContent) ? $pageContent : "" ?>
                </div>
                <!-- Main content ends -->
            </div>
        </div>

        <footer class="container-fluid text-center hidden-print">
            <p>
                <i class="fa fa-copyright"></i>
                Copyright <a href="<?=base_url()?>">Design Aura</a> (2015 - <?= date('Y') ?>)
            </p>
        </footer>

        <!--Modal to show flash message--->
        <div id="flashMsgModal" class="modal fade" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="flashMsgHeader">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <center><i id="flashMsgIcon"></i> <font id="flashMsg"></font></center>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal end-->
        
        
        <!---Login Modal--->
        <div class="modal fade" role='dialog' data-backdrop='static' id='logInModal'>
            <div class="modal-dialog">
                <!---- Log in div below----->
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close closeLogInModal">&times;</button>
                        <h4 class="text-center">Log In</h4>
                        <div id="logInModalFMsg" class="text-center errMsg"></div>
                    </div>
                    <div class="modal-body">
                        <form name="logInModalForm">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label for='logInModalEmail' class="control-label">E-mail</label>
                                    <input type="email" id='logInModalEmail' class="form-control checkField" placeholder="E-mail" autofocus>
                                    <span class="help-block errMsg" id="logInModalEmailErr"></span>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label for='logInModalPassword' class="control-label">Password</label>
                                    <input type="password" id='logInModalPassword'class="form-control checkField" placeholder="Password">
                                    <span class="help-block errMsg" id="logInModalPasswordErr"></span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6 pull-left">
                                    <input type="checkbox" class="control-label" id='remMe'> Remember me
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2 pull-right">
                                    <button id='loginModalSubmit' class="btn btn-primary">Log in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!---- End of log in div----->
            </div>
        </div>
        <!---end of Login Modal-->
    </body>
</html>