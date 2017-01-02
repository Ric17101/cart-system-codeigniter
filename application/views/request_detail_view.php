<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
    
    <?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
		<div class="content">
            <div class="modal-header">
                <h3 id="req">Request Details</h3>
				<p> ID: <strong><?php echo $request_id ?></strong></p>
				<div style="text-align: right;" id="panelButtons">
					<?php if ($_SESSION['is_approver'] === true) : ?>
						<button type="button" id="btnViewActionAccept" class="btn btn-primary"> Accept</button>
						<!--<button type="button" id="btnViewActionReject" class="btn btn-primary"> Reject</button> -->
						<button type="button" id="btnViewActionCancel" class="btn btn-danger"> Cancel</button>
					<?php else : ?>
						<button type="button" id="btnEditAction" class="btn btn-primary"> Edit</button>
					<?php endif; ?>
					<button type="button" id="btnViewDelete" onclick="delete_request(<?php echo $request_id ?>);" class="btn btn-danger"> Delete</button>
					<a id="btnViewDetails" role="button" class="btn btn-default btn-small" href="<?= base_url('request') ?>"> Return</a>
				</div>
            </div>
            <div class="modal-body form" id="panelDetail">
                <form action="#" id="" class="form-horizontal">
                    <input type="hidden" value="" name="request_id"/> 
                    <div class="form-body">
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Request ID</label><label style="font-weight:normal" for="request_id" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Activity Type</label><label style="font-weight:normal" for="activity_type" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Activity Requirement Checklist</label>
							<div id="chekclist_div"></div>
						</div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Request Status</label><label style="font-weight:normal" for="request_status" ></label></div>
                        <div class="form-group"><label class="col-md-4" style="text-align: right;">Severity</label><label style="font-weight:normal" for="criticality" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Activity Description</label><label style="font-weight:normal" for="activity_desc" ></label></div>
                        <div class="form-group"><label class="col-md-4" style="text-align: right;">Project Name</label><label style="font-weight:normal" for="project_name" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Requestor ID</label><label style="font-weight:normal" for="employee_id" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Requestor Name</label><label style="font-weight:normal" for="employee_name" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Department</label><label style="font-weight:normal" for="department" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Site Name</label><label style="font-weight:normal" for="site_name" ></label></div>
                        <div class="form-group"><label class="col-md-4" style="text-align: right;">Discipline</label><label style="font-weight:normal" for="discipline" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">NE Involved</label><label style="font-weight:normal" for="ne_involved" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Date</label><label style="font-weight:normal" for="date" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Start Time</label><label style="font-weight:normal" for="start_time" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">End Time</label><label style="font-weight:normal" for="end_time" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Activity Date</label><label style="font-weight:normal" for="activity_date" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Reason for short notice</label><label style="font-weight:normal" for="reason_for_short_notice" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">GT Project Proponent</label><label style="font-weight:normal" for="gt_project_prop" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Contact #</label><label style="font-weight:normal" for="contact_num_prop" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">GT Representative</label><label style="font-weight:normal" for="gt_rep" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Contact #</label><label style="font-weight:normal" for="contact_num_rep" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Vendor Representative</label><label style="font-weight:normal" for="vendor_rep" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Contact #</label><label style="font-weight:normal" for="contact_num_vendor" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Reference Docs (Attachment)</label><label style="font-weight:normal" for="reference_docs" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">GT Representative</label><label style="font-weight:normal" for="gt_rep" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">SO#</label><label style="font-weight:normal" for="so_ref_number" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">TRS Config #</label><label style="font-weight:normal" for="trs_config_number" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Activity Status</label><label style="font-weight:normal" for="activity_status" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Status</label><label style="font-weight:normal" for="_status" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Approver ID</label><label style="font-weight:normal" for="approve_by" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Approval Notes</label><label style="font-weight:normal" for="approval_notes" ></label></div>
						<div class="form-group"><label class="col-md-4" style="text-align: right;">Remarks</label><label style="font-weight:normal" for="remarks" ></label></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="panelFooter">
                <a id="btnViewDetails" role="button" class="btn btn-default btn-small" href="<?= base_url('request') ?>"> Return</a>
            </div>
        </div><!-- /.request-content -->
        
		<table id="table" style="display: none"></table>
        <?php else : ?>
            <?php if (isset($error)) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
					<a href="<?= base_url('register') ?>">Register</a> or 
					<a href="<?= base_url('login') ?>">Login</a>.
                </div>
            </div>
			<?php endif; ?>
    <?php endif; ?>
    </div>
</div>

<!-- Bootstrap modal -->
<!-- Request Approval modal -->
<div class="modal fade" id="modal_form_approve" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Approve Request?</h3>
            </div>
            <div class="modal-body form_approve">
                <form action="#" id="form_approve" class="form-horizontal">
                    <input type="hidden" value="" name="request_idd" />
					<input type="hidden" value="" name="action" />
					<div class="form-group">
						<label class="control-label col-md-3">Request ID: </label>
						<div class="col-md-9">
							<label style="font-weight:normal" for="request_id" class="form-control"></label>
							<span class="help-block"></span>
						</div>
						<label class="control-label col-md-3">Approval Notes</label>
						<div class="col-md-9">
							<textarea name="approval_notes" placeholder="Your Notes here" class="form-control"></textarea>
							<span class="help-block"></span>
						</div>
					</div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave2" onclick="save()" class="btn btn-primary">Send Email and Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EDIT modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Request Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="request_id"/> 
					<input type="hidden" value="" name="severity_type"/>
                    <div class="form-body">
                        <div class="form-group"><label  id="activity_typeLabel" class="control-label col-md-3">Activity Type</label><div class="col-md-9">
                            <select name="activity_type" id="activity_type" class="form-control">
                                <option value="">--Select Activity Type--</option>
                            </select>
                            <span class="help-block"></span>
                        </div></div>
						<div class="form-group">
							<label class="control-label col-md-3"></label>
							<div class="col-md-9">
								<div>
									<label id="activity_requirement_checklistLabel">Activity Requirements Checklist
									<span style='font-weight:normal'> [ Must be completed to proceed with activity request ]</span></label>
								</div>
								<div id="acoList"></div>
								<span class="help-block"></span>
							</div>
						</div>
                        <div class="form-group"><label id="criticalityLabel" class="control-label col-md-3">Severity</label><div class="col-md-9">
                            <select name="criticality" class="form-control">
                                <option value="">--Select Severity--</option>
                                <option value="Critical">Critical</option>
                                <option value="Major">Major</option>
                                <option value="Minor">Minor</option>
                            </select>
                            <span class="help-block"></span>
                        </div></div>
                        <div class="form-group"><label id="activity_descLabel" class="control-label col-md-3">Activity Description</label><div class="col-md-9"><input name="activity_desc" placeholder="Activity Description" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="project_nameLabel" class="control-label col-md-3">Project Name</label><div class="col-md-9"><input name="project_name" placeholder="Project Name" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="departmentLabel" class="control-label col-md-3">Department</label><div class="col-md-9"><input name="department" placeholder="Department" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="site_nameLabel" class="control-label col-md-3">Site Name</label><div class="col-md-9">
                            <select name="site_name" id="site_name" class="form-control">
                                <option value="">--Select Site Name--</option>
                            </select>
                            <span class="help-block"></span>
                        </div></div>
						<div class="form-group"><label id="disciplineLabel" class="control-label col-md-3">Discipline</label><div class="col-md-9">
                            <select name="discipline" class="form-control">
                                <option value="">--Select Discipline--</option>
                                <option value="Wireless Core">Wireless Core</option>
                                <option value="Wireline Core">Wireline Core</option>
                                <option value="Wireless Access">Wireless Access</option>
                                <option value="Wireline Access">Wireline Access</option>
                                <option value="IN">IN</option>
                                <option value="VAS">VAS</option>
                                <option value="IP Core">IP Core</option>
                                <option value="IP RAN">IP RAN</option>
								<option value="Transmission">Transmission</option>
                                <option value="Etc.">Etc.</option>
                            </select>
                            <span class="help-block"></span>
                        </div></div>
                        <div class="form-group"><label id="ne_involvedLabel" class="control-label col-md-3">NE Involved</label><div class="col-md-9"><input name="ne_involved" placeholder="NE Involved" class="form-control" type="text"><span class="help-block"></span></div></div>
                        
                        <div class="form-group"><label id="start_timeLabel" class="control-label col-md-3">Start Time</label><div class="col-md-9">
                            <input name="start_time" id="start_time" placeholder="Start Time HH:ii P" class="form-control datetimepicker" type="text"/><span class="help-block"></span>
                        </div></div>
                        <div class="form-group"><label id="end_timeLabel" class="control-label col-md-3">End Time</label><div class="col-md-9">
                            <input name="end_time" id="end_time" placeholder="End Time HH:ii P" class="form-control datetimepicker" type="text"/><span class="help-block"></span>
                        </div></div> 
                        <div class="form-group"><label id="activity_dateLabel" class="control-label col-md-3">Activity Date</label><div class="col-md-9">
                            <input name="activity_date" id="activity_date" placeholder="Activity Date yyyy-mm-dd" class="form-control datepicker" type="text"><span class="help-block"></span>
                        </div></div>
						<div id="short_notice" class="form-group">
							<label id="reason_for_short_noticeLabel" class="control-label col-md-3" style="color: red;" >Reason for short notice</label><div class="col-md-9"><input name="reason_for_short_notice" placeholder="Reason for short notice" class="form-control" type="text"><span class="help-block"></span></div>
						</div>
                        <div class="form-group"><label id="gt_project_propLabel" class="control-label col-md-3">GT Project Proponent</label><div class="col-md-9"><input name="gt_project_prop" placeholder="GT Project Proponent" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="contact_num_propLabel" class="control-label col-md-3">Contact #</label><div class="col-md-9"><input name="contact_num_prop" placeholder="Contact Number GT Proponent" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="gt_repLabel" class="control-label col-md-3">GT Representative</label><div class="col-md-9"><input name="gt_rep" placeholder="GT Representative Attending the Activity" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="contact_num_repLabel" class="control-label col-md-3">Contact #</label><div class="col-md-9"><input name="contact_num_rep" placeholder="Contact Number GT Representative" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="vendor_repLabel" class="control-label col-md-3">Vendor Representative</label><div class="col-md-9"><input name="vendor_rep" placeholder="Vendor Representative Attending the Activity" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="contact_num_vendorLabel" class="control-label col-md-3">Contact #</label><div class="col-md-9"><input name="contact_num_vendor" placeholder="Contact Number Vendor" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="reference_docsLabel" class="control-label col-md-3">Reference Docs (Attachment)</label><div class="col-md-9">
                            <select name="reference_docs" class="form-control">
                                <option value="">--Select Doc Type--</option> 
                                <option value="FIO">FIO</option>
                                <option value="Network Diagram">Network Diagram</option>
                                <option value="MOP">MOP</option>
                                <option value="SLD">SLD</option>
                                <option value="EWP">EWP</option>
                                <option value="Etc.">Etc.</option>
                            </select>
                            <span class="help-block"></span>
                        </div></div>
                        <div class="form-group"><label id="so_ref_numberLabel" class="control-label col-md-3">SO#</label><div class="col-md-9"><input name="so_ref_number" placeholder="SO Reference Number" class="form-control" type="text"><span class="help-block"></span></div></div>
                        <div class="form-group"><label id="trs_config_numberLabel" class="control-label col-md-3">TRS Config #</label><div class="col-md-9"><input name="trs_config_number" placeholder="TRS Config Number" class="form-control" type="text"><span class="help-block"></span></div></div>
							<div class=""><input name="_status" placeholder="Approval Status" class="form-control" type="hidden"></div>
                        <div class="form-group"><label id="activity_statusLabel" class="control-label col-md-3">Activity Status</label><div class="col-md-9">
                            <select name="activity_status" class="form-control">
                                <option value="">--Select Status--</option>  
                                <option value="Completed">Completed</option>
                                <option value="Partially Completed">Partially Completed</option>
                                <option value="Deferred">Deferred</option>
                                <option value="Deferred">Cancel</option>
                            </select>
                            <span class="help-block"></span>
                        </div></div>
                        <div class="form-group">
                            <label id="Labelremarks" class="control-label col-md-3">Remarks</label>
                            <div class="col-md-9">
                                <textarea name="remarks" placeholder="Remarks here" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
