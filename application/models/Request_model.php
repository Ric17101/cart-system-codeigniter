<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Request_model extends CI_Model {

	var $table = 'requests';
	var $column_order = array(
		'request_id',
		'activity_type',
		'criticality',
		'activity_desc',
		'project_name',
		'employee_id',
		'employee_name',
		'department',
		'site_name',
		'discipline',
		'ne_involved',
		'date',
		'start_time',
		'end_time',
		'activity_date',
		'gt_project_prop',
		'contact_num_prop',
		'gt_rep',
		'contact_num_rep',
		'vendor_rep',
		'contact_num_vendor',
		'reference_docs',
		'so_ref_number',
		'trs_config_number',
		'request_status',
		'_status',
		'activity_status',
		'remarks', // 26 COLUMNS with id + actions = 27
		'approval_notes',
		null); // set column field database for datatable orderable
	// var $column_search = array(
		// 'request_id',
		// 'activity_status',
		// '_status'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $column_search = array(
		'request_id',
		'activity_type',
		'criticality',
		'activity_desc',
		'project_name',
		'employee_id',
		'employee_name',
		'department',
		'site_name',
		'discipline',
		'ne_involved',
		'date',
		'start_time',
		'end_time',
		'activity_date',
		'gt_project_prop',
		'contact_num_prop',
		'gt_rep',
		'contact_num_rep',
		'vendor_rep',
		'contact_num_vendor',
		'reference_docs',
		'so_ref_number',
		'trs_config_number',
		'request_status',
		'_status',
		'activity_status',
		'remarks',
		'approval_notes'
		);
	var $order = array('request_id' => 'desc'); // default order 
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		if (($_SESSION['area'] != '' || $_SESSION['area'] != null) && $_SESSION['is_approver']) // Approver
		{
			$condition = $array = array('site_name' => $_SESSION['area'], 'is_deleted' => 0); // TO SHOW only per area and the deleted data
			$this->db->where($condition); // This line is added to filter approver by area
		}
		else // Requestor
		{
			$where = "(employee_id='".$_SESSION['user_id']."' OR employee_name='".$_SESSION['username']."') AND is_deleted=0";
			$this->db->where($where);
		}
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{
				if ($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if (isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	/*Used to query for the area/site_name for the logged in approver only*/
	function get_datatables_by_area()
	{
		$this->_get_datatables_query();
		$condition = $array = array('site_name' => $_SESSION['area'], 'is_deleted' => 0);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		if ($_SESSION['area'] != '' || $_SESSION['area'] != null) // Test if area for the request so he can see all request
			$this->db->where($condition); // This line is added to filter approver by area
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	/*NOT USED*/
	/*Return all data from database table request 8/31/2016*/
	public function get_all_request()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('request_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function getDataById($id) {
        $this->db->where('request_id', $id);
        return $this->db->get($this->table)->result();
    }

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	/* 
		To select the Full Name as one column for the DataTable
		Set First Characters of LName and FName to Upper Case
		@param $user_id int
	*/
	public function get_requestor_fullname_by_user_id($user_id)
	{
		$this->db->from('users');
		$this->db->where('id', $user_id);
		$query = $this->db->get();
		$details = $query->result_array();
		$full_name = "";
		foreach ($details as $v){ // to return the specific detail
			$full_name = ucfirst($v['firstname'])." ".ucfirst($v['lastname']);
		}
		return $full_name;
	}
	
	/* 
		Called after update on User Profile
		NOT USED Here
		SET and CALLED at User_model.php
	*/
	public function update_username_after_update_user_profile($where, $data_)
	{
		$data = array('employee_name' => $data_['firstname']." ".$data_['lastname']);
		
		$this->db->where('employee_id', $where);
		$this->db->update($this->table, $data);
		
		// $this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	/*
		if Date is Duplicate UPDATE
		else INSERT
		
		GREEN is 0, then it is deleted
	*/
	public function save_color($data)
	{
		$this->db->from('activity_calendar_blocked_date');
		$this->db->where('date', $data['date']);
		$q = $this->db->get();
		if ($data['color'] != '0') {
			if ( $q->num_rows() > 0 ) {
				$this->db->where('date', $data['date']);
				$this->db->update('activity_calendar_blocked_date', $data);
			} else {
				$this->db->insert('activity_calendar_blocked_date', $data);
			}
			return $this->db->insert_id();
		}
		else {
			$this->db->where('date', $data['date']);
			$this->db->delete('activity_calendar_blocked_date');
			return $date['date'];
		}
	}
	
	/*
		if Duplicate UPDATE
		else INSERT
	*/
	public function save_color_OLD($data)
	{
		$this->db->from('activity_calendar_blocked_date');
		$this->db->where('date', $data['date']);
		$q = $this->db->get();
		
		if ($q->num_rows() > 0)
		{
			$this->db->where('date', $data['date']);
			$this->db->update('activity_calendar_blocked_date', $data);
		} else {
			$this->db->insert('activity_calendar_blocked_date', $data);
		}
		return $this->db->insert_id();
	}

	/* RETURN False if failed to update the request*/
	public function update($where, $data)
	{
		if ($this->test_if_cancelled($where['request_id'])) // TEST if ALready cancelled thenn after modification by Requestor wil become For Approval to Approver
		{
			$data['request_status'] = 'For Approval';
			$data['_status'] = 0;
		}
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	/*
		Return TRUE if status is 3
		CALLED here and ON UPDATE AJAX Request in order to change the calue of SUBJECT in EMAIL when update
	*/
	public function test_if_cancelled($request_id)
	{
		$this->db->select('_status');
		$this->db->from($this->table);
		$this->db->where('request_id', $request_id);
    	$query = $this->db->get();
		$data = array();
		foreach($query->result_array() AS $row) {
			if ($row['_status'] == 3)
				return true;
			else
				return false;
		}
	}

	/*
		TODO add new line the the remarks when new remarks has been save by the approver
		Make sure you will evaluate if you'll use the _status or not
		Save/Update the remarks of the approver IMPORTANT!!!
		CALLED only at PAGE
	*/
	public function update_request_with_remarks($request_id, $data)
	{
		$data_table = array();
		if ($data['action'] == 1)
		{
			$data_table = array(
				'_status'=> 1, 
				'request_status'=> 'Accepted', 
				'approval_notes'=> $data['approval_notes']);
		}
		else if ($data['action'] == 2)
		{
			$data_table = array(
				'_status'=> 2, 
				'request_status'=> 'Rejected', 
				'approval_notes'=> $data['approval_notes']);
		}
		else
		{
			$data_table = array(
				'_status'=> 3,
				'request_status'=> 'Cancelled', 
				'approval_notes'=> $data['approval_notes']);
		}
		/*Update by request_id*/
		$this->db->where('request_id', $request_id);
    	$this->db->update($this->table, $data_table);
		if ($data['action'] == 1)
			return 'ACCEPTED';
		else if ($data['action'] == 3)
			return 'CANCELLED';
		else 
			return 'REJECTED';
	}
	
	/* Changed all the excess query to input parameter using GET Method from AJAX script */
	public function update_request_with_remarks_OLD($request_id, $data)
	{
		$this->db->from($this->table);
		$this->db->where('request_id',$request_id);
		$query = $this->db->get();
		
		foreach($query->result_array() AS $row) {
			if ($row['_status'] == 2  
				|| $row['request_status'] == 'Rejected' 
				// || $row['request_status'] == 'For Approval' 
				// || $row['_status'] == 0 
				|| $row['_status'] == '' 
				|| $row['_status'] == null)
			{
				//$data = array('_status'=> 1, 'request_status' => 'Accepted');
				$data['_status'] = 1;
				$data['request_status'] = 'Accepted';
			}
			if ($row['request_status'] == 'For Approval' || $row['_status'] == 0)
			{
				$data['_status'] = 2;
				$data['request_status'] = 'Rejected';
			}
			else
			{
				
			}
		}
		/*Update by request_id*/
		$this->db->where('request_id', $request_id);
    	$this->db->update($this->table, $data);
		
		// return $query->result();
		// return $query;
		if ($data['action'] == 1)
			return 'ACCEPTED';
		else 
			return 'REJECTED';
	}
	
	/*
		NOT USED
		DELETE Permanently when this is used
	*/
	public function delete_by_id_OLD($request_id)
	{
		$this->db->where('request_id', $request_id);
		$this->db->delete($this->table);
	}
	
	public function delete_by_id($request_id)
	{
		$this->delete_by_id_is_deleted($request_id);
	}
	
	/* 
		DO not DELETE permanentlty, this will update is_deleted only
		Will remain the data for the request for future references
	*/
	public function delete_by_id_is_deleted($request_id)
	{
		$data = array('is_deleted' => 1, 'deleted_by' =>  $_SESSION['user_id']);
		$this->db->where('request_id', $request_id);
    	$this->db->update($this->table, $data);
	}
	
	/*NOT USED*/
	/*DELETE Multiple RequestID*/
	public function delete_multiple_id($ids)
	{
		$this->db->where_in('id', $ids);
		$this->db->delete($this->table);
	}
	
	// Update 1 column by ID
	public function approve_by_id($request_id, $approval_status)
	{
		// $this->db->from($this->table);
		// $this->db->where('request_id', $request_id);
		// $query = $this->db->get();
		// $data = array();
		// foreach($query->result_array() AS $row) {
			// if ($row['_status'] == 0 
				// || $row['_status'] == 2  
				// || $row['request_status'] == 'Rejected' 
				// || $row['request_status'] == 'For Approval' 
				// || $row['_status'] == '' 
				// || $row['_status'] == null)
				// $data = array('_status'=> 1, 'request_status'=> 'Accepted');
			// else
				// $data = array('_status'=> 2, 'request_status'=> 'Rejected');
		// }
		if ($approval_status == 2)
			$data = array('_status'=> 2, 'request_status'=> 'Rejected');
		else if ($approval_status == 3)
			$data = array('_status'=> 3, 'request_status'=> 'Cancelled');
		else
			$data = array('_status'=> 1, 'request_status'=> 'Accepted');
		/*Update by request_id*/
		$this->db->where('request_id', $request_id);
    	$this->db->update($this->table, $data);
		return $data['_status'];
	}
	
	/*Update approve_by and is_email_sent request by request_id 9/8/16*/
	public function set_approve_by_and_email_sent($request_id, $status)
	{
		$data = array('approve_by'=>  $_SESSION['user_id'], 'is_email_sent'=> $status);
		$this->db->where('request_id', $request_id);
    	$this->db->update($this->table, $data);
	}
	
	public function approve_by_id_OLD($request_id)
	{
		$this->db->from($this->table);
		$this->db->where('request_id',$request_id);
		$query = $this->db->get();
		$data = array();
		foreach($query->result_array() AS $row) {
			if ($row['_status'] == 0 || $row['_status'] == '' || $row['_status'] == null)
				// $data = array('_status'=> 1, 'request_status'=> 'Accepted', 'approve_by'=>  $_SESSION['user_id']);
				$data = array('_status'=> 1);
			else
				// $data = array('_status'=> 2, 'request_status'=> 'Rejected', 'approve_by'=>  $_SESSION['user_id']);
				$data = array('_status'=> 2);
		}
		/*Update by request_id*/
		$this->db->where('request_id', $request_id);
    	$this->db->update($this->table, $data);
		return $data;
	}
	
	
	// NOT USED
	public function changeStatus($id) {
		$table = $this->getDataById($id);
		if ($table[0]->_status=='0')
		{
			$this->update($id,array('_status' => '1'));
			return "Approved";
		} else if ($table[0]->_status=='1'){
			$this->update($id,array('_status' => '2'));
			return "Rejected";
		} else { // I think it's not being used???
			$this->update($id,array('_status' => '0'));
			return "For Approval";
		}
		
	}
	
	/*Used at footer for ajax/jquery Ask text as (Reject/Accept)
		NOT USED
	*/
	public function getStatusById($id)
	{
		$this->db->select('_status', 'request_status');
		$this->db->from($this->table);
		$this->db->where('request_id', $id);
		$status = $this->db->get();
		return $status;
	}
	
	public function get_sitename()
    {
		//2nd
		$query = $this->db->query('SELECT id, site_name, area, google_calendar_frame FROM sites');
        return $query->result();
		//OR
		///$this->db->select('ConfLName');
		//$this->db->from('conference');
    }
	
	public function get_date_color()
    {
		//$query = $this->db->query('SELECT id, color, date, reason_of_blockage FROM activity_calendar_blocked_date');
		$query = $this->db->query('SELECT id, color, date FROM activity_calendar_blocked_date');
        return $query->result();
    }
	
	public function get_site_google_link_by_id($id)
	{
		$this->db->select('google_calendar_frame');
		$this->db->from('sites');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$details = $query->result_array();
		$google_calendar_frame = "";
		foreach ($details as $v){ // to return the specific detail
			$google_calendar_frame = $v['google_calendar_frame'];
		}
		return $google_calendar_frame;
	}
	
	public function get_activity_types()
    {
		$query = $this->db->query('SELECT id, activity_type FROM activity_types');
        return $query->result();
    }
	
	/*GET the details for the request_id's requestor from USERS TABLE*/
	public function get_requestor_email($request_id)
	{
		/*Get employee_id from requests tables by requestID*/
		$this->db->select('employee_id');
		$this->db->from($this->table);
		$this->db->where('request_id', $request_id);
		$user_id = $this->db->get();
		
		/*Get email of user/requestor by request_id*/
		$requestor_id = 0;
		foreach ($user_id->result_array() AS $row) {
			$requestor_id = $row['employee_id'];
		}
		
		$this->db->select('email, firstname, lastname');
		$this->db->from('users');
		$this->db->where('id', $requestor_id);
		//$this->db->or_where('id_num', $requestor_id);
		$email = $this->db->get();
		// return $email->result_array(); // TESTING for ajax_send_email_request from Request.php then call it with ID Like so http://localhost/CI/request_anabelle_v2.0.2/request/ajax_send_email_request/81
		return $email;
	}
	
	public function get_request_details($request_id)
	{
		$this->db->from($this->table);
		$this->db->where('request_id', $request_id);
		$details = $this->db->get();
		// return $details->result_array();
		return $details;
	}
	
	/*
		USED By Delete - ajax_delete
		Return only the value of 'area' column for the 
	*/
	public function get_request_area_by_id($request_id)
	{
		$this->db->select('site_name');
		$this->db->from($this->table);
		$this->db->where('request_id', $request_id);
		$query = $this->db->get();
		$details = $query->result_array();
		$site_name = "";
		foreach ($details as $v){ // to return the specific detail
			$site_name = $v['site_name'];
		}
		return $site_name;
	}
	
	public function get_approver_details($id_num)
	{
		$this->db->from('users');
		$this->db->where('id', $id_num);
		// $this->db->or_where('id_num', $id_num);
		$user_details = $this->db->get();
		// return $user_details->result_array();
		return $user_details;
	}
	
	/* 
		Return (array) all approver's email by area
	*/
	public function get_approver_emails($request_id)
	{
		$area = $this->get_request_area_by_id($request_id);
		$this->db->select('email');
		$this->db->from('users');
		$this->db->where('area', $area);
		$query = $this->db->get();
		$user_emails = array_column($query->result_array(),'email');
		return $user_emails;
	}
	
	function is_connected()
	{
		$connected = @fsockopen("ssl://smtp.gmail.com", 465); 
		if ($connected){
			$is_conn = true; //action when connected
			fclose($connected);
		}else{
			$is_conn = false; //action in connection failure
		}
		return $is_conn;
	}
	
	/*
		SEND EMAIL TO APPROVER
		ACTION Tirggered when:
			User Modified the Requets
			Create new request
		requestor_id is not used...?
	*/
	public function send_email_request_to_approver($request_id, $action, $requestor_id)
	{
		$host_email = SITE_EMAIL_USER;
		$this->load->library('email');
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_timeout'] = '7';
		$config['smtp_user'] = $host_email;
		$config['smtp_pass'] = SITE_EMAIL_PASSWORD;
		$config['charset'] = "utf-8";
		$config['newline'] = "\r\n";
		$config['mailtype'] = "html";
		$config['validation'] = TRUE; // bool whether to validate email or not
		

		$this->email->initialize($config);
		$this->email->from($host_email);
		$approver_emails = $this->get_approver_emails($request_id); // GET approvers email by area
		$sender_details = $this->get_requestor_email($request_id);
		$requestor_email = "";
		$requestor_name = "";
		foreach ($sender_details->result_array() AS $row) {
			$requestor_email = $row['email'];
			$requestor_name = $row['firstname']." ".$row['lastname'];
		}
		$list_cc = array(
			// 'obkatigbak@globe.com.ph',
			// 'oliver_katigbak@yahoo.com',
			$requestor_email
		);
		$list_to = array();
		$list_to = $approver_emails; 
		$list_to[] = $host_email;
		
		$this->email->to($list_to);
		$this->email->cc($list_cc);
		$this->email->subject('ACTIVITY REQUEST '.$action.' (ID: '.$request_id.')');
		$request_details = $this->get_request_details($request_id);
		$data_ = array();
		foreach ($request_details->result_array() AS $row) {
			$data_['is_approver'] = false;
			$data_['activity_desc'] = $row['activity_desc'];
			$data_['employee_name'] = $requestor_name;
			$data_['requestor_email'] = $requestor_email;
			$data_['site_name'] = $row['site_name'];
			$data_['ne_involved'] = $row['ne_involved'];
			$data_['request_id'] = $row['request_id'];
			$data_['activity_date'] = $row['activity_date'];
			$data_['start_time'] = $this->ftime($row['start_time'], 12);
			$data_['end_time'] =  $this->ftime($row['end_time'], 12);
			// $data_['link'] = "http://localhost/CI/CART/request/view_details/?request_id=".$row['request_id'];
			//$data_['link'] = $this->config->base_url().'view_details/?request_id='.$row['request_id']; // OK
			$data_['link'] = 'http://heocart.ngrok.io/CI/CART/request/view_details/?request_id='.$row['request_id'];
			$data_['remarks'] = $row['remarks'];
			$data_['reason_for_short_notice'] = $row['reason_for_short_notice'];
			// $data_ = array(
				// 'is_approver' => false,
				// 'activity_desc' => $row['activity_desc'],
				// 'employee_name' => $row['employee_name'],
				// 'request_id' => $row['request_id'],
				// 'date' => $row['date'],
				// 'start_time' => $row['start_time'],
				// 'end_time' => $row['end_time'],
				// 'link' => "http://localhost/CI/CART/request/view_details/?request_id=".$row['request_id']
            // );
		}
		
		$body = $this->load->view('email_template_for_requestor', $data_, TRUE);
		
		$this->email->message($body);
		$data = array();
		if ($this->is_connected())
			if ($this->email->send()) /**For debugging purposes only*/
			{
				$data['msg'] = $this->email->print_debugger();
				$is_sent = TRUE;
				$this->set_approve_by_and_email_sent($request_id, 1); // SET APPROVE EMAIL
			}
			else
			{
				// Remove the debugger messages as they're not necessary for the next attempt.
				$this->email->clear_debugger_messages();
				
				$this->send_email_request($request_id, $approval_status, $approver_id); // Recursive call SEND AGAIN
				$is_sent = FALSE;
			}
		else 
			$is_sent = FALSE;
		
		// return $is_sent;
		return $data;
	}
	
	/*	
		SEND EMAIL TO REQUESTOR
		ACTION Tirggered when:
			User Approve/Cancel/Reject Requests
			Create new request
			Delete
	*/
	public function send_email_request($request_id, $approval_status, $approver_id)
	{
		$host_email = SITE_EMAIL_USER;
		$this->load->library('email');
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_timeout'] = '7';
		$config['smtp_user'] = $host_email;
		$config['smtp_pass'] = SITE_EMAIL_PASSWORD;
		$config['charset'] = "utf-8";
		$config['newline'] = "\r\n";
		$config['mailtype'] = "html";
		$config['validation'] = TRUE; // bool whether to validate email or not
		
		$this->email->initialize($config);

		$this->email->from($host_email);
		$approver_details = $this->get_approver_details($approver_id);
		
		$approver_email = "";
		$approver_name = "";
		foreach($approver_details->result_array() AS $row) { // Set approver details emailapprover_details
			$approver_email = $row['email']; // NOT USED to CC instead all Approver Per AREA
			$approver_name = $row['firstname']." ".$row['lastname'];
		}
		$approver_emails = $this->get_approver_emails($request_id); // GET approvers email by area
		
		$sender_details = $this->get_requestor_email($request_id);
		$requestor_email = new stdClass();
		foreach($sender_details->result_array() AS $row) {
			$requestor_email = $row['email'];
		}
		$list_to = array(
			// 'obkatigbak@globe.com.ph',
			// 'oliver_katigbak@yahoo.com',
			$requestor_email
			);
		$list_cc = array_merge(array($host_email), $approver_emails);
			
		$this->email->to($list_to);
		$this->email->cc($list_cc);
		$this->email->subject('ACTIVITY REQUEST '.$approval_status.' (ID: '.$request_id.')');
		$request_details = $this->get_request_details($request_id);
		// $msg_body = new stdClass();
		$data_ = array();
		foreach ($request_details->result_array() AS $row) {
			//$msg_body = $row['email'];
			// $msg_body = 
				// "<strong>REQUEST DETAILS:</strong><br/>".
				// "Activity description: ".$row['activity_desc'].
				// "<br/>Approval Status: ".$approval_status.
				// "<br/>Approver Name: ".$approver_name.
				// "<br/>Requestor Name: ".$row['employee_name'].
				// "<br/>Request ID: ".$row['request_id'].
				// "<br/>Date: ".$row['date'].
				// "<br/>Start Time: ".$row['start_time'].
				// "<br/>End Time: ".$row['end_time'].
				// "<br/>Remarks: ".$row['remarks']. // SHOULD CHANGE THIS REMARKS to hardcoded remarks and save to database
				// "<br/>Link: http://localhost/CI/CART/request/view_details/?request_id=".$row['request_id']; // LINK will vary on the machine's VPN
			
			$data_ = array(
				'is_approver' => true,
				'activity_desc' => $row['activity_desc'],
				'approval_status' => $approval_status,
				'approver_name' => $approver_name,
				'approver_email' => $approver_email,
				'employee_name' => $row['employee_name'],
				'requestor_email' => $requestor_email,
				'site_name' => $row['site_name'],
				'ne_involved' => $row['ne_involved'],
				'request_id' => $row['request_id'],
				'activity_date' => $row['activity_date'],
				'start_time' => $this->ftime($row['start_time'], 12),
				'end_time' => $this->ftime($row['end_time'], 12),
				'remarks' => $row['remarks'],
				'approval_notes' => $row['approval_notes'],
				//'link' => $this->config->base_url().'view_details/?request_id='.$row['request_id'], //OK
				'link' => 'http://heocart.ngrok.io/CI/CART/request/view_details/?request_id='.$row['request_id'],
            );
		}
		///////$this->email->attach('C:\Users\xyz\Desktop\images\abc.png'); // EMAIL ATTACHMENTs
		/* SET UP this  from /////http://stackoverflow.com/questions/25416585/codeigniter-send-email-with-attach-file
			$attched_file= $_SERVER["DOCUMENT_ROOT"]."/uploads/".$file_name;
			$this->email->attach($attched_file);
		*/
		// $body = $this->load->view('email_template_for_requestor.php',$data_ ,TRUE);
		$body = $this->load->view('email_template_for_requestor', $data_, TRUE);
			
		$this->email->message($body);
		$data = array();
		if ($this->is_connected())
			if ($this->email->send()) /**For debugging purposes only*/
			{
				$data['msg'] = $this->email->print_debugger();
				$is_sent = TRUE;
				// $this->set_approve_by_and_email_sent($request_id, (($is_sent==TRUE) ? 1 : 0)); // SET APPROVE EMAIL
				$this->set_approve_by_and_email_sent($request_id, 1); // SET APPROVE EMAIL
			}
			else
			{
				// $data['msg'] = show_error($this->email->print_debugger());
				// Remove the debugger messages as they're not necessary for the next attempt.
				$this->email->clear_debugger_messages();
				
				$this->send_email_request($request_id, $approval_status, $approver_id); // Recursive call SEND AGAIN
				$is_sent = FALSE;
			}
		else 
			$is_sent = FALSE;
		
		return $is_sent;
	}
	
	public function test_request_existence($request_id)
	{
		$this->db->from('requests');
		$this->db->where('id', $request_id);
		$request = $this->db->get();
		// $query = $this->db->get_where('table_name',array('ad_code'=>$code,'ad_image'=>$image_link));
		return $request;
	}
	
	/*
		HELPER FUNCTION for formatting 12/24 HR Format 
		//Convert string into 12 hour AM/PM format
		echo ftime("14:23",12);

		//Convert string into 24 hour format
		echo ftime("3:40 pm",24);
	*/
	function ftime($time, $f)
	{
		if (gettype($time)=='string')
		  $time = strtotime($time);
		return ($f==24) ? date("G:i", $time) : date("g:i A", $time);
	}
	
	/*
	 Return major | minor | critical
	*/
	public function test_short_notice($activity_type)
	{
		$this->db->from('activity_types');
		$this->db->where('activity_type', $activity_type);
		$details = $this->db->get();
		foreach ($details->result_array() AS $row) {
			return $row['severity'];
		}
	}
	
	private function get_activity_type_id($activity_type)
	{
		$this->db->from('activity_types');
		$this->db->where('activity_type', $activity_type);
		$query = $this->db->get();
		foreach ($query->result_array() AS $row) {
			return $row['id'];
		}
	}
	
	/*
		Return the data for dropdownlist of Acticity Type Checklist 
		@param activity_type, in wowrd
		@return checklist details [id, act_type_id, req_checklist]
	*/
	public function get_activity_type_checklist_for_dropdown($activity_type)
	{
		$activity_type_id = $this->get_activity_type_id($activity_type);
		return $this->get_activity_type_checklist_details($activity_type_id);
	}
	
	private function get_activity_type_checklist_details($activity_type_id)
	{
		$this->db->from('activity_type_prerequisites');
		$this->db->where('activity_type_id', $activity_type_id);
		$query = $this->db->get();
        return $query->result();
	}
	
	public function get_activity_type_checklist_array($strChecklist)
	{
		$aChecklist = explode(",", $strChecklist);
		$aChecklist_result = array();
		foreach ($aChecklist AS $row)
		{
			$aChecklist_result[] = $this->get_activity_type_checklist_word($row);
		}
		return $aChecklist_result;
	}
	
	/*
		Return each activity_type_prerequisite by id
	*/
	private function get_activity_type_checklist_word($activity_type_id)
	{
		$this->db->from('activity_type_prerequisites');
		$this->db->where('id', $activity_type_id);
		$query = $this->db->get();
		foreach ($query->result_array() AS $row) {
			return $row['activity_type_prerequisite'];
		}
        //return $query->result();
	}
	
	public function asdasd($id) {
		$table = $this->getDataById($id);
		if ($table[0]->_status=='0')
		{
			$this->update($id,array('_status' => '1'));
			return "Approved";
		} else if ($table[0]->_status=='1'){
			$this->update($id,array('_status' => '2'));
			return "Rejected";
		} else { // I think it's not being used???
			$this->update($id,array('_status' => '0'));
			return "For Approval";
		}	
	}
}
