<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User extends CI_Controller {
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model','user');
	}
	
	public function index() {	
	}
	
	
	/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register() 
	{
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('company', 'Company', 'trim|required');
		$this->form_validation->set_rules('department', 'Department', 'trim|required');
		$this->form_validation->set_rules('immediate_supervisor', 'Immediate Supervisor', 'trim|required');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]|callback_email_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/register/register', $data);
			$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$firstname  = $this->input->post('firstname');
			$lastname   = $this->input->post('lastname');
			$company    = $this->input->post('company');
			$department = $this->input->post('department');
			$immediate_supervisor = $this->input->post('immediate_supervisor');
			$area = $this->input->post('area');
			
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user->create_user(
				$firstname, $lastname, $company, $department, $immediate_supervisor,
				$area, $username, $email, $password)) {
				
				// user creation ok
				$this->load->view('header');
				$this->load->view('user/register/register_success', $data);
				$this->load->view('footer');
			} else {
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/register/register', $data);
				$this->load->view('footer');	
			}
		}
	}
	
	/*
		For email callbakc_email_check - to manipulate the format od the email on submission (form_validation) 
	*/	
	function email_check($str)
	{
		if (stristr($str,'@globe.com.ph') !== false) return true;
		// if (stristr($str,'@uni-email-2.com') !== false) return true;
		// if (stristr($str,'@uni-email-3.com') !== false) return true;
		
		$this->form_validation->set_message('email_check', 'Please provide an acceptable email address.<br/>E.g. <username>@globe.com.ph');
		return false;
	}
	
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/login/login');
			$this->load->view('footer');
		} else {
			// set variables from the form
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if ($this->user->resolve_user_login($username, $password)) {
				$user_id = $this->user->get_user_id_from_username($username);
				$user    = $this->user->get_user($user_id);
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['id_num']       = (int)$user->id_num;
				$_SESSION['username']     = (string)$user->username;
				$_SESSION['email']  	  = (string)$user->email;
				$_SESSION['firstname']    = (string)$user->firstname;
				$_SESSION['lastname']     = (string)$user->lastname;
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
				$_SESSION['is_admin']     = (bool)$user->is_admin;
				$_SESSION['is_approver']  = (bool)$user->is_approver;
				$_SESSION['area']  		  = (string)$user->area;
				//$_SESSION['email'] = $this->send_email();
				$data->logged_in_success = "Success!";
				$data->request_id = 0;
				// user login ok
				$this->load->view('header');
				$this->load->view('user/login/login_success', $data);
				$this->load->view('footer');
			} else {
				// login failed
				$data->error = 'Wrong username or password.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/login/login', $data);
				$this->load->view('footer');	
			}
		}
	}
	
	private function isLoggedIn()
	{
		return (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true);
	}

	/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if ($this->isLoggedIn()) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			$this->load->view('header');
			$this->load->view('user/logout/logout_success', $data);
			$this->load->view('footer');
			
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect('/');	
		}	
	}
	
	function profile()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->isLoggedIn()) {
			// set common properties
			$data['title'] = 'User Details';
			$data['link_back'] = anchor('user/index/','Back to list of persons',array('class'=>'back'));
			$data['user'] = $this->user->get_user($_SESSION['user_id']); // get user details and display to VIEW
			
			// load view
			$this->load->view('header');
			$this->load->view('user/profile/profile', $data);
			$this->load->view('footer');
		} else {
			redirect('/');	
		}
	}

	public function ajax_edit($id) // request data to form
	{
		$data = $this->user->get_user($id);
		echo json_encode($data);
	}

	public function ajax_update()
	{
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		// $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		// $this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|min_length[6]|matches[password]', array('error' => 'Password does not match the passwor above.'));
		
		if ($this->form_validation->run() == false) {
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/');
			$this->load->view('footer');
		} else {
			/** Svave password if it is set on the profile edit form */
			if ($this->input->post('password') == "" || $this->input->post('password') == null)
				$data = array(
					'firstname'	 	 		=> $this->input->post('firstname'),
					'lastname'	 	 		=> $this->input->post('lastname'),
					'company'	 	 		=> $this->input->post('company'),
					'department'	 		=> $this->input->post('department'),
					//'area'			 		=> $this->input->post('area'),
					'immediate_supervisor'	=> $this->input->post('immediate_supervisor'),
					'updated_at'	 	 	=> date('y-m-d'),
					'username'	 			=> $this->input->post('username'),
					'email'	 				=> $this->input->post('email'),
					//'password'	 			=> $this->input->post('password') // password is not filled up so retain the value from the db
				);
			else
				$data = array(
					'firstname'	 	 		=> $this->input->post('firstname'),
					'lastname'	 	 		=> $this->input->post('lastname'),
					'company'	 	 		=> $this->input->post('company'),
					'department'	 		=> $this->input->post('department'),
					//'area'			 		=> $this->input->post('area'),
					'immediate_supervisor'	=> $this->input->post('immediate_supervisor'),
					'updated_at'	 	 	=> date('y-m-d'),
					'username'	 			=> $this->input->post('username'),
					'email'	 				=> $this->input->post('email'),
					'password'	 			=> $this->input->post('password')
				);
			$this->user->update(array('id' => $this->input->post('id')), $data);
			
			$this->update_username_at_request_model_after(
				array(
					'user_id'	 	 		=> $_SESSION['user_id'],
					'firstname'	 	 		=> $this->input->post('firstname'),
					'lastname'	 	 		=> $this->input->post('lastname')
				)
			);
		}
		echo json_encode(array("status" => TRUE));
	}
	
	/* 
		Update all request DATA of user 
			if and only if FName and LName has been modified by the user
	*/
	private function update_username_at_request_model_after($data) {
		//if ($this->is_name_updated($data)) 
		{
			$this->user->update_username_after_update_user_profile(
				$data['user_id'],
				array(
					'firstname' => $data['firstname'],
					'lastname'	=> $data['lastname']
				)
			);
		}
	}
	
	private function is_name_updated($data)
	{
		$this->db->select('firstname, lastname');
		$this->db->from('users');
		$this->db->where('id', $data['user_id']);
    	$query = $this->db->get();
		foreach ($query->result_array() AS $row) {
			if ($row['firstname'] != $data['firstname'] || $row['lastname'] != $data['lastname'])
				return true;
			else
				return false;
		}
	}
	
	public function ajax_update_OLD()
	{
		/**Svave password if it is set on the profile edit form*/
		if ($this->input->post('password') == "" || $this->input->post('password') == null)
			$data = array(
				'firstname'	 	 		=> $this->input->post('firstname'),
				'lastname'	 	 		=> $this->input->post('lastname'),
				'company'	 	 		=> $this->input->post('company'),
				'department'	 		=> $this->input->post('department'),
				'area'			 		=> $this->input->post('area'),
				'immediate_supervisor'	=> $this->input->post('immediate_supervisor'),
				'updated_at'	 	 	=> date('y-m-d'),
				'username'	 			=> $this->input->post('username'),
				'email'	 				=> $this->input->post('email')
			);
		else
			$data = array(
				'firstname'	 	 		=> $this->input->post('firstname'),
				'lastname'	 	 		=> $this->input->post('lastname'),
				'company'	 	 		=> $this->input->post('company'),
				'department'	 		=> $this->input->post('department'),
				'area'			 		=> $this->input->post('area'),
				'immediate_supervisor'	=> $this->input->post('immediate_supervisor'),
				'updated_at'	 	 	=> date('y-m-d'),
				'username'	 			=> $this->input->post('username'),
				'email'	 				=> $this->input->post('email'),
				'password'	 			=> $this->input->post('password')
			);
		$this->user->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	/*Not used*/
	public function send_email()
	{
		$this->load->library('email');
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_user'] = "someuser@gmail.com"; 
		$config['smtp_pass'] = "****";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

		$this->email->initialize($config);

		$this->email->from('someuser@gmail.com', 'Blabla');
		$list = array('someuser@gmail.com', 'LLLunar@smart.com.ph', 'RCRaguine@smart.com.ph');
		$this->email->to($list);
		$this->email->cc('someuser@gmail.com');
		$this->email->reply_to('my-email@gmail.com', 'Explendid Videos');
		$this->email->subject('This is an email test');
		$this->email->message('It is working. Great! x2');
		//$this->email->send();
		// $config = Array(
			// 'protocol' => 'smtp',
			// 'smtp_host' => 'ssl://smtp.googlemail.com',
			// 'smtp_port' => 465,
			// 'smtp_user' => 'someuser@gmail.com',
			// 'smtp_pass' => '****'
		// );
        // $this->load->library('email', $config);
		// $this->email->set_newline("\r\n");
		
		// $data["message"] = "THe email has successfully been sent through codeigniter phpmyadmin...";
		// $data["subject"] = "Testing email codeigniter";
		// $list = array('RCRaguine@smart.com.ph', 'someuser@gmail.com');
		
		// $this->email->from('someuser@gmail.com', 'Richard');
		// $this->email->to('someuser@gmail.com');
		// $this->email->cc('someuser@gmail.com');
		// $this->email->subject('Message from codeigniter');
		// $this->email->message("It is working. Yeahey!");
		
		if ($this->email->send())
			$data['msg'] = $this->email->print_debugger();
		else
			$data['msg'] = show_error($this->email->print_debugger());
		
		return $data;
	}
	
	public function batch_email($recipients, $subject, $message) 
	{
		$this->email->clear(TRUE);
		$this->email->from('you@yoursite.com', 'Display Name'); 
		$this->email->to('youremailaddress@yourserver.com');
		$this->email->bcc($recipients);
		$this->email->subject($subject);
		$this->email->message($message);  

		$this->email->send();

		return TRUE;
	}
}
