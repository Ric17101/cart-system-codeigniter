<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Email Notification Request C A R T</title>
	</head> 
	<body>

    <div class="container">
	<h2>Email Notification from C A R T</h2>
		<table border="1" cellpadding="10" cellspacing="0" width="600" style="border-collapse:collapse;">
			<thead>
				<tr>
					<th colspan="12" ><strong> REQUEST DETAILS </strong></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($is_approver === true) : ?>
					<tr>
						<td width="150"><strong> Activity Description </strong></td>
						<td width="450"><?php echo $activity_desc;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Approval Status </strong></td>
						<td width="450"><?php echo $approval_status;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Approver's Name </strong></td>
						<td width="450"><?php echo $approver_name;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Approver's Email </strong></td>
						<td width="450"><?php echo $approver_email;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Requestor's Name </strong></td>
						<td width="450"><?php echo $employee_name;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Requestor's Email </strong></td>
						<td width="450"><?php echo $requestor_email;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Site Name </strong></td>
						<td width="450"><?php echo $site_name;?></td>
					</tr>
					<tr>
						<td width="150"><strong> NE Involved </strong></td>
						<td width="450"><?php echo $ne_involved;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Request ID </strong></td>
						<td width="450"><?php echo $request_id;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Activity Date </strong></td>
						<td width="450"><?php echo $activity_date;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Start Time </strong></td>
						<td width="450"><?php echo $start_time;?></td>
					</tr>
					<tr>
						<td width="150"><strong> End Time </strong></td>
						<td width="450"><?php echo $end_time;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Link </strong></td>
						<td width="450"><?php echo $link;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Approval Notes </strong></td>
						<td width="450"><?php echo $approval_notes;?></td>
					</tr>
				<?php else : ?>
					<tr>
						<td width="150"><strong> Activity Description </strong></td>
						<td width="450"><?php echo $activity_desc;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Requestor's Name </strong></td>
						<td width="450"><?php echo $employee_name;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Requestor's Email </strong></td>
						<td width="450"><?php echo $requestor_email;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Request ID </strong></td>
						<td width="450"><?php echo $request_id;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Site Name </strong></td>
						<td width="450"><?php echo $site_name;?></td>
					</tr>
					<tr>
						<td width="150"><strong> NE Involved </strong></td>
						<td width="450"><?php echo $ne_involved;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Activity Date </strong></td>
						<td width="450"><?php echo $activity_date;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Start Time </strong></td>
						<td width="450"><?php echo $start_time;?></td>
					</tr>
					<tr>
						<td width="150"><strong> End Time </strong></td>
						<td width="450"><?php echo $end_time;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Link </strong></td>
						<td width="450"><?php echo $link;?></td>
					</tr>
					<tr>
						<td width="150"><strong> Remarks </strong></td>
						<td width="450"><?php echo $remarks;?></td>
					</tr>
					<?php if ($reason_for_short_notice != '') : ?>
						<tr>
							<td width="150"><strong style="color:red;"> Reason For Short Notice</strong></td>
							<td width="450"><?php echo $reason_for_short_notice ;?></td>
						</tr>
					<?php endif; ?>
				<?php endif; ?>
				
			</tbody>
			<tfoot>
			</tfoot>
		</table>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script></script>
  

</body>
 
</body>
</html>				