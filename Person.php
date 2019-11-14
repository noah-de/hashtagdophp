<?php

class Person {
	private $firstname = "";
	private $lastname = "";
	private $role = "";
	private $email = "";
	private $times_searched = 0;
	private $profile_pic_url = "";

	function __construct() {

	}

	public function setFirstname ($firstname) {
		$this->firstname = $firstname;
	}
	public function getFirstname () {
		return $this->firstname;
	}
	public function setLastname ($lastname) {
		$this->lastname = $lastname;
	}
	public function getLastname () {
		return $this->lastname;
	}
	public function setRole ($role) {
		$this->role = $role;
	}
	public function getRole () {
		return $this->role;
	}
	public function setEmail ($email) {
		$this->email = $email;
	}
	public function getEmail () {
		return $this->email;
	}
	public function setSearchedNum ($searched_num) {
		$this->searched_num = $searched_num;
	}
	public function getSearchedNum () {
		return $this->searched_num;
	}

	public function setProfilePicURL ($profile_pic_url) {
		$this->profile_pic_url = $profile_pic_url;
	}

	public function getProfilePicURL () {
		return this->profile_pic_url;
	}
}

class Student extends Person {
	private $student_id = "";
	private $year = 0;
	private $dorm = "";
	private $room_num = "";
	private $ms_num = 0;
	private $phone_num = "";
	private $primary_contact = "";
	private $roommates = array();


	function __construct($student_id) {
		$this->student_id = $student_id;
	}

	public function getStudentID () {
		return $this->student_id;
	}

	public function setYear ($year) {
		$this->year = $year;
	}
	public function getYear () {
		return $this->year;
	}
	public function setDorm ($dorm) {
		$this->dorm = $dorm;
	}
	public function getDorm () {
		return $this->dorm;
	}
	public function setRoomNum ($room_num) {
		$this->room_num = $room_num;
	}
	public function getRoomNum () {
		return $this->room_num;
	}
	public function setMSNum ($ms_num) {
		$this->ms_num = $ms_num;
	}
	public function getMSNum () {
		return $this->ms_num;
	}
	public function setPhoneNum ($phone_num) {
		$this->phone_num = $phone_num;
	}
	public function getPhoneNum () {
		return $this->phone_num;
	}
	public function setPrimaryContact ($primary_contact) {
		$this->primary_contact = $primary_contact;
	}
	public function getPrimaryContact () {
		return $this->primary_contact;
	}
	// must be passed in as an array
	public function setRoommates ($roommates) {
		$this->roommates = $roommates;
	}
	public function getRoommates () {
		return $this->roommates;
	}
}

class Faculty extends Person {
	
}

class Staff extends Person {
	
}

class StudentHelper extends Student {
	private $db_con = array();
	private $db = "";

	/*
	 * private $student_id = "";
	 * private $firstname = "";
	 * private $lastname = "";
	 * private $role = "";
	 * private $email = "";
	 * private $times_searched = 0;
	 * private $year = 0;
	 * private $dorm = "";
	 * private $room_num = "";
	 * private $ms_num = 0;
	 * private $phone_num = "";
	 * private $primary_contact = "";
	 * private $roommates = array();
	 */

	private function connect_db () {
		$this->db_con['host'] = "bminer-apps";
		$this->db_con['port'] = "5433";
		$this->db_con['user'] = "dophp";
		$this->db_con['password'] = "Nalkerstet!";
		$this->db_con['dbname'] = "dophp";
		$this->db_con['string'] = "host=" . $this->db_con['host'] . " port=" . $this->db_con['port'] . " user=" . $this->db_con['user'] . " password=" . $this->db_con['password'] . " dbname=" . $this->db_con['dbname'];

		$this->db = pg_connect($this->db_con['string']);
	}

	function __construct($student_id) {
		$this->student_id = $student_id;
		$this->connect_db();
	}

	public function get_all () {
		$query_string = "SELECT * FROM person WHERE student_id='" . $this->student_id . "';";
		$prepare_query = pg_query($this->db, $query_string);
		$results = pg_fetch_assoc($prepare_query);
		// $this->firstname = $results['firstname'];
		// echo $this->firstname;
	}

	public function set_all () {
		$person = $this->get_all();
		$this->setFirstname($person['firstname']);
		$this->setLastname($person['lastname']);
		$this->setRole($person['role']);
		$this->setEmail($person['email']);
		$this->setSearchedNum($person['searched_num']);
		$this->setYear($person['year']);
		$this->setDorm($person['dorm']);
		$this->setRoomNum($person['room_num']);
		$this->setMSNum($person['ms_num']);
		$this->setPhoneNum($person['phone_num']);
		$this->setPrimaryContact($person['primary_contact']);
		$this->setRoommates();
	}

	public function setRoommates () {
		$query_string = "SELECT roommate FROM roommate WHERE student='" . $this->student_id . "';";
		$prepare_query = pg_query($this->db, $query_string);
		$roommates = pg_fetch_all($prepare_query); //array of 1 or 2 sids
	}

	public function getRoommateInfo () {
		$roommate_info = array();
		foreach ($this->roommates as $roommate) {
			$query_string = "SELECT firstname, lastname, profile_pic_url FROM person WHERE student_id='" . $roommate . "';";
			$prepare_query = pg_query($this->db, $query_string);
			push($roommate_info, pg_fetch_assoc($prepare_query));
		}
		return $roommate_info;
	}

}

$bryan = new StudentHelper("0523842");
$bryan->get_all();

?>
