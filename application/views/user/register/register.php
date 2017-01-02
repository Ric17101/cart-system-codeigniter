<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Registration Forms</h1>
			</div>
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
			<div class="col-lg-4">
				<?= form_open() ?>
					<div class="form-group">
						<label for="firstname">First Name</label>
						<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your first name" value='<?php echo set_value('firstname')?>'>
						<p class="help-block"></p>
					</div>
					<div class="form-group">
						<label for="lastname">Last Name</label>
						<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your last name" value='<?php echo set_value('lastname')?>'>
						<p class="help-block"></p>
					</div>
					<div class="form-group">
						<label for="company">Company</label>
						<input type="text" class="form-control" id="company" name="company" placeholder="Enter your company" value='<?php echo set_value('company')?>'>
						<p class="help-block"></p>
					</div>
					<div class="form-group">
						<label for="department">Departmnet</label>
						<input type="text" class="form-control" id="department" name="department" placeholder="Enter your department" value='<?php echo set_value('department')?>'>
						<p class="help-block"></p>
					</div>
					<div class="form-group">
						<label for="immediate_supervisor">Immediate Supervisor</label>
						<input type="text" class="form-control" id="immediate_supervisor" name="immediate_supervisor" placeholder="Enter your Supervisor Name" value='<?php echo set_value('immediate_supervisor')?>'>
						<p class="help-block"></p>
					</div>


					<hr/>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Enter a username" value='<?php echo set_value('username')?>'>
						<p class="help-block">At least 4 characters, letters or numbers only</p>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value='<?php echo set_value('email')?>'>
						<p class="help-block">A valid email address</p>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
						<p class="help-block">At least 6 characters</p>
					</div>
					<div class="form-group">
						<label for="password_confirm">Confirm password</label>
						<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
						<p class="help-block">Must match your password</p>
					</div>
					<hr/>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Register">
					</div>
				</form>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->