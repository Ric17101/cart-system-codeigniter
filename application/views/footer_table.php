	<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	</main><!-- #site-content -->

	<footer id="site-footer" class="footer wrapper" role="contentinfo" style="padding: 60px;">
		<div class="container ">
			<p class="text-muted navbar-text">Centralized Activity Reqest Tool &copy; 2016</p>
		</div>
	</footer><!-- #site-footer -->

	<!-- css DATATABLES -->
	<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet" />
	<!-- <link href="< ?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet" />-->
	<link href="<?php echo base_url('assets/datatables/extension/css/dataTables.min.css')?>" rel="stylesheet" />
	<!--<link href=< ?php echo base_url('assets/datatables/extension/css/buttons.dataTables.min.css')?>" rel="stylesheet" />-->
	
	<!-- js -->
	<script src="<?php echo base_url('assets/jquery/jquery-1.12.3.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('assets/jquery/waiting_for.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>

	<script src="<?php echo base_url('assets/datatables/extension/js/datatables.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/extension/js/dataTables.buttons.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/js/pdfmake.min.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-timepicker/js/Moment.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-timepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
	
	<!-- Calendar Imports CSS -->
	<link href="<?php echo base_url('assets/calendar/css/fullcalendar.min.css')?>" rel='stylesheet' />
	<link href="<?php echo base_url('assets/calendar/css/fullcalendar.print.css')?>" rel='stylesheet' media='print' />
	<link href="<?php echo base_url('assets/calendar/css/bootstrapValidator.min.css')?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/calendar/css/bootstrap-colorpicker.min.css')?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/calendar/css/bootstrap-timepicker.min.css')?>" rel="stylesheet" />
	
	<!-- Calendar Imports JScript -->
	<script src="<?php echo base_url('assets/calendar/js/bootstrapValidator.min.js')?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/calendar/js/fullcalendar.min.js')?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/calendar/js/bootstrap-colorpicker.min.js')?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/calendar/js/bootstrap-timepicker.min.js')?>" type="text/javascript"></script>
	
	<!-- Modal SetUp -->
	<script src="<?php echo base_url('assets/modal/bootstrap-dialog.js')?>"></script>
	<link href="<?php echo base_url('assets/modal/bootstrap-dialog.css')?>" rel="stylesheet" />
	
	<script type="text/javascript">
		var save_method; //for save method string
		var table;
		var action;
		var request_id_;
		var google_calendar_source = [];
		var divClone = $("#calendar").clone(); // Do this on $(document).ready(function() { ... }) // JUST to reuse the div content for the #calendar ID
		
		$(document).ready(function() {
			init_session_timer();
			test_user_loggedin_for_session_timer();
					$('#calendar').fullCalendar('render'); // 'today'
		});
		
		function test_user_loggedin_for_session_timer()
		{
			error_msg = <?php echo $_SESSION['logged_in'] ?>;
			if (error_msg == true)
			{
				dataTable_setup();
				document.getElementsByClassName("fg-button").className += " btn btn-danger";
			}
		}
		
		function init_session_timer()
		{
			setInterval(function() {
				// Do something every 1 minute 
				$.ajax(
				{
					type : 'POST',
					url  : '<?php echo site_url("request/check_session")?>',
					success : function(data){
						//alert(data);
						if (data) { 
						   //your session is not expired
						} else {
						   //your session is already expired
							window.location.href="login"; // or you can redirect from here also
						}
					}
				});
			}, 60000); // 60000 1 min
		}		
		
		function dataTable_setup()
		{
			//datatables
			table = $('#table').removeAttr('width').DataTable({ 
				scrollX : true, // Scollable Hozontal
				
				"processing" : true, //Feature control the processing indicator.
				"serverSide" : true, //Feature control DataTables' server-side processing mode.
				"order" : [], //Initial no order.
				"language": {
					"info" : "Showing _END_ out of _TOTAL_ requests",
					"infoEmpty" : "Showing 0 requests",
					// "infoFiltered" : "(filtered from _MAX_ total requests)",
					"infoFiltered" : "", // NO FILTER STATUS
				},
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url" : "<?php echo site_url('request/ajax_list')?>",
					"type" : "POST"
				},

				//Set column definition initialisation properties.
				"aoColumnDefs" : [
					{
						"targets" : [ 0 ], //first column ,  last column -1
						"orderable" : false, //set not orderable
						"width" : "250",  // set fixed width of last col
						
					},
					{
						"width" : "150",  // set fixed width of last col
						targets : [ 10, 11, 12 ],
					}
				], 
				"bautoWidth": false,
				"aLengthMenu" : [[10, 25, 50, -1], [10, 25, 50, "All"]], // modify the Menu at the Upper Left Corner
			});
			
			$('#table tbody').on('click', 'tr', function () {
				// if ($(this).hasClass('selected')) {
					// $(this).removeClass('selected');
				// }
				// else {
					// table.$('tr.selected').removeClass('selected');
					// $(this).addClass('selected');
				// }
				$(this).toggleClass('selected'); // FOR MULTIPLE SELECTION of rows in dtable

			});
			$('#button').click(function () {
				table.row('.selected').remove().draw(false);
			});
				
			//EXPORT Buttons
			var dataTablesColumn = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
			var buttons = new $.fn.dataTable.Buttons(table, {
				buttons : [{
					extend : 'collection',
					text : '<i class="glyphicon glyphicon-download-alt"></i> Export',
					className : 'btn btn-primary',
					buttons : [
						// 'copyHtml5', //the three below is defined just to exclude the first column in export
						// 'csvHtml5',
						{
							extend : 'copyHtml5',
							text : 'Copy to clipboard',
							exportOptions : {
								columns :  dataTablesColumn// includ only specific column in excel
							}
						},
						{
							extend : 'csvHtml5',
							text : 'Save to CSV',
							exportOptions : {
								columns : dataTablesColumn // includ only specific column in excel
							}
						},
						{
							extend : 'excelHtml5',
							text : 'Save to Excel',
							exportOptions : {
								modifier : {
									search : 'none'
								},
								columns : dataTablesColumn // includ only specific column in excel
							}
						}]
					}
				]
			}).container().appendTo($('#exportButtonDiv'));
			
			table.buttons().container()
				.appendTo( '#table_wrapper btn btn-success' );

			//datepicker
			$('.datepicker').datepicker({
				autoclose : true,
				format : "yyyy-mm-dd",
				todayHighlight : true,
				orientation : "top auto",
				todayBtn : true,
				todayHighlight : true,  
			});

			// Time picker for Start Time and End Time ///////add this to ajax datatable
			// Using bootstrap-datetimepicker.min.css, bootstrap-datetimepicker.min.js, Modal.js
			//From https://eonasdan.github.io/bootstrap-datetimepicker/
			$('.datetimepicker').datetimepicker({
				format : 'LT'
			});
			//populateSiteNameDropDownList(); // TO POPULATE THE AREA DDList at MODAL FORM
			populateActivityTypeDropDownList(); // TO POPULATE THE Activity Type DDList at MODAL FORM
			//reload_div.style.display = "none"; // Hide the display for the reload-animation
			testActivityTypeAndDateForShortNotice(); //
			populateCalendarDropDownList();
			clearOnCloseCalendarFrame();
			onActivityOnChangeListener();
		}
		
		/* NOT USED */
		function testIfHasSelectedRows()
		{
			$('#table td').click( function () {
				var $rows = table.$('tr.selected');
					
				if($rows.length){ // If some rows are selected
					$('#btnDeselectAction').show();
				} else {// Otherwise, if no rows are selected
					$('#btnDeselectAction').hide();
				}
			} );
		}
		
		function deselect()
		{
			var table = $('#table').DataTable();
			table.rows('tr').deselect();
		}
		
		/*
			PAGE and TABLE
		*/
		function onActivityOnChangeListener()
		{
			$("#activity_type").on('change', function() { /* DropDownList for Activity Type has changed */
				append_activity_checklist_checkBox();
				//setButtonSaveColor();
			});
		}
		
		/*
			PAGE and TABLE
		*/
		function append_activity_checklist_checkBox()
		{
			var activity_type_dd = document.getElementById("activity_type");
			// var activity_type = activity_type_dd.options[activity_type_dd.selectedIndex].value;
			// test_short_notice(activity_type);
			addCheckbox(activity_type_dd.value);
		}
		
		/*
			PAGE and TABLE
		*/
		function addCheckbox(activity_type) {
			var container = $("#acoList");
			// var inputs = container.find('input');
			// var id = inputs.length+1;

			// $('<div class="checkbox">', {}).appendTo(container);
			// $('<input />', {
				// type : 'checkbox', 
				// id : 'cb'+id, 
				// value : name 
			// }).appendTo(container);
			// $('<label />', {
				// 'for' : 'cb' + id, 
				// text : name 
			// }).appendTo(container);
			// $('</div>', {}).appendTo(container);
			//$('#activity_requirement_checklistLabel').html(activity_type + " Activity Requiremnet Checklist<span style='font-weight:normal'>[check at least one]</span>");
			setDefaultactivity_requirement_checklist();
			var postData = {
				'activity_type' : activity_type,
			};
			$.ajax({
                type : "GET",
                url : "<?=base_url()?>request/ajax_activity_type_checklist/",
                data : postData,
                dataType : 'json',
                success : function(data){
					//container.html("");
					//console.log(data);
                    for (i in data)
					{
						container.append("<div class='checkbox'><label><input type='checkbox' name='activity_type_requirement_checklist[]' value='" + data[i]['id'] + "' id='checkbox" + data[i]['id'] +  "'>" + data[i]['activity_type_prerequisite'] + "</label></div>");
					}
                }
            });
			/*
				<div class="checkbox">
				  <label>
					<input type="checkbox" value="">
					Option one is this and that&mdash;be sure to include why it's great
				  </label>
				</div>
			*/
		}
		
		/*
			PAGE and TABLE
		*/
		function getActivityListByIDs(strChecklist) {
			var container = $("#chekclist_div");
			//$('#activity_requirement_checklistLabel').html(activity_type + " Activity Requiremnet Checklist");
			
			var postData = {
				'checklist' : strChecklist,
			};
			$.ajax({
                type : "GET",
                url : "<?=base_url()?>request/ajax_get_activity_requirement_checklist_as_array/",
                data : postData,
                dataType : 'json',
                success : function(data) {
					container.html("");
					//console.log(data);
                    for (i in data)
					{
						//<label style="font-weight:normal" for="activity_type_requirement_checklist" ></label>
						console.log(data[i]);
						//$("#activity_type_requirement_checklist").append(data[i]);
						if (i != 0)
							container.append("<label class='col-md-4' style='text-align: right;'></label>");
						container.append("<label style='font-weight:normal' >" + (data[i] == 'null' || data[i] == "" ? "" : data[i]) + "</label><br/>");
					}
					
                }
            });
		}
		
		
		function populateCalendarDropDownList()
		{
			$.ajax({
                type : "GET",
                url : "<?=base_url()?>request/ajax_site_list/",
                data : '',
                dataType : 'json',
                success : function(data){
                    //$("#site_name").append('<option selected>State</option>');
                    for(i in data)
					{
						$("#site_name").append("<option value=\""+data[i]['site_name']+"\">"+data[i]['site_name']+"</option>"); /* Populate Ajax Site List to DropDown */
						//google_calendar_source[data[i]['id']] = data[i]['google_calendar_frame']; /* Populate array for easy retrieval */
						$("#calendar_link").append( '<li><a onclick="return showCalendarModal('+data[i]['id']+',\''+data[i]['site_name']+'\');">' + data[i]['site_name'] + '</a></li>' );
                        //$("#google_calendar_link").append("<option value=\""+data[i]['id']+"\">"+data[i]['site_name']+"</option>");
					}
                }
            });
		}
		
		/* 
			param divID is not used
			divClone was initialized at outside documnet(...)
		*/
		function clearBox(divID)
		{
			//var divClone = $("#calendar").clone();
			$("#calendar").html(""); // Change the content temporarily

			// Use this command if you want to keep divClone as a copy of "#some_div"
			$("#calendar").replaceWith(divClone.clone()); // Restore element with a copy of divClone

			// Any changes to "#some_div" after this point will affect the value of divClone
			$("#calendar").replaceWith(divClone); // Restore element with divClone itself
			
			// $('#' + divID).empty();
			// $("#" + divID).removeClass();
			//document.getElementById(divID).innerHTML = "";
		}
		
		/*
		 * Sets the SOURCE of modal iFrame to EMPTY
		 * OnClose click 
		 */
		function clearOnCloseCalendarFrame()
		{
			/*	
				Detecting OnClose of Modals By ID
				show.bs.modal
					This event fires immediately when the show instance method is called. If caused by a click, the clicked element is available as the relatedTarget property of the event.
				shown.bs.modal
					This event is fired when the modal has been made visible to the user (will wait for CSS transitions to complete). If caused by a click, the clicked element is available as the relatedTarget property of the event.
				hide.bs.modal
					This event is fired immediately when the hide instance method has been called.
				hidden.bs.modal 
					This event is fired when the modal has finished being hidden from the user (will wait for CSS transitions to complete). loaded.bs.modal This event is fired when the modal has loaded content using the remote option.
			*/
			$('#modal_calendar_link_area').on('hidden.bs.modal', function (e) {
				// do something...
				//var frame_source = document.getElementById('calendar_link_frame');
				//clearBox('calendar');
				//frame_source.src = "about:blank";
				//alert("Modal Close Fired!!!");
			});
		}
		
		/*
		 * Show the Google Modal with Source from Google Calendar for the Frame
		 * Triggered onClick of the Dropdownlist Calendar - Site Name
		 */
		function showCalendarModal(siteID, siteName)
		{
			document.getElementById("calendar_link_area").innerHTML = "HEO "+siteName+" CALENDAR";
			clearBox('calendar'); /* Clear content and duplicate the calendar as copy to reuse */
			setCalendar(siteID); /* Set Calendar Data*/
			
			/* Remove first the content of the iFrame */
			//var frame_source = document.getElementById('calendar_link_frame');
			//frame_source.src = "about:blank";
			
			/* Show the content of the Frame Source*/
			var frame_modal = $('#modal_calendar_link_area');
			frame_modal.modal('show');
			//frame_source.src = google_calendar_source[id];
		}
		
		/* 
			To pre-populate the content of option dropdown in the form create/add request (on PAGE and TABLE)
			NOT USED - Intigrated with populateGoogleCalendarDropDownList()
			PAGE and TABLE
		*/
		function populateSiteNameDropDownList()
		{
			$.ajax({
                type : "GET",
                url : "<?=base_url()?>request/ajax_site_list/",                  //the script to call to get data
                data : '',                        //you can insert url argumnets here to pass to api.php
                dataType : 'json',                //data format
                success : function(data){    //on recieve of reply
                    //$("#site_name").append('<option selected>State</option>');
                    for(i in data)
                        $("#site_name").append("<option value=\""+data[i]['site_name']+"\">"+data[i]['site_name']+"</option>");
                }
            });
		}
		
		/* To pre-populate the content of option dropdown in the form create/add request(on PAGE and TABLE)*/
		function populateActivityTypeDropDownList()
		{
			$.ajax({           
                type : "GET",
                url : "<?=base_url()?>request/ajax_activity_type_list/",                  //the script to call to get data          
                data : '',                        //you can insert url argumnets here to pass to api.php
                dataType : 'json',                //data format      
                success : function(data){    //on recieve of reply
                    //$("#site_name").append('<option selected>State</option>');
                    for(i in data) 
                        $("#activity_type").append("<option value=\""+data[i]['activity_type']+"\">"+data[i]['activity_type']+"</option>");
                }
            });
		}
		
		/*
			Test Before Submit
			PAGE and TABLE
		*/
		var _dateIsValidColor;
		var _dateIsValidCount;
		var _error_msg_color;
		var _error_msg_count;
		var _msg_flag_color;
		var _msg_flag_count;
		var _date;
		function testDateFor_Submission()
		{
			var date = document.getElementById("activity_date").value;
			var date2 = $("input[id='activity_date']").val();
			//console.log(date);
			_date = date;
			testCalendarDateColor(OnSuccess_testCalendarDateColor); // Date has been blocked by the approver
			testCalendarDateCount(OnSuccess_testCalendarDateCount); //// DATE has more than 3 window period requests
			if (date == 'NaN' || date == null || date == 'null' || date == '') // TEST the dateInput if blank or NULL before sending the request
				_dateIsValidColor = 1;
		}
		
		/*
			Usually called on Change of Date and Time
			NOT USED
		*/
		function testOnChangeOfFormElements(){
			// var activity_type_dd = document.getElementById("activity_type");
			// var activity_type = activity_type_dd.options[activity_type_dd.selectedIndex].value; // I DON't know what is the error on this, should check this sometime			
			//test_short_notice(activity_type);
			//testDateFor_Submission();	
		}
		
		/* 
			Short notice on the form OnChange
			PAGE AND TABLE
		*/
		function testActivityTypeAndDateForShortNotice()
		{
			$("#short_notice").hide(); // Should I delete this line? since sir oliver not using it
			$('.datepicker').on('changeDate', function(ev) { // #activity_date... since it is triggered three time, I just used the changeDate
				testDateFor_Submission();
			});
			
			//change keydown paste input 
			//keydown paste input
			$("#start_time").on('blur', function(){// start_time
				testDateFor_Submission();
			});
			
			$("#end_time").on('blur', function() { // end_time
				testDateFor_Submission();
			});
			
			$("#site_name").on("change", function() { // site_name
				testOnChangeOfFormElements();
			});
			
			$("#activity_type").on('change', function() { /* DropDownList for Activity Type has changed */
				testOnChangeOfFormElements();
				//setButtonSaveColor();
			});
			
			//$('input[name="activity_type_requirement_checklist[]"]:checked')
			//$("input[name='activity_type_requirement_checklist[]']").prop(setButtonSaveColor());
			//$("input[name='activity_type_requirement_checklist[]']").prop('checked', true);
			// $("input[name='activity_type_requirement_checklist[]']").each(function(){
				 // alert($(this).val());
			// });
		}
		
		/* NOT WORKING NOR USED */
		function checkBoxEventClickListener()
		{
			/*
			//class='checkboxActPreReq'
			jQuery(function () {
			// Whenever any of these checkboxes is clicked
				$("input.checkboxActPreReq").click(function () {
					//alert("it works");
					// Loop all these checkboxes which are checked
					$("input.checkboxActPreReq:checked").each(function(){
						alert("it works");
						// Use $(this).val() to get the Bike, Car etc.. value
					});
				})
			});
			*/
		}
		
		/*
			Set the Button Color/Class as user input their Activity Type {Prerequisites}
			PAGE 
			NOT USED
		*/
		function setButtonSaveColor()
		{
			// alert("Buttons Color");
			/*if(isCheckedAtLeastOne())
				document.getElementById("btnSave").className = "btn btn-primary";
			else
				document.getElementById("btnSave").className = "btn btn-default";
			*/
		}
		
		/*
			Not USED
		*/
		function setButtonSaveColorThis(cb)
		{
			alert("Buttons Color");
		}
		
		/*
		  PAGE AND TABLE
		  NOT USE
		*/
		function isShortNotice()
		{
			var reason_for_short_notice = $("input[id=reason_for_short_notice]").val();
			var activity_date = $("input[id=activity_date]").val();
			//var = stite_name = document.getElementById("activity_type").options[activity_type_dd.selectedIndex].value;
			/* Do the thing if it has value */
			if (activity_date != '')
			{
				var start_time = $("input[id=start_time]").val();
				var end_time = $("input[id='end_time']").val();
				
				var time = convertTo24TImeFormat(start_time);
				var is_short_notice = dateTimeDifferenceAgainstNow(activity_date.replace('-', '/') + ' ' + time);
				if (is_short_notice == true)
					return true;
			}
			return false;
		}
		
		/* 
			Return True or False
			TRUE - if less than 24 Hours
			FALSE - greate than 24 hrs - therefore show the Reason for short notice TextBox in RED
			PAGE AND TABLE
		*/
		function dateTimeDifferenceAgainstNow(activity_date)
		{
			var today = new Date();
			// if (new Date(activity_date) < today) // if date is ahead of today
				// return false;
			var diff = Math.abs(new Date(activity_date) - today);
			var minutes = Math.floor((diff/1000)/60);
			//alert('TEST4: minutes: '+ minutes +' hours: '+ minutes/60);
			return (((minutes/60) < 24 )? true : false);
		}
		
		/* 
			Convert the time format from STRING to TIME format 
			PAGE AND TABLE
		*/
		function convertTo24TImeFormat(time)
		{
			return moment(time, ["h:mm A"]).format("HH:mm:ss");
		}

		/*
			Get the value of severity Type toolTip text LABEL
			Test if minor | major | critical (HIDDEN Value)
			Sets the short_notice textField to hide() if minor else show()
			PAGE AND TABLE
			NOT USED removed/requested by Sir Onliver
		*/
		function testSeverityOfActivityType()
		{
			var severity = $('[name="severity_type"]').val();
			var stite_name_dd = document.getElementById("site_name");
			var stite_name = stite_name_dd.options[stite_name_dd.selectedIndex].value;
			//alert(stite_name);
			
			if ((severity == 'major' || severity == 'critical') /*&& isShortNotice()*/ && (stite_name == 'CARMONA' || stite_name == 'BACOOR'))
			{
				$("#short_notice").show();
			}
			else
			{
				$("#short_notice").hide();
				$("input[name=reason_for_short_notice]").val('');
			}
		}
		
		/*
		  PAGE AND TABLE
		  NOT USED?
		*/
		function test_short_notice(activity_type)
		{
			var postData = {
				'activity_type' : activity_type
			};
			$.ajax({
				url : "<?php echo site_url('request/ajax_test_short_notice')?>",
				data : postData,
				type : "GET",
				dataType : "JSON",
				success : function(data)
				{
					$('[name="severity_type"]').val(data.severity);
					//testSeverityOfActivityType();
				},
				error : function (jqXHR, textStatus, errorThrown)
				{
					//alert('Error test request');
					$('[name="severity_type"]').val('');
					//testSeverityOfActivityType();
				}
			});
		}
		
		/*
		  PAGE AND TABLE
		  NOT USED? since it is not shown on the right side of the Activity Type????
		*/
		function change_severity_level_label()
		{
			var activity_type_dd = document.getElementById("activity_type"); //$(this).val()
					//$("input[id='activity_type']");
			var activity_type = activity_type_dd.options[activity_type_dd.selectedIndex];
			//var activity_type = $("#activity_type").value;
			if (activity_type != null)			
			{
				if (activity_type.value != '' && activity_type.value != null)
					test_short_notice(activity_type.value);
			}
			else
			{
				//$("#severity_type").html('');
				$('[name="severity_type"]').val('');
				//$("#short_notice").show();
				activity_type_dd.selectedIndex = 0;
			}
		}
		
		/*
			HELPER FUNCTION for Time Formatting to the form BOTH (on PAGE and TABLE)
			PAGE AND TABLE
		*/
		function convertTime24to12(time24)
		{
			var tmpArr = time24.split(':'), time12;
			if (+tmpArr[0] == 12) {
				time12 = tmpArr[0] + ':' + tmpArr[1] + ' PM';
			} else {
				if(+tmpArr[0] == 00) {
					time12 = '12:' + tmpArr[1] + ' AM';
				} else {
					if (+tmpArr[0] > 12) {
						time12 = (+tmpArr[0]-12) + ':' + tmpArr[1] + ' PM';
					} else {
						time12 = (+tmpArr[0]) + ':' + tmpArr[1] + ' AM';
					}
				}
			}
			return time12;
		}
		
		function add_request()
		{
		    save_method = 'add';
			resetLabelColorToBlack();
		    $('#form')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string
		    $('#modal_form').modal('show'); // show bootstrap modal
		    $('.modal-title').text('Add Request'); // Set Title to Bootstrap modal title
			setDefaultactivity_requirement_checklist();
			setLabelColorForActivityRequirementChecklist("black");
		}
		
		/*
			PAGE and TABLE
		*/
		function setDefaultactivity_requirement_checklist()
		{
			$("#activity_requirement_checklistLabel").html("Activity Requirements Checklist <span style='font-weight:normal'>[ Must be completed to proceed with activity request ]</span>");
			$("#acoList").html("");
		}
		
		/*
			PAGE and TABLE
		*/
		function addCheckbox_CheckedOnEdit(activity_type, ids) {
			var str_array = ids.split(',');
			var container = $("#acoList");
			setDefaultactivity_requirement_checklist();
			
			var postData = {
				'activity_type' : activity_type,
			};
			$.ajax({
                type : "GET",
                url : "<?=base_url()?>request/ajax_activity_type_checklist/",
                data : postData,
                dataType : 'json',
                success : function(data){
					//container.html("");
					//console.log(data);
                    for (i in data)
					{
						if (str_array[i] == data[i]['id']) /* Checked checkbox if exist or saved from the database*/
							container.append("<div class='checkbox'><label><input class='checkboxActPreReq' checked='checked' type='checkbox' name='activity_type_requirement_checklist[]' value='" 
								+ data[i]['id'] + "' id='checkbox" + data[i]['id'] +  "'>"
								+ data[i]['activity_type_prerequisite'] + "</label></div>");
						else
							container.append("<div class='checkbox'><label><input class='checkboxActPreReq' type='checkbox' name='activity_type_requirement_checklist[]' value='" 
								+ data[i]['id'] + "' id='checkbox" + data[i]['id'] +  "'>"
								+ data[i]['activity_type_prerequisite'] + "</label></div>");
					}
                }
            });
		}
		
		/* NOT USED 
			instead 
				as appended checkedBox willl be checked
		*/
		function setActivityRequirementsChecklist_CheckBox(ids)
		{
			var str_array = ids.split(',');
			str_array.forEach( function(activity_req_id) { // LOOP all id to delete
				//$("#checkbox" + activity_req_id).prop("checked", "1");
				//$("#checkbox" + activity_req_id).attr('checked','checked');
				console.log(activity_req_id);
			});
		}

		/*
			PAGE and TABLE
		*/
		function edit_request(id)
		{
			resetLabelColorToBlack();
			setLabelColorForActivityRequirementChecklist("black");
			
		    save_method = 'update';
		    $('#form')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string
			
		    //Ajax Load data from ajax
		    $.ajax({
		        url : "<?php echo site_url('request/ajax_edit')?>/" + id,
		        type : "GET",
		        dataType : "JSON",
		        success : function(data)
		        {
					request_id_ = data.request_id;
		            $('[name="request_id"]').val(data.request_id); //Hidden Field
		            $('[name="activity_type"]').value = (data.activity_type);
		            // $('[name="activity_type"]').val(data.activity_type);
					//getActivityListByIDs(data.activity_type_requirement_checklist);
					//addCheckbox(activity_type_dd.value);
					addCheckbox_CheckedOnEdit(data.activity_type, data.activity_type_requirement_checklist);
					// append_activity_checklist_checkBox();
					// setActivityRequirementsChecklist_CheckBox(data.activity_type_requirement_checklist);
		            $('[name="criticality"]').val(data.criticality);
		            $('[name="activity_desc"]').val(data.activity_desc);
		            $('[name="project_name"]').val(data.project_name);
		            // $('[name="employee_id"]').val(data.employee_id);
		            // $('[name="employee_name"]').val(data.employee_name);
		            $('[name="department"]').val(data.department);
		            $('[name="discipline"]').val(data.discipline);
					$('[name="site_name"]').val(data.site_name);
		            $('[name="ne_involved"]').val(data.ne_involved);
		            $('[name="date"]').datepicker('update',data.date); 
		            // $('[name="start_time"]').val(data.start_time); // WITHOUT PROPER FORMAT
		            // $('[name="end_time"]').val(data.end_time);
		            $('[name="start_time"]').val(convertTime24to12(data.start_time)); // WITH PROPER FORMAT
		            $('[name="end_time"]').val(convertTime24to12(data.end_time));
		            $('[name="activity_date"]').datepicker('update',data.activity_date);
		            $('[name="reason_for_short_notice"]').val(data.reason_for_short_notice);
		            $('[name="gt_project_prop"]').val(data.gt_project_prop);
		            $('[name="contact_num_prop"]').val(data.contact_num_prop);
		            $('[name="gt_rep"]').val(data.gt_rep);
		            $('[name="contact_num_rep"]').val(data.contact_num_rep);
		            $('[name="vendor_rep"]').val(data.vendor_rep);
		            $('[name="contact_num_vendor"]').val(data.contact_num_vendor);
		            $('[name="reference_docs"]').val(data.reference_docs);
		            $('[name="so_ref_number"]').val(data.so_ref_number);
		            $('[name="trs_config_number"]').val(data.trs_config_number);
		            $('[name="_status"]').val(data._status);
					//$('[name="request_status"]').val(data.request_status);
		            $('[name="activity_status"]').val(data.activity_status);
		            $('[name="remarks"]').val(data.remarks);
					//change_severity_level_label();
		        },
		        error : function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		    });
		    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
		    $('.modal-title').text('Edit Request'); // Set title to Bootstrap modal title
		}
		
		/* 
			DELETE MULTIPLE SELECTION of rows in dtable 
		*/
		function delete_selected()
		{
			var dataArr = [];
			var rows = $('tr.selected');
			var rowData = table.rows(rows).data();
			$.each($(rowData),function(key, value){
				dataArr.push(value[2]); //"request_id" as array column 2 being the value of your first column.
			});
			//console.log(dataArr);
			if(dataArr.length > 0){
				delete_multiple_request(dataArr);
			} else {
				window.alert('Select from the table first to delete multiple request.');
			}
		}
		
		function reload_table()
		{
			var reload_icon = document.getElementById("loading");
			reload_icon.className = "glyphicon glyphicon-refresh glyphicon-refresh-animate";
			//reload_div.disabled = 'true';
			//reload_div.style.display = "none";
			setTimeout(function () {
				reload_icon.className = "glyphicon glyphicon-refresh";
				table.ajax.reload(null,false); //reload datatable ajax 
			}, 2000);
		}
		
		/*
			PAGE and TABLE
		*/
		function isCheckedAll()//isCheckedAtLeastOne
		{
			var prereqs = $('input[name="activity_type_requirement_checklist[]"]').length;
			var prereqs_checked = $('input[name="activity_type_requirement_checklist[]"]:checked').length;
			//var atLeastOneIsChecked = $('input[name="activity_type_requirement_checklist[]"]:checked').length > 0;
			
			//if($("#isAgeSelected").is(':checked'))
			return (prereqs == prereqs_checked);
		}
		
		/*
			PAGE and TABLE
			Selected Index is 0 || Blank || null
				then return TRUE
		*/
		function testActivityTypeSelectedIndexToZero()
		{
			return ($("select[name='activity_type'] option:selected").index() == 0 || 
				($("select[name='activity_type']").val() == '' || $("select[name='activity_type']").val()==null));
		}
		
		/*
			PAGE and TABLE
		*/
		function testAreaSelectedIndexToZero()
		{
			return ($("select[name='site_name'] option:selected").index() == 0);
		}
		
		/* 
			Set via count of request per day 
			@param callback function
			PAGE and TABLE
		*/
		function testCalendarDateCount(callback)
		{	
			$.ajax({
				type : "GET",
				url : "<?php echo site_url('calendar/getDateRequestCountAllWindowPeriod')?>",
				data : '',
				dataType : 'json',
				success : function(data) {
					callback(data);
				},
			});
		}
		
		/* 
			CALLBACK
			CALLED upon successive JSON feed from testCalendarDateCount AJAX call 
			@para data
			@return _error_msg_count
		*/
		function OnSuccess_testCalendarDateCount(data)
		{
			_msg_flag_count = 0;
			for (i in data) // Loop all data from AJAX json
			{
				if (parseInt(data[i]['count']) >= 3 && _date == (data[i]['activity_date']) // Test if count is already 3 AND equal to the date being evaluated
					&& !testTimeIntervalBeforSubmission() && !testTimeIfBlankOrNull()) { // Should have value not blank
					// console.log("Count " + JSON.stringify(data[i]['activity_date']));
					// console.log(data[i]['activity_date'] + " * " + data[i]['count']);
					_dateIsValidCount = 1;
					if (_msg_flag_count == 0) // Just to skip the next assignment in case more than one is true to this if stament cathched
					{
						_error_msg_count = "Date \"" + data[i]['activity_date'] + "\" has already 3 or more Window Period requests.";
						alert(_error_msg_count);
						
						/* Add Error Message on the in out mehtod after selecting the date */
						//$("#activity_date_div").val(_error_msg_color);
						_msg_flag_count = 1;
					}
				}
			}
			if (_msg_flag_count == 0) // to secure the assignment of flag into 0 in case the loop has never happened
				_dateIsValidCount = 0;
				
		}
		
		function testCalendarDateColor(callback) {
			$.ajax({
				type : "GET",
				url : "<?=base_url()?>request/ajax_date_color/",
				data : '',
				dataType : 'json',
				success : function(data)
				{
					callback(data);
				}
			});
		}
		
		
		/* CALLED upon successive JSON feed from testCalendarDateColor AJAX call */
		function OnSuccess_testCalendarDateColor(data)
		{
			// console.log("Log:" + _date);
			_msg_flag_color = 0;
			for (i in data)
			{
				if (_date == data[i]['date']) { // Test if Date On the input box is already been blocked by the approver
					//console.log("Color " + JSON.stringify(data[i]['date']));
					_dateIsValidColor = 1;
					if (_msg_flag_color == 0) // Just to skip the next assignment in case more than one is true to this if stament cathched
					{
						_error_msg_color = "Date \"" + data[i]['date'] + "\" has been blocked by the approver.";
						alert(_error_msg_color);
						//setLabelColor('activity_dateLabel', 'red');
						_msg_flag_color = 1;
					}
				}
			}
			if (_msg_flag_color == 0) // to secure the assignment of flag into 0 in case the loop has never happened
				_dateIsValidColor = 0;
			return _error_msg_color;
		}
		
		
		
		/*
			PAGE and TABLE
			@param 
				regexp - DATETIME Format
				regexp2 - "xx:xx PM/AM" 
			@return TRUE | FALSE
		*/
		function testTimeFormat(time)
		{
			var regexp = /([01][0-9]|[02][0-3]):[0-5][0-9]/; /* WORKs with DateTime */
			var regexp2 = /^([01]?[0-9]|2[0-3]):[0-5][0-9]/; /*  WORKs with TIME only AM/PM */
			var correct = regexp2.test(time);
			return correct;
		}
		
		function testTimeIfBlankOrNull()
		{
			var start_time = $("input[id='start_time']").val();
			var end_time = $("input[id='end_time']").val();
			if ((start_time == null || start_time == "") || 
				(end_time == null || end_time == "") || 
				(!testTimeFormat(start_time) || !testTimeFormat(end_time)))
				return true;
			else
			{
				return false;
			}
		}
		
		/*
			Return TRUE if time formats is good AND aren't in the range Between 12 am to 6 am
			PAGE and TABLE
		*/
		function testTimeIntervalBeforSubmission()
		{
			var start_time = $("input[id='start_time']").val();
			var end_time = $("input[id='end_time']").val();
			
			// to initialize the time as DateTime for easy TESTING of Minutes and Hours
			var dtStart = new Date("1/1/2007 " + start_time);
			var dtEnd = new Date("1/1/2007 " + end_time);
			
			//difference_in_milliseconds = dtEnd - dtStart;
			if ((dtStart.getHours() >= 0 && dtEnd.getHours() <= 6))
			{ // TEST Between 12 am to 6 am
				if (dtEnd.getMinutes() > 0 && dtEnd.getHours() == 6)
					return true;
				return false;
			}
			// if (dtStart.getHours() >= 0 && dtStart.getHours() < 6 &&
				// dtEnd.getHours() >= 0   && dtEnd.getHours() < 6) { // TEST Between 12 am to 6 am
				// return false;
			// }
			else 
				return true;
			
		}
		
		/* 
			Test Activity Date if it is in the PAST compared TODAY then if not PAST submission is true
		*/
		function dateIsPast_BeforSubmission()
		{
			var today = new Date();
			today.setHours(0,0,0,0);
			var activity_date = $("input[id='activity_date']").val();
			var act_date = new Date(activity_date);
			// console.log(act_date +" "+ today);
			
			if (act_date < today) {
				// selected date is in the past
				alert("Date is in the PAST. \nPlease choose another date of activity.");
				return true;
			}
			else
				return false;
		}
		
		/*
			Test if it is WEEKEND (Saturday or Sunday)
				NULL or Empty
			PAGE and TABLE
		*/
		function activity_DateIsNotWeekEnd_BeforeSubmission()
		{
			var activity_date = $("input[id=activity_date]").val();
			var act_date = new Date(activity_date);
			if (activity_date == null || activity_date == "" || 
				(act_date.getDay() == 6 || act_date.getDay() == 0)) 
				return false;
			else 
				return true;
		}
		
		/*
			Reset all Label Colors to BLACK
			PAGE and TABLE
		*/
		function resetLabelColorToBlack()
		{
			var color = 'black';
			setLabelColor('activity_typeLabel', color);
			setLabelColor('activity_requirement_checklistLabel', color);
			setLabelColor('criticalityLabel', color);
			setLabelColor('activity_descLabel', color);
			setLabelColor('project_nameLabel', color);
			setLabelColor('departmentLabel', color);
			setLabelColor('site_nameLabel', color);
			setLabelColor('disciplineLabel', color);
			setLabelColor('ne_involvedLabel', color);
			setLabelColor('start_timeLabel', color);
			setLabelColor('end_timeLabel', color);
			setLabelColor('activity_dateLabel', color);
			setLabelColor('gt_project_propLabel', color);
			setLabelColor('contact_num_propLabel', color);
			setLabelColor('gt_repLabel', color);
			setLabelColor('contact_num_repLabel', color);
			setLabelColor('vendor_repLabel', color);
			setLabelColor('contact_num_vendorLabel', color);
			setLabelColor('reference_docsLabel', color);
			setLabelColor('so_ref_numberLabel', color);
			setLabelColor('trs_config_numberLabel', color);
			setLabelColor('activity_statusLabel', color);
			setLabelColor('Labelremarks', color);

			/*
				FORM LABELs
					HIDDEN:
						request_id
						severity_type
						reason_for_short_noticeLabel (AFTER activity_dateLabel)
					activity_type
					activity_requirement_checklistLabel
					criticalityLabel
					activity_descLabel
					project_nameLabel
					departmentLabel
					site_nameLabel
					disciplineLabel
					ne_involvedLabel
					start_timeLabel
					end_timeLabel
					activity_dateLabel

					gt_project_propLabel
					contact_num_propLabel
					gt_repLabel
					contact_num_repLabel
					vendor_repLabel
					contact_num_vendorLabel
					reference_docsLabel
					so_ref_numberLabel
					trs_config_numberLabel
					activity_statusLabel
					Labelremarks
			*/
		}
		
		/*
			PAGE and TABLE
		*/
		function setLabelColor(labelID, color)
		{
			document.getElementById(labelID).style.color = color;
		}
		
		/*
			PAGE and TABLE
		*/
		function sumitValidatorRequest()
		{
			var counter = 0;
			
			//1
			if (isCheckedAll()) {
				counter += 1;
				setLabelColor('activity_requirement_checklistLabel', 'black');
			} else {
				counter -= 1;
				setLabelColor('activity_requirement_checklistLabel', 'red');
			}
			//2
			if (!testActivityTypeSelectedIndexToZero()) {
				counter += 1;
				setLabelColor('activity_typeLabel', 'black');
			} else {
				counter -= 1;
				setLabelColor('activity_typeLabel', 'red');
			}
			//3
			if (_dateIsValidColor == 0 && activity_DateIsNotWeekEnd_BeforeSubmission()
					&& !dateIsPast_BeforSubmission()) { // || testTimeIntervalBeforSubmission() && activity_DateIsNotWeekEnd_BeforeSubmission()
				counter += 1;
				setLabelColor('activity_dateLabel', 'black');
			} else {
				counter -= 1;
				setLabelColor('activity_dateLabel', 'red');
				//BootstrapDialog.alert("Date is blocked, try to select another date. Then submit again.");
			}
			//4
			if ((_dateIsValidCount == 0 && activity_DateIsNotWeekEnd_BeforeSubmission()) ) {//||  && testTimeIntervalBeforSubmission()
				counter += 1;
				setLabelColor('start_timeLabel', 'black');
				setLabelColor('end_timeLabel', 'black');
			} else {
				counter -= 1;
				setLabelColor('start_timeLabel', 'red');
				setLabelColor('end_timeLabel', 'red');
			}
			//5
			/*if (activity_DateIsNotWeekEnd_BeforeSubmission()) {
				counter += 1;
				setLabelColor('activity_dateLabel', 'black');
			} else {
				counter -= 1;
				setLabelColor('activity_dateLabel', 'red');
			}*/
			//5
			if (!testAreaSelectedIndexToZero()) {
				counter += 1;
				setLabelColor('site_nameLabel', 'black');
			} else {
				setLabelColor('site_nameLabel', 'red');
				counter -= 1;
			}
			
			if (counter == 5)
				return true;
			else 
				return false;
		}
		
		function save()
		{
			// console.log(_dateIsValidColor + _dateIsValidCount);
			//testOnChangeOfFormElements();
			//testDateFor_Submission();
			// if (sumitValidatorRequest() && (_dateIsValidColor == 0 && _dateIsValidCount == 0))
			if (sumitValidatorRequest())
			{
				$('#btnSave').text('saving...'); // change button text
				$('#btnSave').attr('disabled',true); // set button disable 
				var url;

				if (save_method == 'add') {
					url = "<?php echo site_url('request/ajax_add')?>";
					loadingPleaseWaitOpen("Creating request");
				} else {
					url = "<?php echo site_url('request/ajax_update')?>";
					loadingPleaseWaitOpen("Updating request");
				}
				
				// ajax adding data to database
				$.ajax({
					url : url,
					type : "GET",
					data : $('#form').serialize(),
					dataType : "JSON",
					success : function(data)
					{
						if (data.status) // if success close modal and reload ajax table
						{
							loadingPleaseWaitClose();
							$('#modal_form').modal('hide');
							reload_table();
							//alert(data.is_sent);
							resetLabelColorToBlack();
						}
						$('#btnSave').text('save'); //change button text
						$('#btnSave').attr('disabled',false); //set button enable 
						// if(save_method != 'add') { // IF ADD will send data as user
							// send_email_to_approver(request_id_, $request_action); }
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$('#modal_form').modal('hide'); // AFTER DEBUG
						reload_table();
						//alert('ERROR adding / update request');
						$('#btnSave').text('save'); //change button text
						$('#btnSave').attr('disabled',false); //set button enable 
						loadingPleaseWaitClose();
						resetLabelColorToBlack();
					}
				});
				//reload_table(); // Just for reloading the data OPTIONAL
			}
			else
			{
				//setLabelColorForActivityRequirementChecklist("red");
				//alert("To continue submission kindly complete activity pre-requisites first.");
				alert("Please complete the form then submit again.");
				// _dateIsValidColor = 0;
				// _dateIsValidCount = 0;
			}
			
		}
		
		function save_color()
		{
			$('#btnSave').text('saving...'); //change button text
			$('#btnSave').attr('disabled',true); //set button disable 
			var url;
			url = "<?php echo site_url('request/ajax_add_color')?>";
			//loadingPleaseWaitOpen("Creating request");
			
			// ajax adding data to database
			$.ajax({
				url : url,
				type : "GET",
				data : $('#form_color').serialize(),
				dataType : "JSON",
				success : function(data)
				{
					//if (data.status) //if success close modal and reload ajax table
					{
						//loadingPleaseWaitClose();
						$('#modal_color_picker_radio_buttons').modal('hide');
						refreshCalendarColors();
					}
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//loadingPleaseWaitClose();
					$('#modal_color_picker_radio_buttons').modal('hide'); // AFTER DEBUG
					refreshCalendarColors();
					
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
				}
			});
		}
		
		function refreshCalendarColors()
		{
			$('#calendar').fullCalendar('next');
			$('#calendar').fullCalendar('prev');
			//cal.fullCalendar( 'refresh');
			//$('#calendar').fullCalendar("refetchEvents");
		}
		
		/*
			PAGE and TABLE
		*/
		function setLabelColorForActivityRequirementChecklist(color)
		{
			document.getElementById('activity_requirement_checklistLabel').style.color = color;
		}
		
		/*SHOULD NOT Use for this implementation of 3.1.7v - NOT USED*/
		function send_email_to_approver($request_id, $action)
		{
			var postData = {
				'request_id' : $request_id,
				'action' : $action,
			};
			$.ajax({
				url : "<?php echo site_url('request/ajax_send_email_to_approver')?>/",
				data: postData,
				type : "POST",
				dataType : "JSON",
				success : function(data)
				{
					//if success reload ajax table
					$('#modal_form').modal('hide');
					//reload_table();
				},
				error : function (jqXHR, textStatus, errorThrown)
				{
					alert('Error approving request');
				}
			});
		}
		
		//NOT USED
		function approve_request_email_to_approver(id)
		{
			// ajax delete data to database
			$.ajax({
				url : "<?php echo site_url('request/ajax_send_email_to_approver')?>/",
				data: 'request_id=' + id + '&approval=' + action,
				type : "POST",
				dataType : "JSON",
				success : function(data)
				{
					//if success reload ajax table
					$('#modal_form').modal('hide');
					//reload_table();
				},
				error : function (jqXHR, textStatus, errorThrown)
				{
					alert('Error approving request');
				}
			});
		}
		
		function delete_request(id)
		{
			var postData = {
				'request_id' : id
				/*,'is_approver' : '<?php echo $_SESSION['is_approver']?>'*/
			};
			$('#btnDeleteAction').attr('disabled', true);
		    if (confirm('DELETE this request?'))
		    {
				loadingPleaseWaitOpen("Deleting request " + id);
				//deletedSelectedRow();
		        // ajax delete data to database
		        $.ajax({
		            // url : "<?php echo site_url('request/ajax_delete')?>/"+id,
		            url : "<?php echo site_url('request/ajax_delete')?>",
					data : postData,
		            type : "GET",
		            dataType : "JSON",
		            success : function(data)
		            {
						if (data.is_sent == 1)
						{
							$('#modal_form').modal('hide');
							reload_table();
							loadingPleaseWaitClose();
							//alert(data.is_sent);
						}
		                // if success reload ajax table
						///data.status =  response from
						//alert(data.status);
		                //$('#modal_form').modal('hide');
						//reload_table(); // Just for reloading the data OPTIONAL
		            },
		            error : function (jqXHR, textStatus, errorThrown)
		            {
		                //alert('Error deleting request');
						reload_table();
						loadingPleaseWaitClose();
		            }
		        });
		    } else {
				loadingPleaseWaitClose();
				alert("Request " + id + " was not deleted.");
			}
			$('#btnDeleteAction').attr('disabled', false);
		}
		
		/* Delete the multiple selected request/ROWs then remove forcible/temporarily on the DataTables */
		function deletedSelectedRow()
		{
			table.$('tr.selected').remove(); /* REMOVE the selected row in the table immidiateley*/
		}
		
		/*Loop one by one and delete the request ids (ARRAY)*/
		function delete_multiple_request(ids)
		{
			// Called at onclick delete selected
			$('#btnDeleteAction').attr('disabled',true);
		    if(confirm('DELETE these [' + ids + '] requests?'))
		    {
				loadingPleaseWaitOpen("Deleting multiple request(s)");
				deletedSelectedRow();
		        // ajax delete data to database
				ids.forEach(function(request_id) { // LOOP all id to delete
					var postData = {
						'request_id' : request_id,
					};
					$.ajax({
						url : "<?php echo site_url('request/ajax_delete')?>",
						data : postData,
						type : "GET",
						dataType : "JSON",
						success : function(data)
						{
							$('#modal_form').modal('hide');
						},
						error : function (jqXHR, textStatus, errorThrown)
						{
							// alert('Error deleting request');
						}
					});
				});
				reload_table(); // Just for reloading the data OPTIONAL
				loadingPleaseWaitClose();
				$('#btnDeleteAction').attr('disabled', false);
				deselect();
		    } else {
				//loadingPleaseWaitClose();
				alert("Request [" + ids + "] was not deleted.");
				$('#btnDeleteAction').attr('disabled', false);
			}
		}

		function view_request(id)
		{
			$status = 0;
			$("#modal_view_toolbar_button_id").show();
			
		    save_method = 'update';
		    $('#form')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string

		    //Ajax Load data from ajax
		    $.ajax({
		        url : "<?php echo site_url('request/ajax_view')?>/" + id,
		        type : "GET",
		        dataType : "JSON",
		        success : function(data)
		        {
		            $('[id="request_id"]').val(data.request_id); // hidden field
					jQuery("label[for='request_id']").html(data.request_id);
					jQuery("label[for='activity_type']").html(data.activity_type);
					getActivityListByIDs(data.activity_type_requirement_checklist);
					jQuery("label[for='criticality']").html(data.criticality);
		            jQuery("label[for='activity_desc']").html(data.activity_desc);
		            jQuery("label[for='project_name']").html(data.project_name);
		            jQuery("label[for='employee_id']").html(data.employee_id);
		            jQuery("label[for='employee_name']").html(data.employee_name);
		            jQuery("label[for='department']").html(data.department);
					jQuery("label[for='site_name']").html(data.site_name);
		            jQuery("label[for='discipline']").html(data.discipline);
		            jQuery("label[for='ne_involved']").html(data.ne_involved);
		            jQuery("label[for='date']").html(data.date); 
		            // jQuery("label[for='start_time']").html(data.start_time);
		            // jQuery("label[for='end_time']").html(data.end_time);
		            jQuery("label[for='start_time']").html(convertTime24to12(data.start_time));
		            jQuery("label[for='end_time']").html(convertTime24to12(data.end_time));
		            jQuery("label[for='activity_date']").html(data.activity_date);
		            jQuery("label[for='reason_for_short_notice']").html(data.reason_for_short_notice);
		            jQuery("label[for='gt_project_prop']").html(data.gt_project_prop);
		            jQuery("label[for='contact_num_prop']").html(data.contact_num_prop);
		            jQuery("label[for='gt_rep']").html(data.gt_rep);
		            jQuery("label[for='contact_num_rep']").html(data.contact_num_rep);
		            jQuery("label[for='vendor_rep']").html(data.vendor_rep);
		            jQuery("label[for='contact_num_vendor']").html(data.contact_num_vendor);
		            jQuery("label[for='reference_docs']").html(data.reference_docs);
		            jQuery("label[for='so_ref_number']").html(data.so_ref_number);
		            jQuery("label[for='trs_config_number']").html(data.trs_config_number);
		            jQuery("label[for='_status']").html(data._status);
					jQuery("label[for='request_status']").html(data.request_status);
		            jQuery("label[for='activity_status']").html(data.activity_status);
		            jQuery("label[for='approval_notes']").html(data.approval_notes);
					jQuery("label[for='approve_by']").html(data.approve_by);
					jQuery("label[for='remarks']").html(data.remarks);
					
					
					//if (data._status == 0 || data.request_status == 'New')
					if (data._status == 0 || data._status == null) // || data.request_status == 'For Approval'
					{
						$('#btnViewActionAccept').show();
						$('#btnViewActionCancel').show();
					}
					else if (data._status == 2) // || data.request_status == 'Reject'
					{
						$('#btnViewActionAccept').hide();
						$('#btnViewActionCancel').hide();
						// $status = $('#btnViewActionReject').text("Reject");
						//removeButton('btnViewActionReject');
					}
					else if (data._status == 3) // CANCELLED
					{
						$('#btnViewActionAccept').hide();
						$('#btnViewActionCancel').hide();
					}
					else // 1 or ACCEPTED
					{
						$('#btnViewActionAccept').hide();
						$('#btnViewActionCancel').show();
						// $status = $('#btnViewActionAccept').text("Accept");
						//removeButton('btnViewActionReject');
					}
		        },
		        error : function (jqXHR, textStatus, errorThrown) 
		        {
		            alert('Error get data from ajax. Try Refresh the page.');
		        }
		    });
			
		    $('#modal_view').modal('show'); // show bootstrap modal when complete loaded
			$('.modal-title').text('View Request Details'); // Set title to Bootstrap modal title
			//document.getElementById('myButton').innerHTML = status;
			
			
			/* BUTTON Setup */
			$('#btnViewActionAccept').unbind().click(function(){  /*Accept*/
				action = "ACCEPT";
				approve_request(id, 1);
				$('#modal_view').modal('hide');
			});
			/*
			$('#btnViewActionReject').unbind().click(function(){  //Reject
				action = "REJECT"; // TO SET THE ACTION BUTTON ON VIEW Modal
				approve_request(id, 2);
				$('#modal_view').modal('hide');
			});
			*/
			$('#btnViewActionCancel').unbind().click(function(){  /*Cancel*/
				action = "CANCEL"; // TO SET THE ACTION BUTTON ON VIEW Modal
				approve_request(id, 3);
				$('#modal_view').modal('hide');
			});
			$('#btnViewDelete').unbind().click(function(){ /*Delete Button*/
				delete_request(id);
				
			});
			$('#btnViewDetails').unbind().click(function(){ /*View On Page Button*/
				//view_request(id);
				window.location.href = "<?php echo base_url('request/view_details') ?>/?request_id=" + id;
			});
			
		}
		
		/* NOT YET USED */
		function removeButton(id) {
			var elem = document.getElementById(id);
			elem.parentNode.removeChild(elem);
			return false;
		}
		
		// NOT YET USED
		function send_email_rejected_remarks()
		{
			var prmpt = window.open("","test","height=100,width=400,left=150,top=80");
			//prmpt.document.write("<body bgcolor=#CCCCCC>");
			prmpt.document.write("Please enter your name<br>");
			prmpt.document.write("<input type='text' id='lastName'>");
			prmpt.document.write("<input id='val' type=button value='Okay' onclick='opener.test()'>");
			//prmpt.document.write("</body>");

			function test()
			{
				var lastnameField = prmpt.document.getElementById('lastName');
				alert("Last name is "+  lastnameField.value);
				prmpt.close();
			}
		}
		
		function approve_request(id, action_)
		{	
			var postData = {
				'request_id' : id,
				'action' : action_,
			};
			if (action_ == 2) // Set the Modal Approving/Rejecting
				loadingPleaseWaitOpen("Rejecting request " + id);
			else if (action_ == 3) // Set the Modal Approving/Rejecting
				loadingPleaseWaitOpen("Cancelling request " + id);
			else
				loadingPleaseWaitOpen("Approving request " + id);
			
		    if (confirm(action +' this request?'))
		    {
		        // ajax delete data to database
		        $.ajax({
					url : "<?php echo site_url('request/ajax_approve')?>/",
					data : postData,
					// data: 'request_id=' + id + '&approval=' + action,
		            type : "GET",
		            dataType : "JSON",
		            success : function(data)
		            {
						//send_email_request();
		                //if success reload ajax table
						loadingPleaseWaitClose();
		                $('#modal_view').modal('hide');
		                reload_table();
		            },
		            error : function (jqXHR, textStatus, errorThrown)
		            {
						loadingPleaseWaitClose();
		                //alert('Error approving request');
		            }
		        });
				reload_table(); // Just for reloading the data OPTIONAL
		    } else {
				loadingPleaseWaitClose();
			}
		}
		
		
		/* SHOULD HAVE Parameter as [0, 1, 2]*/
		function approve_request_OLD(id)
		{
			var postData = {
				'request_id' : id,
				'action' : action,
			};
		    if (confirm(action +' this request?'))
		    {
		        // ajax delete data to database
		        $.ajax({
					url : "<?php echo site_url('request/ajax_approve')?>/",
					data : postData,
					// data: 'request_id=' + id + '&approval=' + action,
		            type : "POST",
		            dataType : "JSON",
		            success : function(data)
		            {
						//send_email_request();
		                //if success reload ajax table
		                $('#modal_view').modal('hide');
		                reload_table();
		            },
		            error : function (jqXHR, textStatus, errorThrown)
		            {
		                alert('Error approving request');
		            }
		        });
				reload_table(); // Just for reloading the data OPTIONAL
		    }
		}
		
		/**************** SET UP CALENDAR ****************/
		var cal;
		function setCalendar(siteID) {
            var currentDate; // Holds the day clicked when adding a new event
            var currentEvent; // Holds the event object when editing an event

            //$('#color').colorpicker(); // Colopicker
            $('#time').timepicker({
                minuteStep : 5,
                showInputs : false,
                disableFocus : true,
                showMeridian : false
            });  // Timepicker
			
            var base_url="<?php echo base_url()?>"; // Here i define the base_url
            // Fullcalendar
            cal = 
			$('#calendar').fullCalendar({
                //timeFormat : 'DD-MM-YYYY H(:mm)',
				//theme : true,
				customButtons: {
					EventButton: {
						text:'Add Event',
						click:function(event, jsEvent, view) {
							$('#modal_calendar').modal('show');
						}
					}
				},
                header : {
                    left : 'prev, next, today',
                    center : 'request_id', //'title',
                    right : 'month, basicWeek, basicDay'
                },
                // Get all events stored in database
				dayRender : function (date, cell) {
					//var today = new Date();
					// if (date.isSame(today-1))
						// cell.css("background-color", 'green');
					// if (date.isSame('2016-10-13')) {
					   // cell.css("background-color","green");
					// }
					populateCalendarDate(date, cell);
				},
                eventLimit : true, // allow "more" link when too many events
                events : {
					url : "<?php echo site_url('calendar/getEvents')?>?site_id=" + siteID,
					// className: 'gcal-event',           // an option!
					// currentTimezone: 'America/Chicago', // an option! 
				},
				//http://localhost/CI/CART/calendar/getEvents?site_id=1&start=2016-09-25&end=2016-11-06
				// eventSources : [
					// "<?php echo site_url('calendar/getEvents')?>?site_id=" + siteID + 
						// "&start=" + new Date(new Date().getFullYear(), new Date().getMonth(), 1).toString() +
						// "&end=" + new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).toString(),
				// ],
				loading : function(isLoading) {
					if (isLoading)
						loadingPleaseWaitOpen("Rendering the calendar");
					else 
						loadingPleaseWaitClose();
				},
				// eventAfterAllRender: function (view) {
					// loadingPleaseWaitClose(); // remove your loading 
				// },
                // Handle Day Click
                dayClick : function(date, event, view) {
					if ('<?php echo $_SESSION['is_approver']?>'){
						if (isWeekend(date)){
							alert("It is Weekend!");
							//BootstrapDialog.alert('It is Weekend!');
						}
						else { // Weekdays, means Approver can change that date color
							modal_color_picker(date, event);
						}
					}
					
					/*modal(
						{
							//Available buttons when adding
							buttons : {
								add : {
									id : 'add-event', // Buttons id
									css : 'btn-primary', // Buttons class
									label : 'Save' // Buttons label
								}
							},
							title :'Set Date Color for ' + date.format() + ')' // Modal title
						}
					);*/
                },
                editable : false, // Make the event draggable true 
                eventDrop : function(event, delta, revertFunc) { /*NOT USED*/
                       $.post(base_url + 'calendar/dragUpdateEvent', {
							id : event.id,
							date : event.start.format()
						}, function(result) {
							if (result)
							{
								alert('Updated');
							}
							else
							{
								alert('Try Again later!');
							}
						});
                },
                // Event Mouseover
                eventMouseover : function(calEvent, jsEvent, view){
                    var tooltip = '<div class="event-tooltip">'
						+ 'Request ID: ' + calEvent.request_id
						+ '<br/>Area: ' + calEvent.site_name
						+ '<br/>Requestor: ' + calEvent.employee_name
						+ '</div>';
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
                eventMouseout : function(calEvent, jsEvent) {
                    $(this).css('z-index', 8);
                    $('.event-tooltip').remove();
                },
                // Handle Existing Event Click
                eventClick : function(calEvent, jsEvent, view) {
                    // Set currentEvent variable according to the event clicked in the calendar
                    //currentEvent = calEvent;
					//if (currentEvent == null)
					
					view_request(calEvent.request_id);
					$("#modal_view_toolbar_button_id").hide(); // Hide the ToolBar Buttons of Modal... (Delete, Accept, Cancel)
					/*console.log(calEvent);
					modal({
						// Available buttons when editing
						buttons : {
							delete : {
								id : 'delete-event',
								css : 'btn-danger',
								label : 'Delete'
							},
							update : {
								id : 'update-event',
								css : 'btn-success',
								label : 'Update'
							}
						},
						title : 'Edit Request "' + calEvent.date + '"',
						event : calEvent
					});
					*/
				},
				aspectRatio: 2 // TO Resize the Height, then after initialze call // $('#calendar').fullCalendar('option', 'aspectRatio', 2);
            });
			
			cal.fullCalendar('option', 'aspectRatio', 2); // TO Resize the fullCalendar on Width
			
			// refreshCalendarColors();
			// cal.fullCalendar('prev');
			// cal.fullCalendar('next');
			
			// $('#modal_calendar_link_area').tabs({
				// show: function(event, ui) {
					// $('#calendar').fullCalendar('render'); // 'today'
				// }
			// });
			
			function isWeekend($date) {
				var date = new Date($date).getDay();
				return date == 6 || date == 0;
			}
			
			/* ADDING Button to the fullCalendar */
			/* HELP BUTTON */
			$('.fc-toolbar .fc-left').prepend(
				$('<button type="button" class="fc-button fc-state-default fc-corner-left fc-corner-right"> Legend </button>')
					.on('click', function() {
						/*
						var title = prompt('Room name');
						if (title) {
							$('#calendar').fullCalendar(
								'addResource',
								{ title: title },
								true // scroll to the new resource?
							);
						}
						*/
						var frame_modal = $('#modal_calendar_legend');
						frame_modal.modal('show');
				})
			);
			
			/* Color Picker Only for the administrator */
			function modal_color_picker(date, event) {
				$('#modal_color_picker_radio_buttons').modal('show');
				$('.modal-title-color').text('Set Date Color for ' + date.format()); // Set title to Bootstrap modal title
				$('[name="date"]').val(date.format()); 
				//activity_calendar_date_color
				//save_color();
			}
				
			/*
				Rendered using a loop
					for(i in data)
					{
						$("#site_name").append("<option value=\""+data[i]['site_name']+"\">"+data[i]['site_name']+"</option>"); // Populate Ajax Site List to DropDown 
						$("#calendar_link").append( '<li><a onclick="return showCalendarModal('+data[i]['id']+',\''+data[i]['site_name']+'\');">' + data[i]['site_name'] + '</a></li>' );
					}
			*/
			
			function populateCalendarDate(date, cell)
			{
				//loadingPleaseWaitOpen("Rendering the calendar");
				var data_count = populateCalendarDateCount(date, cell);
				//var data_color = populateCalendarDateColor(date, cell); // CAlled inside the success at data_count instead
				
			}
			
			/* Set via count of request per day */
			function populateCalendarDateCount(date, cell)
			{
				$.ajax({
					type : "GET",
					url : "<?php echo site_url('calendar/getDateRequestCountAllWindowPeriod')?>?site_id=" + siteID,
					data : '',
					dataType : 'json',
					success : function(data)
					{
						for(i in data)
						{
							if (parseInt(data[i]['count']) >= 3 && date.isSame(data[i]['activity_date'])) { //&& data[i]['count'] != "null"
								cell.css("background-color", "#f0ad4e"); // ORANGE ...Darker GREEN-#86d77b ...OLD - RED or #ffb2b2 
							}	
						}
						populateCalendarDateColor(date, cell);
						return data;
					}
				});
			}
			/* 
					//cell.css("background-color", "red");
					.fc-unthemed .fc-today {
				border-style : solid;
				border-color : black black;
			}
				Set by Approver 
				Called inside success call of populateCalendarDateCount AJAX after for loop
				@return data
			*/
			function populateCalendarDateColor(date, cell)
			{
				$.ajax({
					type : "GET",
					url : "<?=base_url()?>request/ajax_date_color/",
					data : '',
					dataType : 'json',
					success : function(data)
					{
						var today = new Date();
						//console.log(JSON.stringify(data));
						//console.log(today.getFullYear() + "-" + (today.getMonth() + 1) + "-"+ today.getDate());
						for(i in data)
						{
							// console.log(data[i]['date'] + " - " + data[i]['color']);
							if (date.isSame(data[i]['date'])) {
							   cell.css("background-color", data[i]['color']);
							   /*
							   var tooltip = '<div class="event-tooltip">'
									+ 'Reason of Blockage: ' //+ data[i]['reason_of_blockage']
									+ '</div>';
								cell.append(tooltip);
								cell.mouseover(function (e) {
									$(this).css('z-index', 10000);
									$('.event-tooltip').fadeIn('500');
									$('.event-tooltip').fadeTo('10', 1.9);
								}).mousemove(function(e) {
									$('.event-tooltip').css('top', e.pageY + 10);
									$('.event-tooltip').css('left', e.pageX + 20);
								});
								*/
							}
							
							// Setting the Boarder color to BLACK of the date TODAY
							if (date.isSame(today.getFullYear() + "-" + (today.getMonth() + 1) + "-"+ ("0" + today.getDate()).slice(-2))) {
							   cell.css("border-color", "black");
							}
							// To set the color of top BOARDER date after 7 days from TODAY
							if (date.isSame(today.getFullYear() + "-" + (today.getMonth() + 1) + "-"+ (today.getDate() + 7))){ 
							   cell.css("border-top-color", "black");
							}
						}
						return data;
					}, 
					// error : function (jqXHR, textStatus, errorThrown)
					// {
						// loadingPleaseWaitClose();
					// }
				});
			}
			
			/* NOT USED */
            // Prepares the modal window according to data passed
            function modal(data) {
				console.log(data);
                // Set modal title
				if (typeof calEvent === 'undefined' || calEvent == null) /* Show only the Form without data */
                    // Open modal to edit or delete event
					$('#modal_form').modal('show');
				else
				{	
					$('.modal-title').html(data.title + " Request ID: " + data.event.request_id);
					// Clear buttons except Cancel
					$('.modal-footer button:not(".btn-default")').remove();
					// Set input values
					$('#title').val(data.event ? data.employee_id : '');
					if( ! data.event) {
						// When adding set timepicker to current time
						var now = new Date();
						var time = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' + now.getMinutes() : now.getMinutes());
					} else {
						// When editing set timepicker to event's time
						var time = data.date;
						//var time = data.date.split(' ')[1].slice(0, -3);
						//time = time.charAt(0) === '0' ? time.slice(1) : time;
						time = time;
					}
					$('#time').val(time);
					$('#description').val(data.event ? data.event.description : '');
					$('#color').val(data.event ? data.event.color : '#3a87ad');
					// Create Butttons
					$.each(data.buttons, function(index, button){
						$('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>');
					});
					
					$('[name="request_id"]').val(data.event.request_id); //Hidden Field
					$('[name="activity_type"]').val(data.event.activity_type);
					$('[name="criticality"]').val(data.event.criticality);
					$('[name="activity_desc"]').val(data.event.activity_desc);
					$('[name="project_name"]').val(data.event.project_name);
					$('[name="employee_id"]').val(data.event.employee_id);
					$('[name="employee_name"]').val(data.event.employee_name);
					$('[name="department"]').val(data.event.department);
					$('[name="discipline"]').val(data.event.discipline);
					$('[name="site_name"]').val(data.event.site_name);
					$('[name="ne_involved"]').val(data.event.ne_involved);
					$('[name="date"]').val(data.event.date); 
					$('[name="start_time"]').val(data.event.start_time);
					$('[name="end_time"]').val(data.event.end_time);
					$('[name="activity_date"]').val(data.event.activity_date);
					$('[name="gt_project_prop"]').val(data.event.gt_project_prop);
					$('[name="contact_num_prop"]').val(data.event.contact_num_prop);
					$('[name="gt_rep"]').val(data.event.gt_rep);
					$('[name="contact_num_rep"]').val(data.event.contact_num_rep);
					$('[name="vendor_rep"]').val(data.event.vendor_rep);
					$('[name="contact_num_vendor"]').val(data.event.contact_num_vendor);
					$('[name="reference_docs"]').val(data.event.reference_docs);
					$('[name="so_ref_number"]').val(data.event.so_ref_number);
					$('[name="trs_config_number"]').val(data.event.trs_config_number);
					$('[name="_status"]').val(data.event._status);
					$('[name="activity_status"]').val(data.event.activity_status);
					$('[name="remarks"]').val(data.event.remarks);
					//Show Modal
					//$('.modal').modal('show');
				}
                $('#modal_form').modal('show');
            }
			
			
            // Handle Click on Add Button
            $('#modal_form').on('click', '#add-event',  function(e){
                if(validator(['title', 'description'])) {
                    $.post(base_url+'calendar/addEvent', {
                        title : $('#title').val(),
                        description : $('#description').val(),
                        color : $('#color').val(),
                        date : currentDate + ' ' + getTime()
                    }, function(result){
                        $('#modal_form').modal('hide');
                        $('#calendar').fullCalendar("refetchEvents");
                    });
                }
            });

			/*
            // Handle click on Update Button
            $('#modal_form').on('click', '#update-event',  function(e){
                if(validator(['title', 'description'])) {
                    $.post(base_url+'calendar/updateEvent', {
                        id : currentEvent._id,
                        title : $('#title').val(),
                        description : $('#description').val(),
                        color : $('#color').val(),
                        date : currentEvent.date.split(' ')[0]  + ' ' +  getTime()
                    }, function(result){
                        $('#modal_form').modal('hide');
                        $('#calendar').fullCalendar("refetchEvents");
                    });
                }
            });

			
            // Handle Click on Delete Button
            $('#modal_form').on('click', '#delete-event',  function(e){
                $.get(base_url+'calendar/deleteEvent?id=' + currentEvent._id, function(result){
                    $('#modal_form').modal('hide');
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
                    if($.trim($('#' + element).val()) == '') errors++;
                });
                if(errors) {
                    $('.error').html('Please insert title and description');
                    return false;
                }
                return true;
            }
			*/
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
			.fc-day{
				background-color : #95ef89;//#8CDD81; // GREEN for WeekDays
			}
			.fc-sun, .fc-sat{
				background-color : white; // WHITE for Sunday and Saturday
			}
            // .modal-header
            // {
                // background-color: #3A87AD;
                // color: #fff;
            // }
			
			/* TO set the fixness of COLUMNS*/
			.tableData {
				margin: 0 auto;
				width: 100%;
				clear: both;
				border-collapse: collapse;
				table-layout: fixed; // ***********add this
				word-wrap:break-word; // ***********and this
			}
			// #modal_calendar_legend {
				// top:5%;
				// right:30%;
				// outline: none;
			// }
			.label-grey {
				background-color: #999;
				//background-color: #5bc0de;
			}
			.label-white {
				background-color: #000;
			}
			.label-light_green { // NOT USED
				background-color: #f0ad4e;
			}
        </style>
	
	
</body>
</html>