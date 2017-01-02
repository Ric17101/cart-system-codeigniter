	<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	</main><!-- #site-content -->

	<footer id="site-footer" class="footer wrapper" role="contentinfo" style="padding: 60px;">
		<div class="container ">
			<p class="text-muted navbar-text">Centralized Activity Reqest Tool &copy; 2016</p>
		</div>
	</footer><!-- #site-footer -->
	<!-- js -->
	<script src="<?php echo base_url('assets/jquery/jquery-1.12.3.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('assets/jquery/waiting_for.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
	
	<script src="<?php echo base_url('assets/bootstrap-timepicker/js/Moment.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-timepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
	
	<!-- # JS -->
	<script type="text/javascript">
		var save_method; // for save method string
		var table;
		var action;
		var request_id_;
		
		$(document).ready(function() {
			<?php if (!isset($logged_in_success)) : ?>
				setupPageTable();
			<?php endif; ?>
		});
		
		function setupPageTable()
		{
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
			
			//if (<?php echo $request_id ?>)
			request_id_ = <?php echo $request_id ?>;
			view_request_details(request_id_); // Initial displau of data on the details on the page
			
			$('#btnEditAction').unbind().click(function(){  /*Either Accept/Reject*/
				$('#modal_form').modal('show');
				edit_request(request_id_);
			});
			// $('#btnViewDelete').unbind().click(function(){ /*Delete Button*/
				// delete_request(request_id_);
			// });
			$('#btnViewActionAccept').unbind().click(function(){  /*Accept*/
				action = "ACCEPT";
				//approve_request(request_id_, 1);
				view_request_with_remarks(request_id_, 1);
				$('#modal_view').modal('hide');
			});
			/*
			$('#btnViewActionReject').unbind().click(function(){  // Reject
				action = "REJECT"; // TO SET THE ACTION BUTTON ON VIEW Modal
				// approve_request(request_id_, 2);
				view_request_with_remarks(request_id_, 2);
				$('#modal_view').modal('hide');
			});
			*/
			$('#btnViewActionCancel').unbind().click(function(){  /*Cancel*/
				action = "CANCEL"; // TO SET THE ACTION BUTTON ON VIEW Modal
				view_request_with_remarks(request_id_, 3);
				$('#modal_view').modal('hide');
			});
			// $('#btnViewAction').unbind().click(function(){  /*Either Accept/Reject*/
				// view_request_with_remarks(request_id_); // or approve_request(<?php echo $request_id ?>);
			// });
			
			populateActivityTypeDropDownList(); // TO POPULATE THE Activity Type DDList at MODAL FORM
			testActivityTypeAndDateForShortNotice();
			populateSiteNameDropDownList();
			onActivityOnChangeListener();
		}
		
		/* To pre-populate the content of option dropdown in the form create/add request (on PAGE and TABLE)*/
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
					if (data == null || data == '') // Should this clean up??? But still working
						container.html("<label class='col-md-4' style='text-align: right;'></label>");
                }
            });
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
		var dateIsValidColor;
		var dateIsValidCount;
		function testDateFor_Submission()
		{
			var date = $("input[id=activity_date]").val();
			console.log(date);
			testCalendarDateCount(date);
			testCalendarDateColor(date);
			if (date == 'NaN' || date == null || date == 'null' || date == '')
				dateIsValidColor = 1;
		}
		
		/*
			Usually called on Change of Date and Time
		*/
		function testOnChangeOfFormElements(){
			// var activity_type_dd = document.getElementById("activity_type");
			// var activity_type = activity_type_dd.options[activity_type_dd.selectedIndex].value; // I DON't know what is the error on this, should check this sometime			
			//test_short_notice(activity_type);
			testDateFor_Submission();
		}
		
		/* 
			Short notice on the form OnChange
			PAGE AND TABLE
		*/
		function testActivityTypeAndDateForShortNotice()
		{
			$("#short_notice").hide(); // Should I delete this line? since sir oliver not using it
			$("#activity_date").on("change", function() { // Activity Date
				testOnChangeOfFormElements();
			});
			
			$("#start_time").on('blur', function(){// start_time
				testOnChangeOfFormElements();
				console.log("start");
			});
			$("#end_time").on('change keydown paste input blur', function() { // end_time
				console.log("end");
				testOnChangeOfFormElements();
			});
			
			$("#site_name").on("change", function() { // site_name
				testOnChangeOfFormElements();
			});
			
			$("#activity_type").on('change', function() { /* DropDownList for Activity Type has changed */
				testOnChangeOfFormElements();
			});
		}
		
		/*
		  PAGE AND TABLE
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
				// alert('ok testSeverityOfActivityType() ' + severity);
			}
			else
			{
				$("#short_notice").hide();
				$("input[name=reason_for_short_notice]").val('');
				// alert('ok testSeverityOfActivityType() ' + severity);
			}
		}
		
		/*
		  PAGE AND TABLE
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
				},
				error : function (jqXHR, textStatus, errorThrown)
				{
					$('[name="severity_type"]').val('');
				}
			});
		}
		
		/*
		  PAGE AND TABLE
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
		/*
			PAGE and TABLE
		*/
		function setDefaultactivity_requirement_checklist()
		{
			$("#activity_requirement_checklistLabel").html("Activity Requiremnet Checklist <span style='font-weight:normal'>[must check all]</span>");
			$("#acoList").html("");
		}
		
		/*
			PAGE and TABLE
		*/
		function addCheckbox_CheckedOnEdit(activity_type, ids) {
			var str_array = ids.split(',');
			var container = $("#acoList");
			setDefaultactivity_requirement_checklist();
			//$('#activity_requirement_checklistLabel').html(activity_type + " Activity Requiremnet Checklist");
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
					//​document.getElementById('sel').value = 'bike';​​​​​​​​​​
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
			PAGE and TABLE
		*/
		function isCheckedAll()
		{
			var prereqs = $('input[name="activity_type_requirement_checklist[]"]').length;
			var prereqs_checked = $('input[name="activity_type_requirement_checklist[]"]:checked').length;
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
			PAGE and TABLE
		*/
		function testCalendarDateCount(date)
		{
			$.ajax({
				type : "GET",
				url : "<?php echo site_url('calendar/getDateRequestCountAllWindowPeriod')?>",
				data : '',
				dataType : 'json',
				success : function(data)
				{
					dateIsValidCount = 0;
					for(i in data)
					{
						if (parseInt(data[i]['count']) >= 3 && date == (data[i]['activity_date']) && !testTimeIntervalBeforSubmission()) { //&& data[i]['count'] != "null"
							// cell.css("background-color", "#d9534f"); // RED
							// console.log(JSON.stringify(data));
							//alert(data[i]['activity_date'] + " * " + data[i]['count']);
							dateIsValidCount = 1;
						}
					}
				}
			});
		}
		
		/* 
			Set by Approver 
			Tests if date from db has been added to a particular day for request
			PAGE and TABLE
		*/
		function testCalendarDateColor(date)
		{
			$.ajax({
				type : "GET",
				url : "<?=base_url()?>request/ajax_date_color/",
				data : '',
				dataType : 'json',
				success : function(data)
				{
					dateIsValidColor = 0;
					for(i in data)
					{
						// console.log("--");
						if (date == data[i]['date'] && !testTimeIntervalBeforSubmission()) {
							// console.log(data[i]['date'] + " - " + data[i]['color']);
							// console.log(JSON.stringify(data));
							//alert(data[i]['date'] + " * " + data[i]['color']);
						   //cell.css("background-color", data[i]['color']);
						   dateIsValidColor = 1;
						}
					}
				}
			});
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
		
		/*
			Return TRUE if time formats is good AND aren't in the range Between 12 am to 6 am
			PAGE and TABLE
		*/
		function testTimeIntervalBeforSubmission()
		{
			var start_time = $("input[id=start_time]").val();
			var end_time = $("input[id=end_time]").val();
			if ((start_time == null || start_time == "") || 
				(end_time == null || end_time == "") || 
				(!testTimeFormat(start_time) || !testTimeFormat(end_time)))
				return false;
			else
			{
				// to initialize the time as DateTime for easy TESTING of Minutes and Hours
				var dtStart = new Date("1/1/2007 " + start_time);
				var dtEnd = new Date("1/1/2007 " + end_time);
				
				//difference_in_milliseconds = dtEnd - dtStart;
				if (dtStart.getHours() >= 0 && dtEnd.getHours() < 6) { // TEST Between 12 am to 6 am
					return false;
				}
				else 
					return true;
			}
		}
		
		/*
			Test if it is WEEKEND (Saturday or Sunday)
				NULL or Empty
			PAGE and TABLE
		*/
		function activity_DateIsNotWeekEndBeforeSubmission()
		{
			var activity_date = $("input[id=activity_date]").val();
			var act_date = new Date(activity_date);
			if (activity_date == null || activity_date == "" || 
				(act_date.getDay() == 6 || act_date.getDay() == 0)) 
				return false;
			else return true;
			
		}
		
		/*
			Reset all Label Colors
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
			if ((dateIsValidColor == 0)) {
				counter += 1;
				setLabelColor('start_timeLabel', 'black');
				setLabelColor('end_timeLabel', 'black');
			} else {
				counter -= 1;
				setLabelColor('start_timeLabel', 'red');
				setLabelColor('end_timeLabel', 'red');
			}
			//4
			if ((dateIsValidCount == 0)) {
				counter += 1;
				setLabelColor('start_timeLabel', 'black');
				setLabelColor('end_timeLabel', 'black');
			} else {
				counter -= 1;
				setLabelColor('start_timeLabel', 'red');
				setLabelColor('end_timeLabel', 'red');
			}
			//5
			if (activity_DateIsNotWeekEndBeforeSubmission()) {
				counter += 1;
				setLabelColor('activity_dateLabel', 'black');
			} else {
				counter -= 1;
				setLabelColor('activity_dateLabel', 'red');
			}
			//6
			if (!testAreaSelectedIndexToZero()) {
				counter += 1;
				setLabelColor('site_nameLabel', 'black');
			} else {
				setLabelColor('site_nameLabel', 'red');
				counter -= 1;
			}
			// 0 - 1
			//alert(dateIsValidColor+" - " + dateIsValidCount);
			if (counter == 6)
				return true;
			else 
				return false;
		}

		function reload_page_content()
		{
		    view_request_details(request_id_);
			// window.location.reload(true); 
		}
		
		function save()
		{
			if (sumitValidatorRequest())
			{
			    $('#btnSave').text('saving...'); //change button text
			    $('#btnSave').attr('disabled',true); //set button disable 
			    $('#btnSave2').attr('disabled',true); //set button disable 
			    var url;
				var severity; // NOT REALLY USED as Varible just to call the initialization of the hidden data...
			    if (save_method == 'update_remarks') {
					if (action == 'REJECT') // SET Hidden input for parmaeter of AJAX call GET METHOD 
						severity = $('[name="action"]').val('2');
					else if (action == 'ACCEPT')
						severity = $('[name="action"]').val('1');
					else if (action == 'CANCEL')
						severity = $('[name="action"]').val('3');
					else
						severity = $('[name="action"]').val('0');
			        url = "<?php echo site_url('request/ajax_update_remarks_and_approve')?>"; //+ "?request_id=" + request_id_ + "&remarkss=" +$r;
					$form = '#form_approve';
					$modal_form = '#modal_form_approve';
					$request_action = "APPROVER REMARKS"; // TEST THIS
					loadingPleaseWaitOpen("Sending request");
			    } else {
			        url = "<?php echo site_url('request/ajax_update')?>";
					$form = '#form';
					$modal_form = '#modal_form';
					$request_action = "MODIFIED";
					loadingPleaseWaitOpen("Updating request");
			    }
	
			    // ajax adding data to database
			    $.ajax({
			        url : url,
			        type : "GET",
			        data : $($form).serialize(),
			        dataType : "JSON",
			        success : function(data)
			        {
			            if (data.status) //if success close modal and reload ajax table
			            {
			                $($modal_form).modal('hide');
			                //reload_table();
							resetLabelColorToBlack();
			            }
			            $('#btnSave').text('save'); //change button text
			            $('#btnSave').attr('disabled', false); //set button enable
			            $('#btnSave2').attr('disabled', false); //set button enable 
						// if (save_method == 'update_remarks') {
							// approve_request_email(request_id_);
						// }
						
						// send_email_to_approver(request_id_, $request_action);
						//$this->ajax_send_email_to_approver($request_id, $_SESSION['user_id'], "FOR APPROVAL");
						//view_request_details(<?php echo $request_id ?>); // TO show data on the details on the page
						reload_page_content();
						loadingPleaseWaitClose();
						resetLabelColorToBlack();
			        },
			        error: function(jqXHR, textStatus, errorThrown)
			        {
			            //alert('Error adding / update request');
			            $('#btnSave').text('save'); //change button text
			            $('#btnSave').attr('disabled', false); //set button enable 
						$('#btnSave2').attr('disabled', false); //set button enable 
						$($modal_form).modal('hide');
						reload_page_content();
						loadingPleaseWaitClose();
			        }
			    });
			}
			else
			{
				//setLabelColorForActivityRequirementChecklist("red");
				//alert("To continue submission kindly complete activity pre-requisites first.");
				alert("Please complete the form then submit again.");
			}
			dateIsValidCount = 0;
			dateIsValidColor = 0;
		}

		/*
			PAGE and TABLE
		*/
		function setLabelColorForActivityRequirementChecklist(color)
		{
			document.getElementById('activity_requirement_checklistLabel').style.color = color;
		}
		
		/* NOT USED?*/
		function send_email_to_approver($request_id, $action)
		{
			// ajax delete data to database
			// send_email_to_approver($request_id, $user_id, $action)
			// $this->ajax_send_email_to_approver($request_id, "FOR APPROVAL");
			var postData = {
				'request_id' : $request_id,
				'action' : $action,
			};
			$.ajax({
				url : "<?php echo site_url('request/ajax_send_email_to_approver')?>/",
				data: postData,
				type : "GET",
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
				'request_id' : id,
			};
			loadingPleaseWaitOpen("Deleting request " + id);
			$('#btnViewDelete').text('deleting...'); //change button text
		    $('#btnViewDelete').attr('disabled',true);
		    if(confirm('DELETE this request?'))
		    {
		        // ajax delete data to database
		        $.ajax({
		            // url : "<?php echo site_url('request/ajax_delete')?>/"+id,
		            url : "<?php echo site_url('request/ajax_delete')?>",
					data : postData,
		            type : "GET",
		            dataType : "JSON",
		            success : function(data)
		            {
						$('#btnViewDelete').text('Delete'); //change button text
						$('#btnViewDelete').attr('disabled', false);
		                //if success reload ajax table
		                $('#modal_form').modal('hide');
						loadingPleaseWaitClose();
						redirect_after_delete();
		            },
		            error : function (jqXHR, textStatus, errorThrown)
		            {
		                // alert('Error deleting request');
						loadingPleaseWaitClose();
						$('#btnViewDelete').text('Delete'); //change button text
						$('#btnViewDelete').attr('disabled',false);
						redirect_after_delete();
		            }
		        });
		    } else {
				alert("Request " + id + " was not deleted.");
				$('#btnViewDelete').text('Delete');
				$('#btnViewDelete').attr('disabled',false);
				loadingPleaseWaitClose();
			}
			// reload_page_content();
			// $('#btnViewDelete').text('Delete'); //change button text
		}

		function redirect_after_delete()
		{
			window.location.replace("<?php echo site_url('request')?>");
		}
		
		function view_request_details(id)
		{
			$status = 0;
		    save_method = 'update';
		    //Ajax Load data from ajax
		    $.ajax({
		        url : "<?php echo site_url('request/ajax_view')?>/" + id,
		        type : "GET",
		        dataType : "JSON",
		        success : function(data)
		        {
					if (data != null)
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
						jQuery("label[for='start_time']").html(convertTime24to12(data.start_time)); // WITH PROPER FORMAT
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
						
						if (data._status == 3) /* Hide Button Edit if CANCELLED */
							$('#btnEditAction').show();
						else
							$('#btnEditAction').hide();
						
						if (data._status == 0 || data._status == null) // For Approval
						{
							$('#btnViewActionAccept').show();
							$('#btnViewActionCancel').show();
						}
						else if (data._status == 2) // || data.request_status == 'Reject'
						{
							$('#btnViewActionAccept').hide();
							$('#btnViewActionCancel').hide();
						}
						else if (data._status == 3) // Cancelled
						{
							$('#btnViewActionAccept').hide();
							$('#btnViewActionCancel').hide();
						}
						else // 1 or ACCEPTED
						{
							$('#btnViewActionAccept').hide();
							$('#btnViewActionCancel').show();
						}
						
						// if (data._status == 0 || data._status == 3) // || data.request_status == 'For Approval'
						// {
							// $('#btnViewActionAccept').show();
							// $('#btnViewActionReject').show();
							// $('#btnViewActionCancel').hide();
						// }
						// else if (data._status == 2) // || data.request_status == 'Reject'
						// {
							// $('#btnViewActionAccept').hide();
							// $('#btnViewActionReject').show();
							// $('#btnViewActionCancel').show();
						// }
						// else // 1 or ACCEPTED
						// {
							// $('#btnViewActionAccept').show();
							// $('#btnViewActionReject').hide();
							// $('#btnViewActionCancel').hide();
						// }
					} else {
						document.getElementById('req').innerHTML = 
							'Request Details does not exist. <br/ >It might have been deleted. Check it '+
							"<a href='<?= base_url('request') ?>'> here</a>";
						$("#panelButtons").hide();
						$("#panelDetail").hide();
						$("#panelFooter").hide();
					}
		        },
		        error : function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		    });
		}

		/* USed to set the remarks and ask why this is being rejected or being accepted*/
		function view_request_with_remarks(id, action_)
		{
			$status = 0;
		    save_method = 'update_remarks';
		    $('#form_approve')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string

		    //Ajax Load data from ajax
		    $.ajax({
		        url : "<?php echo site_url('request/ajax_view')?>/" + id,
		        type : "GET",
		        dataType : "JSON",
		        success : function(data)
		        {
		            $('[name="request_idd"]').val(data.request_id); // hidden field
					$('[name="approval_notes"]').val(data.approval_notes);
					
					if (data._status == 0 || data._status == null) // FOr Approval
					{
						$('#btnViewActionAccept').show();
						$('#btnViewActionCancel').show();
					}
					else if (data._status == 2) // || data.request_status == 'Reject'
					{
						$('#btnViewActionAccept').hide();
						$('#btnViewActionCancel').hide();
					}
					else if (data._status == 3) // Cancelled
					{
						$('#btnViewActionAccept').hide();
						$('#btnViewActionCancel').hide();
					}
					else // 1 or ACCEPTED
					{
						$('#btnViewActionAccept').hide();
						$('#btnViewActionCancel').show();
					}
					
					// if (data._status == 0 || data.request_status == 'New')
					// {
						// $('#btnViewActionAccept').show();
						// $('#btnViewActionReject').show();
						// $('#btnViewActionCancel').hide();
						////$status = $('#btnViewActionAccept').text("Accept");
					// }
					// else if (data._status == 1 || data.request_status == 'Reject')
					// {
						// $('#btnViewActionAccept').hide();
						// $('#btnViewActionReject').show();
						// $('#btnViewActionCancel').show();
					// }
					// else if (data._status == 3 || data.request_status == 'Reject')
					// {
						// $('#btnViewActionAccept').hide();
						// $('#btnViewActionReject').show();
						// $('#btnViewActionCancel').hide();
						////$status = $('#btnViewActionReject').text("Reject");
					// }
					// else
					// {
						// $('#btnViewActionAccept').show();
						// $('#btnViewActionReject').hide();
						// $('#btnViewActionCancel').show();
						////$status = $('#btnViewActionAccept').text("Accept");
					// }
					
					// if (data._status == 0 || data._status == 2
						// || data.request_status == 'Reject' || data.request_status == 'New')
					// {
						// $status = $('#btnViewAction').text("Accept");
						// action = "ACCEPT"; // TO SET THE ACTION BUTTON ON VIEW Modal
					// } else {
						// $status = $('#btnViewAction').text("Reject");
						// action = "REJECT";
					// }
		        },
		        error : function (jqXHR, textStatus, errorThrown)
		        {
		            //alert('Error get data from ajax');
		        }
		    });
			
		    $('#modal_form_approve').modal('show'); // show bootstrap modal when complete loaded
			$('.modal-title').text('Why ' + action + '?'); // Set title to Bootstrap modal title
			
			// $('#btnEditAction').unbind().click(function(){  /*Either Accept/Reject*/
				// approve_request(id);
				// $('#modal_form').modal('show');
			// });
			// $('#btnViewDelete').unbind().click(function(){ /*Delete Button*/
				// delete_request(id);
				// $('#modal_form').modal('hide');
			// });
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
		
		/*NOT USED*/
		function approve_request_email(id)
		{
			// ajax delete data to database
			$.ajax({
				url : "<?php echo site_url('request/ajax_approve_email')?>/",
				data: 'request_id=' + id + '&approval=' + action,
				type : "GET",
				dataType : "JSON",
				success : function(data)
				{
					//if success reload ajax table
					$('#modal_form').modal('hide');
					//reload_table();
					reload_page_content();
				},
				error : function (jqXHR, textStatus, errorThrown)
				{
					alert('Error approving request');
				}
			});
		}

		/* USED only at TABLE page*/
		function approve_request(id, action_)
		{	
			var postData = {
				'request_id' : id,
				'action' : action_,
			};
			loadingPleaseWaitOpen("Approving request " + id);
		    if(confirm(action +' this request?'))
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

	</script>	
	</body>
</html>