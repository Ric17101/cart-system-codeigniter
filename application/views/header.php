<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>C A R T</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">

	<!-- css -->
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" />
	
	<link href="<?php echo base_url('assets/bootstrap/css/loading_animation_refresh.css')?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/bootstrap-timepicker/css/bootstrap-datetimepicker.min.css')?>" rel="stylesheet" />
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<header id="site-header">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid" role="main">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?= base_url() ?>">Centralized Activity Request Tool</a>
					<a class="navbar-brand" href="<?= base_url('calendar') ?>"> </a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
							<li><a href="<?= base_url('user') ?>"><strong><?php if ($_SESSION['is_approver'] === true) : echo "Approver (".$_SESSION['area'].") : "; else : echo "Requestor: "; endif; echo $_SESSION['username'];?></strong></a></li>
							<li><a href="<?= base_url('logout') ?>">Logout</a></li>
						<?php else : ?>
							<li><a href="<?= base_url('register') ?>">Register</a></li>
							<li><a href="<?= base_url('login') ?>">Login</a></li>
						<?php endif; ?>
					</ul>
				</div><!-- .navbar-collapse -->
			</div><!-- .container-fluid -->
		</nav><!-- .navbar -->
	</header><!-- #site-header -->
	<main id="site-content" role="main">
		<br/>
		<br/>
		<?php if (isset($error)) : ?>
            <div class="col-md-12">
			
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
					<a href="<?= base_url('register') ?>">Register</a> or 
					<a href="<?= base_url('login') ?>">Login</a>.
                </div>
            </div>
		<?php endif; ?>
		
