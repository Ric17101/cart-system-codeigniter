<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('calendar_model','requests');
    }


	/*Home page Calendar view  */
	// public function index()
	// {
	// 	$this->load->view('home');
	// }

	public function index()
	{
		$this->load->helper('url');
		//$this->load->view('header');
		$this->load->view('calendar_view');
		// $this->load->view('footer');
	}

	/*Get all Requests/Events By site_id */
	public function getEvents()
	{
		$site_id = $this->input->get('site_id');
		$result = $this->requests->getEvents($site_id);
		echo json_encode($result);
	}
	
	public function getEvents_OLD()
	{
		$result = $this->requests->getEvents_OLD();
		echo json_encode($result);
	}
	
	/*Get all Requests/Events By site_id */
	public function getDateRequestCountAllWindowPeriod()
	{
		$site_id = $this->input->get('site_id');
		$result = $this->requests->getDateRequestCountAllWindowPeriod($site_id);
		echo json_encode($result);
	}
	
	/*Get all Requests/Events */
	public function getDateRequestCountAll()
	{
		$result = $this->requests->getDateRequestCountAll();
		echo json_encode($result);
	}
	
	/*Add new event */
	public function addEvent()
	{
		$result = $this->calendar->addEvent();
		echo $result;
	}
	/*Update Event */
	public function updateEvent()
	{
		$result = $this->calendar->updateEvent();
		echo $result;
	}
	/*Delete Event*/
	public function deleteEvent()
	{
		$result = $this->calendar->deleteEvent();
		echo $result;
	}
	public function dragUpdateEvent()
	{
		$result = $this->calendar->dragUpdateEvent();
		echo $result;
	}



}
