<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('request_model','request');
		// if(empty($this->session->userdata("login_session_user")))
			// redirect(site_url(),'refresh');
	}
	
	public function page_start($view)
	{
		$data = new stdClass();
		if ($this->session->userdata('logged_in')) { // for logging in puroposes
		    $data->error = 'You must be logged in first.';
		}
		
		// Data to show on the form
		$request_id = $this->input->get('request_id');
		$error = "";
		if (($request_id == null || $request_id == '' || $request_id == ' ') || !isset($_SESSION['logged_in']))// Test if logged in on both PAGE and TABLE
			$error = 'Nothing to show this time.'; // will this give error?
		$data = new stdClass();
		$data->request_id = $request_id;
		$data->error = $error;
		
		$this->load->helper('url');
		$this->load->view('header');
		$this->load->view($view, $data);
		if ($view == 'request_view') // FOoter and Buttons of Table issues
			$this->load->view('footer_table');
		else
			$this->load->view('footer');
	}
	
	public function index()
	{
		$this->page_start('request_view');
	}
	
	/*NOT USEDs*/
	public function is_request_exists($request_id)
	{
		return ($this->request->test_request_existence($request_id) == true ? true : false);
	}
	
	/* Display Request Data on another page request_details_view.php*/
	public function view_details()
	{
		$request_id = $this->input->get('request_id');
		// $this->ajax_view($request_id); // WILL return ajax json code format for data retrieval
		$this->page_start('request_detail_view');
	}

	/**
		*NOT USED 
		*unkown parametarized problem arised when executed
	*/
	public function setRowStatusLabel($request)
	{
		$status_label = "";
		$status_label_class = "";
		if ($request->_status == '2')
		{
			$status_label = "Rejected";
			$status_label_class = "danger";
		}
		else if ($request->_status == '1')
		{
			$status_label = "Accepted";
			$status_label_class = "success";
		}
		else
		{
			$status_label = "For Approval";
			$status_label_class = "primary";
		}
		return "<span class='label label-".$status_label_class."'>".$status_label."</span>";
	}
	
	/**
		*Render Data from Database to DataTables
	*/
	public function ajax_list()
	{
		//$list = $this->request->get_datatables(); // Query all data from the db table request
		$list = $this->request->get_datatables_by_area(); // Query all data by area for the current user
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $request) {
			$no++;
			$row = array();
			if ($this->session->userdata('is_approver')) /* APPROVER can VIEW and DELETE*/
				$row[] = '<span class="btn-group btn-group-justified"><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_request('."'".$request->request_id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
					<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Delete" onclick="delete_request('."'".$request->request_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a></span>';
			else /* REQUESTOR can VIEW, DELETE and EDIT */
			{
				if ($request->_status == '3') /* Can Be edit if Request is Cancelled ONLY */
				{
					$row[] = '<span class="btn-group btn-group-justified"><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_request('."'".$request->request_id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
						<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_request('."'".$request->request_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
						<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Delete" id="btnDeleteAction"'.$request->request_id.'" onclick="delete_request('."'".$request->request_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a></span>';
				}
				else
					$row[] = '<span class="btn-group btn-group-justified"><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_request('."'".$request->request_id."'".')"><i class="glyphicon glyphicon-eye-open"></i> View</a>
						<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Delete" id="btnDeleteAction"'.$request->request_id.'" onclick="delete_request('."'".$request->request_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a></span>';
				
			}
			$status_label_class = "";
			if ($request->_status == '1') /* SET THE label class for APPROVAL STATUS (RED, GREEN and BLUE)*/
				$status_label_class = "success";
			else if ($request->_status == '2') 
				$status_label_class = "danger";
			else if ($request->_status == '3')
				$status_label_class = "warning";
			else
				$status_label_class = "primary";
			$row[] = "<span class='label label-".$status_label_class."'>".$request->request_status."</span>";
			$row[] = $request->request_id;
			$row[] = $request->employee_id;
			$row[] = $request->employee_name;
			$row[] = $request->department;
			$row[] = $request->site_name;
			$row[] = $request->so_ref_number;
			$row[] = $request->date;
			$row[] = $this->request->ftime($request->start_time, 12);
			// $row[] = $request->start_time + $request->end_time;
			$row[] = $request->gt_rep;
			$row[] = $request->vendor_rep;
			$row[] = $request->activity_desc;
			$row[] = $request->ne_involved;
			$row[] = $request->activity_date;
			$row[] = $request->activity_status;
			
			// $glyph_button = "";
			// if ($request->_status == "" || $request->_status == null || $request->_status == 0) // Sets the action Label and it button Type as per the _status
			// {
				//add html for action
				// $glyph_button = "ok";
			// }
			// else
			// {
				// $glyph_button = "remove";
			// }
			$data[] = $row;
		}

		$output = array(
					"draw" 				=> $_POST['draw'],
					"recordsTotal" 		=> $this->request->count_all(),
					"recordsFiltered" 	=> $this->request->count_filtered(),
					"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_test_short_notice()
	{
		$activity_type = $this->input->get('activity_type');
		echo json_encode(array('severity'=>$this->request->test_short_notice($activity_type)));
	}
	
	public function ajax_edit($request_id)
	{
		$data = $this->request->get_by_id($request_id);
		echo json_encode($data);
	}
	
	public function ajax_view($request_id)
	{
		// $_SESSION['user_id']
		$data = $this->request->get_by_id($request_id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$site_name = $this->input->get('site_name');
		//$request_id = $this->input->get('request_id');
		$activity_date = $this->input->get('activity_date');
		$data = array(
				//'request_id'	 	 => $this->input->get('request_id'),
				'activity_type'	 	 => $this->input->get('activity_type'),
				'activity_type_requirement_checklist' 
									 => implode(",",$_GET["activity_type_requirement_checklist"]),
				'criticality'	 	 => $this->input->get('criticality'),
				'activity_desc'	 	 => $this->input->get('activity_desc'),
				'project_name'	 	 => $this->input->get('project_name'),
				// 'employee_id'	 => $this->input->get('employee_id'),
				// 'employee_name'	 => $this->input->get('employee_name'),
				'employee_id'	 	 => $_SESSION['user_id'],
				'employee_name'	 	 => $this->request->get_requestor_fullname_by_user_id($_SESSION['user_id']),
				//'employee_name'	 	 => $_SESSION['username'],
				'department'	 	 => $this->input->get('department'),
				'site_name'	 	 	 => $site_name,
				'discipline'	 	 => $this->input->get('discipline'),
				'ne_involved'	 	 => $this->input->get('ne_involved'),
				'date'	 		 	 => date("Y-m-d H:i:s"),//$this->input->get('date').' '.$this->input->get('start_time'),
				// 'start_time'	 	 => $this->input->get('start_time'),
				// 'end_time'	 	 	 => $this->input->get('end_time'),
				'start_time'	 	 => date("H:i", strtotime($this->input->get('start_time'))),
				'end_time'	 	 	 => date("H:i", strtotime($this->input->get('end_time'))),
				'activity_date'	 	 => (($activity_date == null || $activity_date == '') ? null : $activity_date),
				//'activity_date'	 	 => $this->input->get('activity_date').' '.$this->input->get('end_time'),
				//0000-00-00
				'reason_for_short_notice' => $this->input->get('reason_for_short_notice'),
				'gt_project_prop'	 => $this->input->get('gt_project_prop'),
				'contact_num_prop'	 => $this->input->get('contact_num_prop'),
				'gt_rep'	 		 => $this->input->get('gt_rep'),
				'contact_num_rep'	 => $this->input->get('contact_num_rep'),
				'vendor_rep'	 	 => $this->input->get('vendor_rep'),
				'contact_num_vendor' => $this->input->get('contact_num_vendor'),
				'reference_docs'	 => $this->input->get('reference_docs'),
				'so_ref_number'	 	 => $this->input->get('so_ref_number'),
				'trs_config_number'	 => $this->input->get('trs_config_number'),
				//'_status'	 		 => $this->input->get('_status'), // not called nor set
				'activity_status'	 => $this->input->get('activity_status'),
				'remarks'	 		 => $this->input->get('remarks'),
			);
		$insert_id = $this->request->save($data);
		$is_sent = $this->ajax_send_email_to_approver_request($insert_id, "FOR APPROVAL");
		echo json_encode(array("status" => TRUE, "data" => $is_sent['is_sent']));
	}
	
	public function ajax_add_color()
	{
		$color = $this->input->get('date_color');
		$activity_date = $this->input->get('date');
		$data = array(
				//'request_id'	 	 => $this->input->get('request_id'),
				'color'	 	 => $color,
				'date'	 	 => (($activity_date == null || $activity_date == '') ? null : $activity_date),
			);
		
		if (($activity_date == null || $activity_date == '') || ($color == null || $color == ''))
			echo json_encode(array("status" => FALSE, "data" => $color." ".$activity_date));
		else {			
			$insert_id = $this->request->save_color($data);
			echo json_encode(array("status" => TRUE, "data" => $insert_id));
		}
	}
	
	public function ajax_add_OLD() // USING POST
	{
		$site_name = $this->input->post('site_name');
		//$request_id = $this->input->post('request_id');
		$activity_date = $this->input->get('activity_date');
		$data = array(
				//'request_id'	 	 => $this->input->post('request_id'),
				'activity_type'	 	 => $this->input->post('activity_type'),
				'criticality'	 	 => $this->input->post('criticality'),
				'activity_desc'	 	 => $this->input->post('activity_desc'),
				'project_name'	 	 => $this->input->post('project_name'),
				// 'employee_id'	 => $this->input->post('employee_id'),
				// 'employee_name'	 => $this->input->post('employee_name'),
				'employee_id'	 	 => $_SESSION['user_id'],
				'employee_name'	 	 => $_SESSION['username'],
				'department'	 	 => $this->input->post('department'),
				'site_name'	 	 	 => $site_name,
				'discipline'	 	 => $this->input->post('discipline'),
				'ne_involved'	 	 => $this->input->post('ne_involved'),
				'date'	 		 	 => date("Y-m-d H:i:s"),//$this->input->post('date').' '.$this->input->post('start_time'),
				// 'start_time'	 	 => $this->input->post('start_time'),
				// 'end_time'	 	 	 => $this->input->post('end_time'),
				'start_time'	 	 => date("H:i", strtotime($this->input->post('start_time'))),
				'end_time'	 	 	 => date("H:i", strtotime($this->input->post('end_time'))),
				'activity_date'	 	 => (($activity_date == null || $activity_date == '') ? null : $activity_date),
				'reason_for_short_notice' => $this->input->post('reason_for_short_notice'),
				'gt_project_prop'	 => $this->input->post('gt_project_prop'),
				'contact_num_prop'	 => $this->input->post('contact_num_prop'),
				'gt_rep'	 		 => $this->input->post('gt_rep'),
				'contact_num_rep'	 => $this->input->post('contact_num_rep'),
				'vendor_rep'	 	 => $this->input->post('vendor_rep'),
				'contact_num_vendor' => $this->input->post('contact_num_vendor'),
				'reference_docs'	 => $this->input->post('reference_docs'),
				'so_ref_number'	 	 => $this->input->post('so_ref_number'),
				'trs_config_number'	 => $this->input->post('trs_config_number'),
				//'_status'	 		 => $this->input->post('_status'), // not called nor set
				'activity_status'	 => $this->input->post('activity_status'),
				'remarks'	 		 => $this->input->post('remarks'),
			);
		$insert_id = $this->request->save($data);
		$this->ajax_send_email_to_approver_request($insert_id, "FOR APPROVAL");
		echo json_encode(array("status" => TRUE, "data" => $data));
	}

	/*
		CALLED at footer JS with constant GET Values as parameters as per APPROVAL
		CALLED only at PAGE
	*/
	public function ajax_update_remarks_and_approve()
	{
		$request_id = $this->input->get('request_idd');
		$approval_notes = $this->input->get('approval_notes');
		$action = $this->input->get('action');
		// $request_id = $this->input->get('request_idd'); // FOR DEBUGGING
		// $approval_notes = $this->input->get('approval_notes'); // FOR DEBUGGING
		$data = array(
				'request_id' => $request_id, // REDUNDANT at calling ajax
				'approval_notes' => $approval_notes,
				'action' => $action
			);
		$action_return = $this->request->update_request_with_remarks($request_id, $data); // WIll return ACCPET/REJECT
		$this->ajax_send_email_to_requestor_request($request_id, $action_return);
		echo json_encode(array("status" => TRUE, "data" => $data ));
	}
	
	public function ajax_update()
	{
		$site_name = $this->input->get('site_name');
		$request_id = $this->input->get('request_id');
		$activity_date = $this->input->get('activity_date');
		$data = array(
				//'request_id'	 	 => $this->input->get('request_id'),
				'activity_type'	 	 => $this->input->get('activity_type'),
				'activity_type_requirement_checklist' 
									 => implode(",",$_GET["activity_type_requirement_checklist"]),
				'criticality'	 	 => $this->input->get('criticality'),
				'activity_desc'	 	 => $this->input->get('activity_desc'),
				'project_name'	 	 => $this->input->get('project_name'),
				//'employee_id'	 	 => $this->input->get('employee_id'),
				//'employee_name'	 => $this->input->get('employee_name'),
				'employee_name'	 	 => $this->request->get_requestor_fullname_by_user_id($_SESSION['user_id']), // Should this be deleted? or just nothing?
				'department'	 	 => $this->input->get('department'),
				'site_name'	 	 	 => $site_name,
				'discipline'	 	 => $this->input->get('discipline'),
				'ne_involved'	 	 => $this->input->get('ne_involved'),
				//'date'	 		 => $this->input->get('date'), // SHOULD NOT CHANGE THE DATE it was created
				// 'start_time'	 	 => $this->input->get('start_time'),
				// 'end_time'	 	 => $this->input->get('end_time'),
				'start_time'	 	 => date("H:i", strtotime($this->input->get('start_time'))),
				'end_time'	 	 	 => date("H:i", strtotime($this->input->get('end_time'))),
				'activity_date'	 	 => (($activity_date == null || $activity_date == '') ? null : $activity_date),
				'reason_for_short_notice' => $this->input->get('reason_for_short_notice'),
				'gt_project_prop'	 => $this->input->get('gt_project_prop'),
				'contact_num_prop'	 => $this->input->get('contact_num_prop'),
				'gt_rep'	 		 => $this->input->get('gt_rep'),
				'contact_num_rep'	 => $this->input->get('contact_num_rep'),
				'vendor_rep'	 	 => $this->input->get('vendor_rep'),
				'contact_num_vendor' => $this->input->get('contact_num_vendor'),
				'reference_docs'	 => $this->input->get('reference_docs'),
				'so_ref_number'	 	 => $this->input->get('so_ref_number'),
				'trs_config_number'	 => $this->input->get('trs_config_number'),
				//'_status'	 		 => $this->input->get('_status'), // not called nor set
				//'request_status'	 => $this->input->get('request_status'),
				'activity_status'	 => $this->input->get('activity_status'),
				'remarks'	 		 => $this->input->get('remarks'),
			);
		$action = "MODIFIED";
		if ($this->request->test_if_cancelled($request_id))  // TO CHANGE the APPROVAL Notice on teh eamil // FOR APPROVAL
			$action = 'FOR APPROVAL';
		$this->request->update(array('request_id' => $request_id), $data);
		$this->ajax_send_email_to_approver_request($request_id, $action);
		echo json_encode(array("status" => TRUE, "data" => $data));
	}

	// public function ajax_delete($request_id)
	public function ajax_delete()
	{
		//$request_id = $this->input->post('request_id');
		$request_id = $this->input->get('request_id');
		$this->request->delete_by_id($request_id);
		if ($_SESSION['is_approver'] === true)
		//if ($this->input->get('is_approver') === true)
			$is_sent = $this->ajax_send_email_to_requestor_request($request_id, "DELETED"); // end Delete First Before actual Deletion on DB
		else
			$is_sent = $this->ajax_send_email_to_approver_request($request_id, "DELETED"); // end Delete First Before actual Deletion on DB
		
		//$data = $this->request->delete_by_id($request_id);
		// echo json_encode(array("status"=> TRUE, "data"=> $data));
		echo json_encode(array("status"=> TRUE, 'is_sent'=> $is_sent));
	}
	
	/*NOT USED*/
	public function ajax_delete_multiple_id()
	{
		$request_ids = $this->input->post('request_ids');
		// foreach ()
		$this->ajax_send_email_to_approver_request($request_ids, "DELETED"); // end Delete First Before actual Deletion on DB
		$this->request->delete_multiple_id($request_ids);
		echo json_encode(array("status" => TRUE, "data" => $data));
	}
	
	/* CALLED at footer on PAGE only and not TABLE*/
	public function ajax_approve_email()
	{
		$request_id = $this->input->get('request_id');
		$approval_status = $this->input->get('action');
		$approval_status_word = "";
		if ($approval_status == 1) // Test if input param is 1 the status is APPROVED
			$approval_status_word = 'APPROVED';
		else
			$approval_status_word = 'REJECTED';
		
		$email = $this->ajax_send_email_to_requestor_request($request_id, $approval_status_word);//$_SESSION['user_id'],
		echo json_encode(array("status" => TRUE, "_status"=> $data, "email_status"=> $email));
	}
	
	//TEST ONLY -- SHOULD NOT USE
	// public function approve_by_id($request_id)
	// {
		// $data = $this->request->approve_by_id($request_id);
		// echo json_encode(array('data'=> $data));
	// }
	
	public function ajax_approve()
	{
		$request_id = $this->input->get('request_id');
		$approval_status = $this->input->get('action');
		$approval_status_word = "";
		if ($approval_status == 1) // Test if input param is 1 the status is APPROVED
			$approval_status_word = 'APPROVED';
		else if ($approval_status == 3) // CAN BE NOTHING
			$approval_status_word = 'CANCELLED';
		else
			$approval_status_word = 'REJECTED';
		
		$email = FALSE;
		$query = $this->request->approve_by_id($request_id, $approval_status);
		if ($query) // IF TRUE send email
		{
			$email = $this->ajax_send_email_to_requestor_request($request_id, $approval_status_word);//$_SESSION['user_id'],
			//$this->request->changeStatus($request_id); // NOT USED???
		}
		echo json_encode(array("status" => TRUE, "_status"=> $query, "email_status"=> $email));
	}
	
	/* 
		SHOULD VANQUISEHD use [0,1,2] instead of ACCEPT/REJECT
		NOT USED
	*/
	/*
	public function ajax_approve_OLD()
	{
		$request_id = $this->input->post('request_id');
		$approval_status = $this->input->post('action');
		if ($approval_status == 'REJECT') // Set the status email for EMAIL Header
			$approval_status = 'REJECTED';
		else
			$approval_status = 'APPROVED';
		
		$email = FALSE;
		$query = $this->request->approve_by_id($request_id, approval_status);
		if ($query) // IF TRUE send email
		{
			$email = $this->ajax_send_email_to_requestor_request($request_id, $approval_status);//$_SESSION['user_id'],
			//$this->request->changeStatus($request_id); // NOT USED???
		}
		echo json_encode(array("status" => TRUE, "_status"=> $query, "email_status"=> $email));
	}*/
	
	/* Called after creation of Request By Requestor*/
	/** NOT USED*/
	public function ajax_send_email_to_approver()
	{
		$request_id = $this->input->get('request_id');
		$action = $this->input->get('action');
		// $request_id = $this->input->get('request_id'); // FOR DEBUGGING
		// $action = $this->input->get('action');
		$email = $this->ajax_send_email_to_approver_request($request_id, $action);
		// echo json_encode(array("status" => TRUE, "email_status"=> $email,
				// "request_id" => $request_id, "action" => $action));
	}
	
	/*SEND TO Approver */
	public function ajax_send_email_to_approver_request($request_id, $action)
	{
		$is_sent = $this->request->send_email_request_to_approver($request_id, $action, $_SESSION['user_id']);
		echo json_encode(array("is_sent" => $is_sent));
	}
	
	/*SEND TO Requestor */
	public function ajax_send_email_to_requestor_request($request_id, $action)
	{
		$is_sent = $this->request->send_email_request($request_id, $action, $_SESSION['user_id']);
		// if ($email)
			// $this->setFlash_Message("Email sent successfully.", "success");
		// else
			// $this->setFlash_Message("Email not sent.", "danger");
		echo json_encode(array("is_sent" => $is_sent));
	}

	public function changeStatusRequest($request_id) {
        $edit = $this->request->changeStatus($request_id);
        $this->session->set_flashdata('success', 'request '.$edit.' Successfully');
        redirect('request/manage-request');
    }
	
	// TODO -- NOT USED
	public function ajax_getAreaEmailRecipients($area)
	{
		echo json_encode(array("area" => TRUE));
	}
	
	/*
	 *	FOR TESTING PUPOSES on using Ajax's
	 */
	public function ajax_send_email_request($request_id)
	{
		//$email = $this->request->send_email_request($request_id);
		$email[1] = $this->request->get_requestor_email($request_id);
		$email[2] = $this->request->get_request_details($request_id);
		$email[3] = $this->request->get_approver_details($request_id);
		$email[4] = $this->request->get_approver_emails($request_id);
		$email[5] = $this->request->get_request_area_by_id($request_id);
		$email[6] = $this->request->send_email_request_to_approver($request_id, "REJECT", 23);
		//$this->request->changeStatus($request_id);
		// echo json_encode(array("_sent"=> $email));
		echo json_encode($email);
	}
	
	/*NOT USED*/
	public function send_email()
	{
		$this->load->library('email');
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_user'] = SITE_EMAIL_USER; 
		$config['smtp_pass'] = SITE_EMAIL_PASSWORD;
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

		$this->email->initialize($config);

		$this->email->from('someuser@gmail.com', 'Blabla');
		$list = array('someuser@gmail.com', 'gasemilla@globe.com.ph');
		$this->email->to($list);
		$this->email->cc('someuser@gmail.com');
		$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
		$this->email->subject('This is an email test');
		$this->email->message('It is working. Great! x2');
		
		if ($this->email->send())
			$data['msg'] = $this->email->print_debugger();
		else
			$data['msg'] = show_error($this->email->print_debugger());
		
		return $data;
	}
	
	/*
	public function site_list()
		// $output = array(
			// "draw" => $_POST['draw'],
			// "recordsTotal" => $this->request->count_all(),
			// "recordsFiltered" => $this->request->count_filtered(),
			// "data" => $data,
		// );
		// echo json_encode($output);
		$data = array();
		$data = $this->request->get_sitename();
		$output = array(
			"data" => , $data
			);
		echo json_encode($output);
	}*/
	
	/** TO populate the content of the dropdownlist of site_name*/
	public function ajax_site_list()
	{
		$list = $this->request->get_sitename();
		$data = array();
		$no = 0;
		foreach ($list as $request) {
			$no++;
			$row = array();
			$row['id'] = $request->id;
			$row['site_name'] = $request->site_name;
			$row['area'] = $request->area;
			$row['google_calendar_frame'] = $request->google_calendar_frame;
			$data[] = $row;
		}
		//output to json format
		echo json_encode($data);
	}
	
	/** TO populate the content of the dropdownlist of activity_type */
	public function ajax_activity_type_checklist()
	{
		$activity_type = $this->input->get('activity_type');
		$list = $this->request->get_activity_type_checklist_for_dropdown($activity_type);
		$data = array();
		$no = 0;
		foreach ($list as $request) {
			$no++;
			$row = array();
			$row['id'] = $request->id;
			$row['activity_type_prerequisite'] = $request->activity_type_prerequisite;
			$row['activity_type_id'] = $request->activity_type_id;
			$data[] = $row;
		}
		//output to json format
		echo json_encode($list);
	}
	
	/** TO populate the content of the dropdownlist of site_name*/
	public function ajax_date_color()
	{
		$list = $this->request->get_date_color();
		$data = array();
		$no = 0;
		foreach ($list as $request) {
			$no++;
			$row = array();
			$row['id'] = $request->id;
			$row['color'] = $request->color;
			$row['date'] = $request->date;
			//$row['reason_of_blockage'] = $request->reason_of_blockage;
			$data[] = $row;
		}
		//output to json format
		echo json_encode($data);
	}

	public function ajax_get_activity_requirement_checklist_as_array()
	{
		$checklist = $this->input->get('checklist');
		echo json_encode($this->request->get_activity_type_checklist_array($checklist));
	}
	
	/* 
		Get the fram link from the db 
		Not USED
	*/
	public function ajax_google_link()
	{
		$site_id = $this->input->get('site_id');
		$google_frame = $this->request->get_site_google_link_by_id($site_id);
		echo json_encode($google_frame);
	}
	
	/** TO populate the content of the dropdownlist of activity_type 9/12/16*/
	public function ajax_activity_type_list()
	{
		$list = $this->request->get_activity_types();
		$data = array();
		$no = 0;
		foreach ($list as $request) {
			$no++;
			$row = array();
			$row['id'] = $request->id;
			$row['activity_type'] = $request->activity_type;
			$data[] = $row;
		}
		//output to json format
		echo json_encode($data);
	}
	
	/*NOT USED*/
	public function ajax_all_request()
	{
		$list = $this->request->get_all_request();
		// $data = array();
		// $no = 0;
		// foreach ($list as $request) {
			// $no++;
			// $row = array();
			// $row['id'] = $request->id;
			// $row['site_name'] = $request->site_name;
			// $row['area'] = $request->area;
			// $data[] = $row;
		// }
		//output to json format
		echo json_encode($list);
	}
	
	/* NOT USED*/
	public function setFlash_Message($message, $class)
	{
		$this->session->set_flashdata('success', $message);
		// $messge = array('message' => $message, 'class' => 'alert alert-'.$class.' fade in');
		// $this->session->set_flashdata('item', $messge );
	}
	
	//This function checks your session 
	function check_session()
	{
		$user_id = $this->session->userdata('user_id');
		if ($user_id) {
			echo 1;
			//$this->session->sess_destroy();
		} else {
			echo 0;
			redirect('login');//redirect from here or you can redirect in the ajax response
		}
		die();
	}
}


