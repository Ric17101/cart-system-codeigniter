<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<?php if ((!isset($_SESSION['username'])) || (!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === false)) : ?>
			<?php if (validation_errors()) : ?>
				<div class="col-md-12">
					<div class="alert alert-danger" role="alert">
						<?= validation_errors() ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if (isset($error)) : ?>
				<div class="col-md-12">
					<div class="alert alert-danger" role="alert">
						<?= $error ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="col-md-12">
				<div class="page-header">
					<h1>Login</h1>
				</div>
				<div class="col-lg-4">
					<?= form_open() ?>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Your username" value="<?php echo set_value('username')?>">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Your password">
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Login">
							<a href="<?= base_url('register') ?>">
								Register
							</a>
						</div>
					</form>
				</div>
			</div>
		<?php else : ?>
			<li>You must <a href="<?= base_url('logout') ?>">Logout</a> first.</li>
		<?php endif; ?>
	</div><!-- .row -->
</div><!-- .container -->