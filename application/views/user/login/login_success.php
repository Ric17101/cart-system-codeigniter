<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Login success!</h1>
			</div>
			<p>Welcome <strong><?php echo $_SESSION['firstname'] ?></strong> <strong><?php echo $_SESSION['lastname'] ?></strong>!</p>
			<p>You are now logged in as <strong><?php echo $_SESSION['username'] ?></strong>.</p>
			<p><a role="button" class="btn btn-primary btn-small" href="<?= base_url() ?>">Home</a>.</p>
		</div>
	</div><!-- .row -->
</div><!-- .container -->