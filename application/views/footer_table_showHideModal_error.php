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
	<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>


	<script src="<?php echo base_url('assets/datatables/extension/js/datatables.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/extension/js/dataTables.buttons.min.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-timepicker/js/Moment.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-timepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
	
	<script type="text/javascript">
		var save_method; //for save method string
		var table;
		var action;
		var request_id_;
		var modal_flag = 0;
		
		$(document).ready(function() {
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
		                targets : [ 0 ],
		            },
		        ], 
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
			populateSiteNameDropDownList(); // TO POPULATE THE AREA DDList at MODAL FORM
			populateActivityTypeDropDownList(); // TO POPULATE THE Activity Type DDList at MODAL FORM
		});
		
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
		
		/* To pre-populate the content of option dropdown in the form create/add request (on PAGE and TABLE)*/
		function populateSiteNameDropDownList()
		{
			$.ajax({           
                type : "POST",
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
                type : "POST",
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
		
		function testActivityTypeAndDateForShortNotice()
		{
			// document.getElementsByName('reason_for_short_notice')[0].value;
			var form_request = document.forms["submit_request"];
			// form_request.getElementsByTagName('reason_for_short_notice')[0].value;
			var reason_for_short_notice = form_request.getElementsByTagName('reason_for_short_notice')[0].value;
			var activity_date = form_request.getElementsByTagName('activity_date')[0].value;
			var end_time = form_request.getElementsByTagName('end_time')[0].value;
			var start_time = form_request.getElementsByTagName('start_time')[0].value;
			var activity_type = form_request.getElementsByTagName('activity_type')[0].value;
			$("#short_notice").hide();
		}
		
		/*HELPER FUNCTION for Time Formatting to the form BOTH (on PAGE and TABLE)*/
		function convertTime24to12(time24)
		{
			var tmpArr = time24.split(':'), time12;
			if(+tmpArr[0] == 12) {
				time12 = tmpArr[0] + ':' + tmpArr[1] + ' PM';
			} else {
				if(+tmpArr[0] == 00) {
					time12 = '12:' + tmpArr[1] + ' AM';
				} else {
					if(+tmpArr[0] > 12) {
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
		    $('#form')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string
		    $('#modal_form').modal('show'); // show bootstrap modal
		    $('.modal-title').text('Add Request'); // Set Title to Bootstrap modal title
		}

		function edit_request(id)
		{
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
		            $('[name="activity_type"]').val(data.activity_type);
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
		        },
		        error : function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		    });
		    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
		    $('.modal-title').text('Edit Request'); // Set title to Bootstrap modal title
		}
		
		// DELETE MULTIPLE SELECTION of rows in dtable 
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
				alert('Select from the table first to delete multiple request.');
			}
		}		
		
		function reload_table()
		{
			loadingPleaseWaitOpen('Reloading');
		    table.ajax.reload(null,false); //reload datatable ajax 
			loadingPleaseWaitClose();
		}

		function save()
		{
		    $('#btnSave').text('saving...'); //change button text
		    $('#btnSave').attr('disabled',true); //set button disable 
		    var url;

		    if(save_method == 'add') {
		        url = "<?php echo site_url('request/ajax_add')?>";
				loadingPleaseWaitOpen("Creating request");
		    } else {
		        url = "<?php echo site_url('request/ajax_update')?>";
				loadingPleaseWaitOpen("Updating request");
		    }

		    // ajax adding data to database
		    $.ajax({
		        url : url,
		        type : "POST",
		        data : $('#form').serialize(),
		        dataType : "JSON",
		        success : function(data)
		        { 
		            if(data.status) //if success close modal and reload ajax table
		            {
		                $('#modal_form').modal('hide');
		                reload_table();
		            }
		            $('#btnSave').text('save'); //change button text
		            $('#btnSave').attr('disabled',false); //set button enable 
					// if(save_method != 'add') { // IF ADD will send data as user
						// send_email_to_approver(request_id_, $request_action); }
					loadingPleaseWaitClose();
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error adding / update request');
		            $('#btnSave').text('save'); //change button text
		            $('#btnSave').attr('disabled',false); //set button enable 
					loadingPleaseWaitClose();
		        }
		    });
			//reload_table(); // Just for reloading the data OPTIONAL
		}

		/*SHOULD NOT Use for this implementation of 3.1.7*/
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
		
		/* Utility Function, mostly used for Delete Request and View Request */
		function modalTestShowHide(test)
		{
			switch (test)
			{
				case 0: // First Test
					$('#modal_view').modal('hide');
					if (modal_flag != 2)
						modal_flag = 1;
				break;
				case 1:
				default :
					if (modal_flag == 0 || modal_flag == 2)
					{
						$('#modal_view').modal('show');
						modal_flag = 1;
					}
					if (modal_flag == 2)
					{
						$('#modal_view').modal('show');
						modal_flag = 0;
					}
				break;
			}
		}
		
		function delete_request(id)
		{
			var postData = {
				'request_id' : id,
			};
			modalTestShowHide(0);
			loadingPleaseWaitOpen("Deleting request " + id);
			$('#btnDeleteAction').attr('disabled', true);
		    if(confirm('DELETE this request?'))
		    {
		        // ajax delete data to database
		        $.ajax({
		            // url : "<?php echo site_url('request/ajax_delete')?>/"+id,
		            url : "<?php echo site_url('request/ajax_delete')?>",
					data : postData,
		            type : "POST",
		            dataType : "JSON",
		            success : function(data)
		            {
						loadingPleaseWaitClose();
		                // if success reload ajax table
		                $('#modal_form').modal('hide');
		            },
		            error : function (jqXHR, textStatus, errorThrown)
		            {
		                alert('Error deleting request');
						loadingPleaseWaitClose();
		            }
		        });
				reload_table(); // Just for reloading the data OPTIONAL
		    } else {
				loadingPleaseWaitClose();
				alert("Request " + id + " was not deleted.");
			}
			modalTestShowHide(1);
			$('#btnDeleteAction').attr('disabled', false);
		}
		
		/*Loop one by one and delete the request ids (ARRAY)*/
		function delete_multiple_request(ids)
		{
			$('#btnDeleteAction').attr('disabled',true);
			loadingPleaseWaitOpen("Deleting multiple request(s)");
		    if(confirm('DELETE these [' + ids + '] requests?'))
		    {
		        // ajax delete data to database
				ids.forEach(function(request_id) { // LOOP all id to delete
					var postData = {
						'request_id' : request_id,
					};
					$.ajax({
						url : "<?php echo site_url('request/ajax_delete')?>",
						data : postData,
						type : "POST",
						dataType : "JSON",
						success : function(data)
						{
							loadingPleaseWaitClose();
							$('#modal_form').modal('hide');
						},
						error : function (jqXHR, textStatus, errorThrown)
						{
							loadingPleaseWaitClose();
							alert('Error deleting request');
						}
					});
				});
				reload_table(); // Just for reloading the data OPTIONAL
		    } else {
				loadingPleaseWaitClose();
				alert("Request [" + ids + "] was not deleted.");
			}
			$('#btnDeleteAction').attr('disabled', false);
		}

		function view_request(id)
		{
			$status = 0;
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
		            jQuery("label[for='remarks']").html(data.remarks);
					jQuery("label[for='approval_notes']").html(data.approval_notes);
					
					if (data._status == 0 || data.request_status == 'New')
					{
						$('#btnViewActionAccept').show();
						$('#btnViewActionReject').show();
						// $status = $('#btnViewActionAccept').text("Accept");
						//removeButton('btnViewActionReject');
						//var $input = $('<button type="button" id="btnViewActionReject" class="btn btn-primary">Reject</button>');
						//$input.appendTo($(".approve_button"));
					}
					else if (data._status == 1 || data.request_status == 'Reject')
					{
						$('#btnViewActionAccept').hide();
						$('#btnViewActionReject').show();
						// $status = $('#btnViewActionReject').text("Reject");
						//removeButton('btnViewActionReject');
					}
					else
					{
						$('#btnViewActionAccept').show();
						$('#btnViewActionReject').hide();
						// $status = $('#btnViewActionAccept').text("Accept");
						//removeButton('btnViewActionReject');
					}
		        },
		        error : function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
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
			$('#btnViewActionReject').unbind().click(function(){  /*Reject*/
				action = "REJECT"; // TO SET THE ACTION BUTTON ON VIEW Modal
				approve_request(id, 2);
				$('#modal_view').modal('hide');
			});
			$('#btnViewDelete').unbind().click(function(){ /*Delete Button*/
				modal_flag = 2; // to Show again the modal view request after cancel/ok button to the requerst
				delete_request(id);
				//$('#modal_view').modal('hide');
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
			modal_flag = 0;
			modalTestShowHide(0);
			loadingPleaseWaitOpen("Approving request " + id);
		    if(confirm(action +' this request?'))
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
						loadingPleaseWaitClose();
		                $('#modal_view').modal('hide');
		                reload_table();
		            },
		            error : function (jqXHR, textStatus, errorThrown)
		            {
						loadingPleaseWaitClose();
		                alert('Error approving request');
		            }
		        });
				reload_table(); // Just for reloading the data OPTIONAL
		    } else{
				loadingPleaseWaitClose();
			}
			modalTestShowHide(1);
		}
		
		
		/* SHOULD HAVE Parameter as [0, 1, 2]*/
		function approve_request_OLD(id)
		{
			var postData = {
				'request_id' : id,
				'action' : action,
			};
		    if(confirm(action +' this request?'))
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
		
		</script>
</body>
</html>