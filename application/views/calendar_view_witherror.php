<!DOCTYPE html>
<html>
    <head>
    <title>Full Calendar CRUD</title>
        <meta charset='utf-8' />
        <link href="<?php echo base_url('assets/calendar/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/calendar/css/fullcalendar.min.css')?>" rel='stylesheet' />
        <link href="<?php echo base_url('assets/calendar/css/fullcalendar.print.css')?>" rel='stylesheet' media='print' />
        <link href="<?php echo base_url('assets/calendar/css/bootstrapValidator.min.css')?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/calendar/css/bootstrap-colorpicker.min.css')?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/calendar/css/bootstrap-timepicker.min.css')?>" rel="stylesheet" />

        <script src="<?php echo base_url('assets/calendar/js/moment.min.js')?>"  type="text/javascript"></script>
        <script src="<?php echo base_url('assets/calendar/js/jquery.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/calendar/js/bootstrap.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/calendar/js/bootstrapValidator.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/calendar/js/fullcalendar.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/calendar/js/bootstrap-colorpicker.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/calendar/js/bootstrap-timepicker.min.js')?>" type="text/javascript"></script>
        <script type="text/javascript">
        $(function(){

            var currentDate; // Holds the day clicked when adding a new event
            var currentEvent; // Holds the event object when editing an event
			
            $('#color').colorpicker(); // Colopicker
            $('#time').timepicker({
                minuteStep: 5,
                showInputs: false,
                disableFocus: true,
                showMeridian: false
            });  // Timepicker

            // var base_url='http://localhost/fullcalendar/'; // Here i define the base_url
            // var base_url='<?php echo base_url()?>'; // Here i define the base_url
            var base_url = "<?php echo base_url()?>"; // Here i define the base_url

            // Fullcalendar
            $('#calendar').fullCalendar({
                timeFormat: 'DD-MM-YYYY H(:mm)',
                header: {
                    left: 'prev, next, today',
                    center: 'title',
                    right: 'month, basicWeek, basicDay'
                },
                // Get all events stored in database

                eventLimit: true, // allow "more" link when too many events
                events: "<?php echo site_url('calendar/getEvents')?>",
                // url = "<?php echo site_url('calendar/getEvents')?>";
                // Handle Day Click
                dayClick: function(date, event, view) {
                    currentDate = date.format();
                    // Open modal to add event
                    modal({
                        // Available buttons when adding
                        buttons: 
						{
                            add: 
							{
                                id: 'add-request', // Buttons id
                                css: 'btn-success', // Buttons class
                                label: 'Add' // Buttons label
                            }
                        },
                        title: 'Add Request (' + date.format() + ')' // Modal title
                    });
                },
				
                editable: false, // Make the event DRAGGABLE true 
                eventDrop: function(event, delta, revertFunc) {
				   $.post(base_url + 'calendar/dragUpdateEvent', {
						id: event.request_id,
						date: event.activity_date.format()
					}, function(result){
						if (result)
							alert('Updated');
						else
							alert('Try Again later!');
					});
				},
                // Event Mouseover
                eventMouseover: function(calEvent, jsEvent, view){

                    var tooltip = '<div class="event-tooltip">' + calEvent.request_id + ' '+ calEvent.remarks+ '</div>';
                    $("body").append(tooltip);

                    $(this).mouseover(function(e) {
                        $(this).css('z-index', 10000);
                        $('.event-tooltip').fadeIn('500');
                        $('.event-tooltip').fadeTo('10', 1.9);
                    }).mousemove(function(e) {
                        $('.event-tooltip').css('top', e.pageY + 10);
                        $('.event-tooltip').css('left', e.pageX + 20);
                    });
                },
                eventMouseout: function(calEvent, jsEvent) {
                    $(this).css('z-index', 8);
                    $('.event-tooltip').remove();
                },
                // Handle Existing Event Click
                eventClick: function(calEvent, jsEvent, view) {
                    // Set currentEvent variable according to the event clicked in the calendar
                    currentEvent = calEvent;
                    // Open modal to edit or delete event
                    modal({
                        // Available buttons when editing
                        buttons: {
                            delete: {
                                id: 'delete-event',
                                css: 'btn-danger',
                                label: 'Delete'
                            },
                            update: {
                                id: 'update-event',
                                css: 'btn-success',
                                label: 'Update'
                            }
                        },
                        title: 'Edit Event "' + calEvent.title + '"',
                        event: calEvent
                    });
                }

            });

            // Prepares the modal window according to data passed
            function modal(data) {
                // Set modal title
                $('.modal-title').html("Request " + data.event.request_id);
                // Clear buttons except Cancel
                $('.modal-footer button:not(".btn-default")').remove();
                // Set input values
                $('#title').val(data.event ? data.event.employee_name : '--');
                
				if ( !data.event) {
                    // When adding set timepicker to current time
                    var now = new Date();
                    var time = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' + now.getMinutes() : now.getMinutes());
                } else {
                    // When editing set timepicker to event's time
                    //var time = data.event.date;//.split(' ')[1].slice(0, -3);
                    var time = data.event.start_time;//date.split(' ')[1].slice(0, -3);
                    //time = time.charAt(0) === '0' ? time.slice(1) : time;
                }
				
                $('#time').val(time);
                $('#description').val(data.event ? data.event.activity_status : '');
                $('#color').val(data.event ? data.event.color : '#337ab7');//#3a87ad
                // Create Butttons
                $.each(data.buttons, function(index, button){
                    $('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
                });
                //Show Modal
                $('.modal').modal('show');
            }

            // Handle Click on Add Button
            $('#modal_form').on('click', '#add-request',  function(e){
                if (validator(['title', 'description']))
				{
                    $.post(base_url + 'calendar/addEvent', {
                        title: $('#title').val(),
                        description: $('#description').val(),
                        color: $('#color').val(),
                        date: currentDate + ' ' + getTime()
                    }, function(result){
                        $('.modal').modal('hide');
                        $('#calendar').fullCalendar("refetchEvents");
                    });
                }
            });


            // Handle click on Update Button
            $('.modal').on('click', '#update-event',  function(e)
			{
                if (validator(['title', 'description'])) {
                    $.post(base_url + 'calendar/updateEvent', {
                        id: currentEvent.request_id,
                        title: $('#title').val(),
                        description: $('#description').val(),
                        color: $('#color').val(),
                        date: currentEvent.date.split(' ')[0]  + ' ' +  getTime()
                    }, function(result){
                        $('.modal').modal('hide');
                        $('#calendar').fullCalendar("refetchEvents");
                    });
                }
            });



            // Handle Click on Delete Button
            $('.modal').on('click', '#delete-event',  function(e){
                $.get(base_url+'calendar/deleteEvent?id=' + currentEvent.id, function(result){
                    $('.modal').modal('hide');
                    $('#calendar').fullCalendar("refetchEvents");
                });
            });


            // Get Formated Time From Timepicker
            function getTime() {
                var time = $('#time').val();
                return (time.indexOf(':') == 1 ? '0' + time : time) + ':00';
            }

            // Dead Basic Validation For Inputs
            function validator(elements) {
                var errors = 0;
                $.each(elements, function(index, element){
                    if ($.trim($('#' + element).val()) == '') errors++;
                });
                if (errors) {
                    $('.error').html('Please insert title and description');
                    return false;
                }
                return true;
            }
        });
		
		function add_request()
		{
		    save_method = 'add';
		    $('#form')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string
		    $('#modal_form').modal('show'); // show bootstrap modal
		    $('.modal-title').text('Add Request'); // Set Title to Bootstrap modal title
		}
		
        </script>
        <style>

            body {
                margin: 40px 10px;
                padding: 0;
                font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
                font-size: 14px;
            }
            .fc th {
                padding: 10px 0px;
                vertical-align: middle;
                background:#F2F2F2;
            }
            .fc-day-grid-event>.fc-content {
                padding: 4px;
            }
            #calendar {
                max-width: 900px;
                margin: 0 auto;
            }
            .error {
                color: #ac2925;
                margin-bottom: 15px;
            }
            .event-tooltip {
                width:150px;
                background: rgba(0, 0, 0, 0.85);
                color:#FFF;
                padding:10px;
                position:absolute;
                z-index:10001;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 11px;

            }
            .modal-header
            {
                background-color: #3A87AD;
                color: #fff;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column">
                        <div id='calendar'></div>
                </div>
            </div>
        </div>
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="error"></div>
                        <form class="form-horizontal" id="crud-form">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="title">Title</label>
                                <div class="col-md-4">
                                    <input id="title" name="title" type="text" class="form-control input-md" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="time">Time</label>
                                <div class="col-md-4 input-append bootstrap-timepicker">
                                    <input id="time" name="time" type="text" class="form-control input-md" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="description">Description</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="color">Color</label>
                                <div class="col-md-4">
                                    <input id="color" name="color" type="text" class="form-control input-md" readonly="readonly" />
                                    <span class="help-block">Click to pick a color</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
		
		<!-- ADD modal -->
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
							<div class="form-body">
								<div class="form-group"><label class="control-label col-md-3">Activity Type</label><div class="col-md-9">
									<select name="activity_type" class="form-control">
										<option value="">--Select Activity Type--</option>
										<option value="Site Survey">Site Survey</option>
										<option value="Installation">Installation</option>
										<option value="Patching">Patching</option>
										<option value="Delivery">Delivery</option>
										<option value="Pull-out">Pull-out</option>
										<option value="Integration">Integration</option>
										<option value="etc.">Etc.</option>
									</select>
									<span class="help-block"></span>
								</div></div>
								<div class="form-group"><label class="control-label col-md-3">Criticality</label><div class="col-md-9">
									<select name="criticality" class="form-control">
										<option value="">--Select Criticality--</option>
										<option value="Critical">Critical</option>
										<option value="Major">Major</option>
										<option value="Minor">Minor</option>
									</select>
									<span class="help-block"></span>
								</div></div>
								<div class="form-group"><label class="control-label col-md-3">Activity Description</label><div class="col-md-9"><input name="activity_desc" placeholder="Activity Description" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Project Name</label><div class="col-md-9"><input name="project_name" placeholder="Project Name" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Employee ID</label><div class="col-md-9"><input name="employee_id" placeholder="Employee ID" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Employee Name</label><div class="col-md-9"><input name="employee_name" placeholder="Employee Name" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Department</label><div class="col-md-9"><input name="department" placeholder="Department" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Discipline</label><div class="col-md-9">
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
										<option value="Etc.">Etc.</option>
									</select>
									<span class="help-block"></span>
								</div></div>
								<div class="form-group"><label class="control-label col-md-3">NE Involved</label><div class="col-md-9"><input name="ne_involved" placeholder="NE Involved" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Date</label><div class="col-md-9">
									<input name="date" placeholder="Date yyyy-mm-dd" class="form-control datepicker" type="text"><span class="help-block"></span>
								</div></div>
								<div class="form-group"><label class="control-label col-md-3">Start Time</label><div class="col-md-9">
									<input name="start_time" placeholder="Start Time HH:ii P" class="form-control datetimepicker" type="text"/><span class="help-block"></span>
								</div></div>
								<div class="form-group"><label class="control-label col-md-3">End Time</label><div class="col-md-9">
									<input name="end_time" placeholder="End Time HH:ii P" class="form-control datetimepicker" type="text"/><span class="help-block"></span>
								</div></div> 
								<div class="form-group"><label class="control-label col-md-3">Activity Date</label><div class="col-md-9">
									<input name="activity_date" placeholder="Activity Date yyyy-mm-dd" class="form-control datepicker" type="text"><span class="help-block"></span>
								</div></div>
								<div class="form-group"><label class="control-label col-md-3">GT Project Proponent</label><div class="col-md-9"><input name="gt_project_prop" placeholder="GT Project Proponent" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Contact #</label><div class="col-md-9"><input name="contact_num_prop" placeholder="Contact Number GT Proponent" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">GT Representative</label><div class="col-md-9"><input name="gt_rep" placeholder="GT Representative Attending the Activity" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Contact #</label><div class="col-md-9"><input name="contact_num_rep" placeholder="Contact Number GT Representative" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Vendor Representative</label><div class="col-md-9"><input name="vendor_rep" placeholder="Vendor Representative Attending the Activity" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Contact #</label><div class="col-md-9"><input name="contact_num_vendor" placeholder="Contact Number Vendor" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">Reference Docs (Attachment)</label><div class="col-md-9">
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
								<div class="form-group"><label class="control-label col-md-3">SO#</label><div class="col-md-9"><input name="so_ref_number" placeholder="SO Reference Number" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class="form-group"><label class="control-label col-md-3">TRS Config #</label><div class="col-md-9"><input name="trs_config_number" placeholder="TRS Config Number" class="form-control" type="text"><span class="help-block"></span></div></div>
								<div class=""><input name="_status" placeholder="Approval Status" class="form-control" type="hidden"></div>
								<div class="form-group"><label class="control-label col-md-3">Activity Status</label><div class="col-md-9">
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
									<label class="control-label col-md-3">Remarks</label>
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
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
    </body>
</html>



