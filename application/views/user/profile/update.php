<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
	function update_user()
	{
	    $('#form_update_user')[0].reset(); // reset form on modals
	    $('.form-group').removeClass('has-error'); // clear error class
	    $('.help-block').empty(); // clear error string
	    $('#modal_form_update_user').modal('show'); // show bootstrap modal
	    $('.modal-title').text('Update Profile'); // Set Title to Bootstrap modal title
	}

	function save_user()
	{
	    $('#btnSaveUser').text('saving...'); //change button text
	    $('#btnSaveUser').attr('disabled',true); //set button disable 
	    var url = "<?php echo site_url('user/ajax_update')?>";

	    // ajax adding data to database
	    $.ajax({
	        url : url,
	        type: "POST",
	        data: $('#form_update_user').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        { 
	            if(data.status) //if success close modal and reload ajax table
	            {
	                //$('#modal_form_update_user').modal('hide');
	            }

	            $('#btnSaveUser').text('save'); //change button text
	            $('#btnSaveUser').attr('disabled',false); //set button enable 
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error update profile');
	            $('#btnSaveUser').text('save'); //change button text
	            $('#btnSaveUser').attr('disabled',false); //set button enable
	        }
	    });
	}

	function edit_user(id) // display data to the form
	{
		save_method = 'update';
		$('#form_update_user')[0].reset(); // reset form on modals
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string

		//Ajax Load data from ajax
		$.ajax({
			url : "<?php echo site_url('user/ajax_edit/')?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{ 
				$('[name="id"]').val(data.id);
				$('[name="firstname"]').val(data.firstname);
				$('[name="lastname"]').val(data.lastname);
				$('[name="username"]').val(data.username);
				$('[name="company"]').val(data.company);
				$('[name="department"]').val(data.department);
				$('[name="immediate_supervisor"]').val(data.immediate_supervisor);
				//$('[name="area"]').val(data.area);
				$('[name="email"]').val(data.email);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			}
		});
		$('#modal_form_update_user').modal('show'); // show bootstrap modal when complete loaded
		$('.modal-title').text('Update Profile'); // Set title to Bootstrap modal title
	}

</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Profile Details</h1>
			</div>
			<?php var_dump($user); ?>
			<div class="well">
				<br/>
				<table>
					<tr>
						<td width="60%">ID #</td>
						<td><?php echo $user->id_num; ?></td>
					</tr>
					<tr>
						<td valign="top">User Name</td>
						<td><?php echo $user->username; ?></td>
					</tr>
					<tr>
						<td valign="top">Name</td>
						<td>
							<?php echo $user->firstname; ?> <?php echo $user->lastname; ?>
						</td>
					</tr>
					<tr>
						<td valign="top">Email Address</td>
						<td><?php echo $user->email; ?></td>
					</tr>
					<tr>
						<td valign="top">Company</td>
						<td><?php echo $user->company; ?></td>
					</tr>
					<tr>
						<td valign="top">Departments</td>
						<td><?php echo $user->department; ?></td>
					</tr>
					<tr>
						<td valign="top">Immediate Supervisor</td>
						<td><?php echo $user->immediate_supervisor; ?></td>
					</tr>
					<tr>
						<td valign="top">Date Registered</td>
						<td><?php echo $user->created_at; ?></td>
					</tr>
					<tr>
						<td valign="top">Date Updated</td>
						<td><?php echo $user->updated_at; ?></td>
					</tr>
				</table>
			</div><!-- well -->
			<button class="btn btn-success" onclick="edit_user(<?php echo $user->id; ?>)"><i class="glyphicon glyphicon-pencil"></i> Update</button>
		</div>
	</div><!-- .row -->
</div><!-- .container -->


<!-- Bootstrap modal -->
<!-- Request Approval modal -->
<div class="modal fade" id="modal_form_update_user" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Update Profile</h3>
            </div>
            <div class="modal-body form_approve">
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
            	<?= form_open('#', array('id' => 'form_update_user', 'class' => 'form-horizontal')) ?>
                    <input type="hidden" id="id" name="id" /> 
                    <div class="form-body">
                    	<div class="form-group"><label class="control-label col-md-3" >First Name</label><div class="col-md-9">
                    		<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your first name" ><p class="help-block"></p></div>
                    	</div>
						<div class="form-group"><label class="control-label col-md-3">Last Name</label><div class="col-md-9">
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your last name" ><p class="help-block"></p></div>
						</div>
						<div class="form-group"><label class="control-label col-md-3" >Company</label><div class="col-md-9">
							<input type="text" class="form-control" id="company" name="company" placeholder="Enter your company" ><p class="help-block"></p></div>
						</div>
						<div class="form-group"><label class="control-label col-md-3" >Departmnet</label><div class="col-md-9">
							<input type="text" class="form-control" id="department" name="department" placeholder="Enter your department" ><p class="help-block"></p></div>
						</div>
						<div class="form-group"><label class="control-label col-md-3" >Immediate Supervisor</label><div class="col-md-9">
							<input type="text" class="form-control" id="immediate_supervisor" name="immediate_supervisor" placeholder="Enter your Supervisor Name" ><p class="help-block"></p></div>
						</div>
						

						<hr/>
						<div class="form-group"><label class="control-label col-md-3" >Username</label><div class="col-md-9">
							<input type="text" class="form-control" id="username" name="username" placeholder="Enter a username"><p class="help-block">At least 4 characters, letters or numbers only</p></div>
						</div>
						<div class="form-group"><label class="control-label col-md-3" >Email</label><div class="col-md-9">
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"><p class="help-block">A valid email address</p></div>
						</div>
						<div class="form-group"><label class="control-label col-md-3" >New Password</label><div class="col-md-9">
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password"><p class="help-block">New password</p></div>
						</div>
						<div class="form-group"><label class="control-label col-md-3" >Confirm New password</label><div class="col-md-9">
							<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password"><p class="help-block">Must match your new password</p></div>
						</div>
					</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveUser" onclick="save_user()" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->