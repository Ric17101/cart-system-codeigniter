<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	var $table = 'users';
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user(
		$firstname, $lastname, $company, $department, $immediate_supervisor,
		$area, $username, $email, $password) 
	{
		
		$data = array(
			'firstname' 			=> $firstname,
			'lastname' 				=> $lastname,
			'company' 				=> $company,
			'department' 			=> $department,
			'immediate_supervisor' 	=> $immediate_supervisor,
			//'area'      			=> $area,
			
			'username'   			=> $username,
			'email'      			=> $email,
			
			'password'   			=> $password,
			'created_at' 			=> date('Y-m-j H:i:s'),
		);
		return $this->db->insert($this->table, $data);
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($username, $password) {
		$this->db->select('password');
		$this->db->from($this->table);
		$this->db->where('username', $username);
		$hash = $this->db->get()->row('password');
		if ($hash == $password)
		// // if ($hash == $password)
			return true;
		else
			return false;
		// return $this->verify_password_hash($password, $hash);
	}
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {
		
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('username', $username);

		return $this->db->get()->row('id');
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from($this->table);
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	/* 
		Called after update on User Profile
	*/
	public function update_username_after_update_user_profile($where, $data_)
	{
		$data = array('employee_name' => $data_['firstname']." ".$data_['lastname']);
		
		$this->db->where('employee_id', $where);
		$this->db->update('requests', $data);
		
		// $this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
}
