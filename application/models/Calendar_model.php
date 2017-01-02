<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model {
	// var $table = 'events';
	//var $table = "calendar";
	var $table = 'requests';
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	/*Read the data from DB */
	public function getEvents_OLD() // SHOULD BE FILTERED by date or USE GET?POST to catch as  <> pressed
	{ 
		// $sql = "SELECT * FROM " + $this->table; //+ " WHERE calendar.date BETWEEN ? AND ? ORDER BY calendar.date ASC";
		// $query = $this->db->get();
		// return $query->result();
		// return $this->db->query($sql, array($_GET['start'], $_GET['end']))->result(); 
		
		$this->db->from($this->table);
		//$this->db->where('_status', '1');
		return $this->db->get()->result();
	}
	
	public function getEvents($site_id) // SHOULD BE FILTERED by date or USE GET?POST to catch as  <> pressed
	{ 
		$site_name = $this->getSite_NameByID($site_id);
		$sql = "SELECT *, date AS `activity_date`, `activity_date` AS `date` FROM requests WHERE `site_name`=?";
		$query = $this->db->query($sql, array($site_name));
		return $this->addColumn($query->result_array());
	}
	
	/* 
		USED to check the occurence of request per date 
		NOT USED
	*/
	public function getDateRequestCount($site_id)
	{
		$site_name = $this->getSite_NameByID($site_id);
		$sql = "SELECT activity_date, COUNT(*) as count FROM requests WHERE `site_name`='".$site_name."' GROUP BY activity_date ORDER BY count DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/*
		GET the count of request Date with a count of time in between 12 am - 6 am
	*/
	public function getDateRequestCountAllWindowPeriod()
	{
		//$sql = "SELECT activity_date, COUNT(*) as count FROM requests GROUP BY activity_date ORDER BY count DESC";
		$sql = "SELECT activity_date, COUNT(*) as count FROM requests WHERE start_time > CAST('00:01:00' AS time) AND end_time < CAST('06:00:00' AS time) GROUP BY activity_date ORDER BY count DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/*
	Public function getEvents_OLD2($site_id) // SHOULD BE FILTERED by date or USE GET?POST to catch as  <> pressed
	{
		$site_name = $this->getSite_NameByID($site_id);
		$this->db->from($this->table);
		$this->db->where('site_name', $site_name);
		
		//$this->db->where('_status', '2'); // to display only the Accepted Requests to Calendar App OR else comment this to show all request
        //return $this->db->get()->result_array();
		return $this->addColumn($this->db->get()->result_array());
		//return array('events'=>$this->db->get()->result());
	}
	
	Public function getEvents_with_date($site_id) // SHOULD BE FILTERED by date or USE GET?POST to catch as  <> pressed
	{ 
		$site_name = $this->getSite_NameByID($site_id);
		//$this->db->select("SELECT *, `date` AS `activity_dates`, `activity_date` AS `date`" + " FROM " + $this->table + " WHERE `site_name`=" +$site_name);
		//$this->db->query("SELECT *, `date` AS `activity_dates`, `activity_date` AS `date`" + " FROM " + $this->table);
			
		$query = $this->db->query("SELECT * FROM " + $this->table);
		//return $query->result();
		//$this->db->from();
		//$this->db->where('site_name', $site_name);
		//$this->db->where('_status', '2'); // to display only the Accepted Requests to Calendar App OR else comment this to show all request
        //return $this->db->get()->result_array();
		return $this->addColumn($this->db->get()->result_array());
		//return array('events'=>$this->db->get()->result());
	}
	*/
	
	private function testWindowPeriod($start_time, $end_time)
	{
		if ($start_time == null || $start_time == "") return false;
		if ($end_time == null || $end_time == "") return false;
		
		// $morning1 = DateTime::createFromFormat('H:i a', "12:00 am");
		// $morning2 = DateTime::createFromFormat('H:i a', "6:00 am");
		// $date_start_time = DateTime::createFromFormat('H:i a', (string) $start_time); // 12 am
		// $date_end_time = DateTime::createFromFormat('H:i a', (string) $end_time); // 5:59 am
		
		
		
		$date_start_time = explode(':', $start_time)[0]; // 12 am
		$date_end_time = explode(':', $end_time)[0]; // 5:59 am
		if ($date_start_time >= 0 && $date_end_time < 6)
		    return true;
		else 
			return false;
	}
	
	//_status 
	private function addColumn($array)
	{
		foreach($array as &$tag){
			/* Rename tagging for deleted_by to color */
			$tag['color'] = $tag['deleted_by'];
			unset($tag['deleted_by']);
			
			
			/* Set the color column */
			/*
			if ($tag['_status'] == 0) 
				$color = "#337ab7"; //blue
			else if ($tag['_status'] == 1)
				$color = "#5cb85c"; //green
			else if ($tag['_status'] == 2)
				$color = "#d9534f"; //red
			else if ($tag['_status'] == 3)
				$color = "#f0ad4e"; //orange
			else // NULL
				$color = "#337ab7"; //blue
			*/
			if ($this->testWindowPeriod($tag['start_time'], $tag['end_time']))
				$color = "#d9534f"; //red
			else
				$color = "#337ab7"; //blue
			
			$tag['color'] = $color;
		}
		return $array;
	}
	
	/*
		Get the Site Name by Site ID from sites TABLES
		@return site_name string
	*/
	private function getSite_NameByID($site_id)
	{
		//$this->db->select('site_name');
		$this->db->from('sites');
		$this->db->where('id', $site_id);
    	$query = $this->db->get();
		$data = array();
		foreach($query->result_array() AS $row)
			return $row['site_name'];
	}
	
	/*Create new events */
	Public function addEvent()
	{ 
		$sql = "INSERT INTO " + $this->table + " (title, calendar.date, description, color) VALUES (?,?,?,?)";
		$this->db->query($sql, array($_POST['title'], $_POST['date'], $_POST['description'], $_POST['color']));
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	/*Update  event */
	Public function updateEvent()
	{
		$sql = "UPDATE " + $this->table + " SET title = ?, calendar.date = ?, description = ?, color = ? WHERE id = ?";
		$this->db->query($sql, array($_POST['title'], $_POST['date'], $_POST['description'], $_POST['color'], $_POST['id']));
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	/*Delete event */
	Public function deleteEvent()
	{
		$sql = "DELETE FROM " + $this->table + " WHERE id = ?";
		$this->db->query($sql, array($_GET['id']));
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	/*Update  event */
	Public function dragUpdateEvent()
	{
		$date=date('Y-m-d h:i:s',strtotime($_POST['date']));

		$sql = "UPDATE " + $this->table + " SET  calendar.date = ? WHERE id = ?";
		$this->db->query($sql, array($date, $_POST['id']));
		return ($this->db->affected_rows() != 1) ? false : true; 
	} 

}